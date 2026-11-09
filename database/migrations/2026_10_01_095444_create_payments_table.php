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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('order_id')
                ->constrained('orders', 'order_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('payment_method', 30);
            $table->string('transaction_id', 100)->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_status', 30)->default('pending');
            $table->timestamp('payment_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
