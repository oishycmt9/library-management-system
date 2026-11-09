<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Get all authors
    public function index()
    {
        return response()->json(Author::all());
    }

    // Create author
    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'biography' => 'nullable|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Author created successfully',
            'data' => $author,
        ], 201);
    }

    // Get single author
    public function show(string $id)
    {
        $author = Author::findOrFail($id);

        return response()->json($author);
    }

    // Update author
    public function update(Request $request, string $id)
    {
        $author = Author::findOrFail($id);

        $validated = $request->validate([
            'author_name' => 'sometimes|required|string|max:100',
            'biography' => 'sometimes|nullable|string',
        ]);

        $author->update($validated);

        return response()->json([
            'message' => 'Author updated successfully',
            'data' => $author,
        ]);
    }

    // Delete author
    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);

        try {
            $author->delete();

            return response()->json([
                'message' => 'Author deleted successfully',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'This author may be linked to books and cannot be deleted.',
            ], 409);
        }
    }
}
