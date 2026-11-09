<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PublisherController extends Controller
{
    // Display publishers with search and pagination
    public function index(Request $request)
    {
        $publishers = Publisher::query()
            ->when($request->search, function ($query, $search) {
                $query->where('publisher_name', 'like', "%{$search}%");
            })
            ->orderByDesc('publisher_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'publisher_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        Publisher::create($validated);

        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher added successfully.');
    }

    public function edit(string $id)
    {
        $publisher = Publisher::findOrFail($id);

        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, string $id)
    {
        $publisher = Publisher::findOrFail($id);

        $validated = $request->validate([
            'publisher_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $publisher->update($validated);

        return redirect()
            ->route('admin.publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    public function destroy(string $id)
    {
        $publisher = Publisher::findOrFail($id);

        try {
            $publisher->delete();

            return redirect()
                ->route('admin.publishers.index')
                ->with('success', 'Publisher deleted successfully.');
        } catch (QueryException $e) {
            return redirect()
                ->route('admin.publishers.index')
                ->with('error', 'This publisher may be linked to books and cannot be deleted.');
        }
    }
}
