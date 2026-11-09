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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title', 200);
            $table->string('isbn', 20)->unique();

            $table->foreignId('category_id')
                ->constrained('categories', 'category_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('author_id')
                ->constrained('authors', 'author_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('publisher_id')
                ->constrained('publishers', 'publisher_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->string('image', 255)->nullable();
            $table->string('status', 20)->default('available');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
