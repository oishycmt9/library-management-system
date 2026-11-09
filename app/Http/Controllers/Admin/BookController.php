<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with(['category', 'author', 'publisher'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('book_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('admin.books.create', compact(
            'categories',
            'authors',
            'publishers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'category_id' => 'required|exists:categories,category_id',
            'author_id' => 'required|exists:authors,author_id',
            'publisher_id' => 'required|exists:publishers,publisher_id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $imageFolder = public_path('images/books');

            if (!file_exists($imageFolder)) {
                mkdir($imageFolder, 0755, true);
            }

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move($imageFolder, $imageName);

            $validated['image'] = 'images/books/' . $imageName;
        }

        Book::create($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book added successfully.');
    }

    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('admin.books.edit', compact(
            'book',
            'categories',
            'authors',
            'publishers'
        ));
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore(
                    $book->book_id,
                    'book_id'
                ),
            ],
            'category_id' => 'required|exists:categories,category_id',
            'author_id' => 'required|exists:authors,author_id',
            'publisher_id' => 'required|exists:publishers,publisher_id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {

            $imageFolder = public_path('images/books');

            // Create folder if it does not exist
            if (!file_exists($imageFolder)) {
                mkdir($imageFolder, 0755, true);
            }

            // Delete old image
            if ($book->image) {
                $oldImagePath = public_path($book->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move($imageFolder, $imageName);

            $validated['image'] = 'images/books/' . $imageName;
        }

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        try {
            if ($book->image) {
                $imagePath = public_path($book->image);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $book->delete();

            return redirect()
                ->route('admin.books.index')
                ->with('success', 'Book deleted successfully.');
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.books.index')
                ->with('error', 'This book is linked to other records and cannot be deleted.');
        }
    }
}
