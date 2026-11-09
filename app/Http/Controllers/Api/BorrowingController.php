<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    // GET /api/borrowings
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->get();

        return response()->json([
            'success' => true,
            'data' => $borrowings,
        ], 200);
    }

    // POST /api/borrowings
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'book_id' => 'required|exists:books,book_id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|required_if:status,returned|date|after_or_equal:borrow_date',
            'status' => [
                'required',
                Rule::in(['borrowed', 'returned', 'overdue']),
            ],
        ]);

        $borrowing = DB::transaction(function () use ($validated) {
            $book = Book::where('book_id', $validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Only active borrowings reduce stock.
            if ($validated['status'] !== 'returned') {
                if ($book->stock_quantity < 1) {
                    throw ValidationException::withMessages([
                        'book_id' => 'This book is out of stock.',
                    ]);
                }

                $book->decrement('stock_quantity');
            }

            return Borrowing::create($validated);
        });

        return response()->json([
            'success' => true,
            'message' => 'Borrowing created successfully!',
            'data' => $borrowing->load(['user', 'book']),
        ], 201);
    }

    // GET /api/borrowings/{id}
    public function show(string $id)
    {
        $borrowing = Borrowing::with(['user', 'book'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $borrowing,
        ], 200);
    }

    // PUT/PATCH /api/borrowings/{id}
    public function update(Request $request, string $id)
    {
        $borrowing = DB::transaction(function () use ($request, $id) {
            $borrowing = Borrowing::where('borrowing_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $validated = $request->validate([
                'user_id' => 'sometimes|required|exists:users,user_id',
                'book_id' => 'sometimes|required|exists:books,book_id',
                'borrow_date' => 'sometimes|required|date',
                'due_date' => 'sometimes|required|date',
                'return_date' => 'sometimes|nullable|required_if:status,returned|date|after_or_equal:borrow_date',
                'status' => [
                    'sometimes',
                    'required',
                    Rule::in(['borrowed', 'returned', 'overdue']),
                ],
            ]);

            $oldBookId = (int) $borrowing->book_id;
            $newBookId = (int) ($validated['book_id'] ?? $oldBookId);

            $wasActive = $borrowing->status !== 'returned';
            $newStatus = $validated['status'] ?? $borrowing->status;
            $willBeActive = $newStatus !== 'returned';

            // Lock books in a consistent order when changing book.
            $bookIds = array_unique([$oldBookId, $newBookId]);
            sort($bookIds);

            $books = [];

            foreach ($bookIds as $bookId) {
                $books[$bookId] = Book::where('book_id', $bookId)
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            $oldBook = $books[$oldBookId];
            $newBook = $books[$newBookId];

            // Active borrowing -> returned: restore one copy.
            if ($wasActive && ! $willBeActive) {
                $oldBook->increment('stock_quantity');
            }

            // Returned -> active borrowing: consume one copy.
            if (! $wasActive && $willBeActive) {
                if ($newBook->stock_quantity < 1) {
                    throw ValidationException::withMessages([
                        'book_id' => 'This book is out of stock.',
                    ]);
                }

                $newBook->decrement('stock_quantity');
            }

            // Change the book on an active borrowing.
            if (
                $wasActive &&
                $willBeActive &&
                $oldBookId !== $newBookId
            ) {
                if ($newBook->stock_quantity < 1) {
                    throw ValidationException::withMessages([
                        'book_id' => 'This book is out of stock.',
                    ]);
                }

                $oldBook->increment('stock_quantity');
                $newBook->decrement('stock_quantity');
            }

            $borrowing->update($validated);

            return $borrowing->fresh()->load(['user', 'book']);
        });

        return response()->json([
            'success' => true,
            'message' => 'Borrowing updated successfully!',
            'data' => $borrowing,
        ], 200);
    }

    // DELETE /api/borrowings/{id}
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $borrowing = Borrowing::where('borrowing_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $book = Book::where('book_id', $borrowing->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Restore stock only if the borrowing is still active.
            if ($borrowing->status !== 'returned') {
                $book->increment('stock_quantity');
            }

            $borrowing->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Borrowing deleted successfully!',
        ], 200);
    }
}
