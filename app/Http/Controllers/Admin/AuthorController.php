<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::query()
            ->when($request->search, function ($query, $search) {
                $query->where('author_name', 'like', "%{$search}%");
            })
            ->orderByDesc('author_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'biography' => 'nullable|string',
        ]);

        Author::create($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author added successfully.');
    }

    public function edit(string $id)
    {
        $author = Author::findOrFail($id);

        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, string $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'biography' => 'nullable|string',
        ]);

        $author->update($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with('success', 'Author updated successfully.');
    }

    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);

        try {
            $author->delete();

            return redirect()
                ->route('admin.authors.index')
                ->with('success', 'Author deleted successfully.');
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.authors.index')
                ->with('error', 'This author is linked to books and cannot be deleted.');
        }
    }
}
