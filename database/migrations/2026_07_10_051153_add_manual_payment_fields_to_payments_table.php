<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['bank_transfer', 'qris', 'cod'])
                ->default('bank_transfer')
                ->after('amount');

            $table->string('sender_name')
                ->nullable()
                ->after('payment_method');

            $table->string('sender_bank')
                ->nullable()
                ->after('sender_name');

            $table->text('note')
                ->nullable()
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'sender_name',
                'sender_bank',
                'note',
            ]);
        });
    }
};