<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('bank_transfer', 'qris', 'cod') DEFAULT 'bank_transfer'");

        DB::statement("ALTER TABLE payments MODIFY payment_proof VARCHAR(255) NULL");
    }

    public function down(): void
    {
        DB::table('payments')
            ->where('payment_method', 'cod')
            ->update([
                'payment_method' => 'bank_transfer',
                'payment_proof' => '',
            ]);

        DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('bank_transfer', 'qris') DEFAULT 'bank_transfer'");

        DB::statement("ALTER TABLE payments MODIFY payment_proof VARCHAR(255) NOT NULL");
    }
};