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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_item_id');
            $table->foreignId('cart_id')
                ->constrained('carts', 'cart_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('book_id')
                ->constrained('books', 'book_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
