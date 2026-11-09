<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Get all books
    public function index()
    {
        $books = Book::with(['category', 'author', 'publisher'])->get();

        return response()->json($books, 200);
    }

    // Create a new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'category_id' => 'required|integer|exists:categories,category_id',
            'author_id' => 'required|integer|exists:authors,author_id',
            'publisher_id' => 'required|integer|exists:publishers,publisher_id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
            'status' => 'sometimes|required|string|in:available,unavailable',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    // Get one book
    public function show(string $id)
    {
        $book = Book::with(['category', 'author', 'publisher'])
            ->findOrFail($id);

        return response()->json($book, 200);
    }

    // Update a book
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:200',
            'isbn' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore(
                    $book->book_id,
                    'book_id'
                ),
            ],
            'category_id' => 'sometimes|required|integer|exists:categories,category_id',
            'author_id' => 'sometimes|required|integer|exists:authors,author_id',
            'publisher_id' => 'sometimes|required|integer|exists:publishers,publisher_id',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'image' => 'sometimes|nullable|string|max:255',
            'status' => 'sometimes|required|string|in:available,unavailable',
        ]);

        $book->update($validated);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => $book->fresh(),
        ], 200);
    }

    // Delete a book
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        try {
            $book->delete();

            return response()->json([
                'message' => 'Book deleted successfully',
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'This book cannot be deleted because it is linked to other records.',
            ], 409);
        }
    }
}
