<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })->orWhereHas('book', function ($bookQuery) use ($search) {
                        $bookQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('borrowing_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $users = User::all();
        $books = Book::all();

        return view('admin.borrowings.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'book_id' => 'required|exists:books,book_id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|required_if:status,returned|date|after_or_equal:borrow_date',
            'status' => 'required|in:borrowed,returned,overdue',
        ]);

        DB::transaction(function () use ($validated) {

            $book = Book::where('book_id', $validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // A book that has not been returned must be in stock.
            if ($validated['status'] !== 'returned') {

                if ($book->stock_quantity < 1) {
                    throw ValidationException::withMessages([
                        'book_id' => 'This book is out of stock.',
                    ]);
                }

                $book->decrement('stock_quantity');
            }
            Borrowing::create($validated);
        });

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Borrowing record added successfully.');
    }

    public function edit(string $id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $users = User::all();
        $books = Book::all();

        return view(
            'admin.borrowings.edit',
            compact('borrowing', 'users', 'books')
        );
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'book_id' => 'required|exists:books,book_id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|required_if:status,returned|date|after_or_equal:borrow_date',
            'status' => 'required|in:borrowed,returned,overdue',
        ]);

        DB::transaction(function () use ($validated, $id) {

            $borrowing = Borrowing::where('borrowing_id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldBookId = $borrowing->book_id;
            $newBookId = (int) $validated['book_id'];

            $wasActive = $borrowing->status !== 'returned';
            $willBeActive = $validated['status'] !== 'returned';

            $oldBook = Book::where('book_id', $oldBookId)
                ->lockForUpdate()
                ->firstOrFail();

            $newBook = $oldBookId == $newBookId
                ? $oldBook
                : Book::where('book_id', $newBookId)
                    ->lockForUpdate()
                    ->firstOrFail();

            if ($wasActive && ! $willBeActive) {
                $oldBook->increment('stock_quantity');
            }

            if (! $wasActive && $willBeActive) {
                if ($newBook->stock_quantity < 1) {
                    throw ValidationException::withMessages([
                        'book_id' => 'This book is out of stock.',
                    ]);
                }

                $newBook->decrement('stock_quantity');
            }
            if (
                $wasActive &&
                $willBeActive &&
                $oldBookId != $newBookId
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
        });

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Borrowing record updated successfully.');
    }

    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {

                $borrowing = Borrowing::where('borrowing_id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($borrowing->status !== 'returned') {
                    $book = Book::where(
                        'book_id',
                        $borrowing->book_id
                    )->lockForUpdate()->firstOrFail();

                    $book->increment('stock_quantity');
                }

                $borrowing->delete();
            });

            return redirect()
                ->route('admin.borrowings.index')
                ->with('success', 'Borrowing record deleted successfully.');

        } catch (QueryException $e) {
            return redirect()
                ->route('admin.borrowings.index')
                ->with('error', 'This borrowing record cannot be deleted.');
        }
    }
}
