<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('maintenance_updates', function (Blueprint $table) {
        $table->id();

        $table->foreignId('maintenance_report_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('technician_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->text('note');

        $table->enum('status', [
            'assigned',
            'in_progress',
            'completed',
        ]);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_updates');
    }
};
