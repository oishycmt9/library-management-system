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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id('borrowing_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('book_id')
                ->constrained('books', 'book_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->string('status', 30)->default('borrowed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
