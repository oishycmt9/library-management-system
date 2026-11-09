<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where('category_name', 'like', "%{$search}%");
            })
            ->orderByDesc('category_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category added successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'This category may be linked to books and cannot be deleted.');
        }
    }
}
