<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Read all categories
    public function index()
    {
        return response()->json(Category::all());
    }

    // 2. Create a category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    // 3. Read one category
    public function show(string $id)
    {
        return response()->json(
            Category::findOrFail($id)
        );
    }

    // 4. Update a category
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'category_name' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    // 5. Delete a category
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
