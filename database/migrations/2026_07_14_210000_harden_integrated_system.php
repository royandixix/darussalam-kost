<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->removeDuplicatePayments();
        $this->removeDuplicateFeedbacks();

        Schema::table('payments', function (Blueprint $table): void {
            $table->unique('booking_id', 'payments_booking_id_unique');
            $table->index('status', 'payments_status_index');
        });

        Schema::table('feedbacks', function (Blueprint $table): void {
            $table->unique('booking_id', 'feedbacks_booking_id_unique');
            $table->index(['user_id', 'is_published'], 'feedbacks_user_published_index');
        });

        Schema::table('bookings', function (Blueprint $table): void {
            $table->index(['room_id', 'status'], 'bookings_room_status_index');
            $table->index(['user_id', 'status'], 'bookings_user_status_index');
        });

        Schema::table('maintenance_reports', function (Blueprint $table): void {
            $table->foreignId('assigned_technician_id')
                ->nullable()
                ->after('room_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->index(['assigned_technician_id', 'status'], 'maintenance_technician_status_index');
            $table->index(['user_id', 'status'], 'maintenance_user_status_index');
        });

        Schema::table('tenants', function (Blueprint $table): void {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('booking_id')
                ->nullable()
                ->after('user_id')
                ->constrained('bookings')
                ->nullOnDelete();
        });

        $this->backfillTenantRelations();

        Schema::table('tenants', function (Blueprint $table): void {
            $table->unique('booking_id', 'tenants_booking_id_unique');
            $table->index(['room_id', 'status'], 'tenants_room_status_index');
            $table->index(['user_id', 'status'], 'tenants_user_status_index');
        });

        if (DB::getDriverName() === 'mysql') {
            $this->protectHistoricalRoomRelations();
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            $this->restoreHistoricalRoomCascades();
        }

        Schema::table('tenants', function (Blueprint $table): void {
            $table->dropUnique('tenants_booking_id_unique');
            $table->dropIndex('tenants_room_status_index');
            $table->dropIndex('tenants_user_status_index');
            $table->dropConstrainedForeignId('booking_id');
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('maintenance_reports', function (Blueprint $table): void {
            $table->dropIndex('maintenance_technician_status_index');
            $table->dropIndex('maintenance_user_status_index');
            $table->dropConstrainedForeignId('assigned_technician_id');
        });

        Schema::table('bookings', function (Blueprint $table): void {
            $table->dropIndex('bookings_room_status_index');
            $table->dropIndex('bookings_user_status_index');
        });

        Schema::table('feedbacks', function (Blueprint $table): void {
            $table->dropUnique('feedbacks_booking_id_unique');
            $table->dropIndex('feedbacks_user_published_index');
        });

        Schema::table('payments', function (Blueprint $table): void {
            $table->dropUnique('payments_booking_id_unique');
            $table->dropIndex('payments_status_index');
        });
    }

    private function removeDuplicatePayments(): void
    {
        DB::table('payments')
            ->select('booking_id', DB::raw('MAX(id) as keep_id'))
            ->groupBy('booking_id')
            ->havingRaw('COUNT(*) > 1')
            ->orderBy('booking_id')
            ->each(function (object $duplicate): void {
                DB::table('payments')
                    ->where('booking_id', $duplicate->booking_id)
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();
            });
    }

    private function removeDuplicateFeedbacks(): void
    {
        DB::table('feedbacks')
            ->select('booking_id', DB::raw('MAX(id) as keep_id'))
            ->whereNotNull('booking_id')
            ->groupBy('booking_id')
            ->havingRaw('COUNT(*) > 1')
            ->orderBy('booking_id')
            ->each(function (object $duplicate): void {
                DB::table('feedbacks')
                    ->where('booking_id', $duplicate->booking_id)
                    ->where('id', '!=', $duplicate->keep_id)
                    ->delete();
            });
    }

    private function backfillTenantRelations(): void
    {
        DB::table('tenants')
            ->orderBy('id')
            ->each(function (object $tenant): void {
                $userId = null;
                $bookingId = null;

                if (! empty($tenant->email)) {
                    $userId = DB::table('users')
                        ->where('email', $tenant->email)
                        ->value('id');
                }

                if ($userId && $tenant->room_id) {
                    $bookingId = DB::table('bookings')
                        ->where('user_id', $userId)
                        ->where('room_id', $tenant->room_id)
                        ->whereIn('status', ['approved', 'completed'])
                        ->whereNotIn('id', function ($query): void {
                            $query->select('booking_id')
                                ->from('tenants')
                                ->whereNotNull('booking_id');
                        })
                        ->latest('id')
                        ->value('id');
                }

                DB::table('tenants')
                    ->where('id', $tenant->id)
                    ->update([
                        'user_id' => $userId,
                        'booking_id' => $bookingId,
                    ]);
            });
    }

    private function protectHistoricalRoomRelations(): void
    {
        DB::statement('ALTER TABLE bookings DROP FOREIGN KEY bookings_room_id_foreign');
        DB::statement('ALTER TABLE bookings ADD CONSTRAINT bookings_room_id_foreign FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE RESTRICT');

        DB::statement('ALTER TABLE maintenance_reports DROP FOREIGN KEY maintenance_reports_room_id_foreign');
        DB::statement('ALTER TABLE maintenance_reports ADD CONSTRAINT maintenance_reports_room_id_foreign FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE RESTRICT');
    }

    private function restoreHistoricalRoomCascades(): void
    {
        DB::statement('ALTER TABLE bookings DROP FOREIGN KEY bookings_room_id_foreign');
        DB::statement('ALTER TABLE bookings ADD CONSTRAINT bookings_room_id_foreign FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE');

        DB::statement('ALTER TABLE maintenance_reports DROP FOREIGN KEY maintenance_reports_room_id_foreign');
        DB::statement('ALTER TABLE maintenance_reports ADD CONSTRAINT maintenance_reports_room_id_foreign FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE');
    }
};
