<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PublisherController extends Controller
{
    // Get all publishers
    public function index()
    {
        return response()->json(Publisher::all(), 200);
    }

    // Create a new publisher
    public function store(Request $request)
    {
        $validated = $request->validate([
            'publisher_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $publisher = Publisher::create($validated);

        return response()->json([
            'message' => 'Publisher created successfully',
            'data' => $publisher,
        ], 201);
    }

    // Get one publisher
    public function show(string $id)
    {
        $publisher = Publisher::findOrFail($id);

        return response()->json($publisher, 200);
    }

    // Update a publisher
    public function update(Request $request, string $id)
    {
        $publisher = Publisher::findOrFail($id);

        $validated = $request->validate([
            'publisher_name' => 'sometimes|required|string|max:100',
            'address' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:30',
        ]);

        $publisher->update($validated);

        return response()->json([
            'message' => 'Publisher updated successfully',
            'data' => $publisher->fresh(),
        ], 200);
    }

    // Delete a publisher
    public function destroy(string $id)
    {
        $publisher = Publisher::findOrFail($id);

        try {
            $publisher->delete();

            return response()->json([
                'message' => 'Publisher deleted successfully',
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'This publisher is linked to books and cannot be deleted.',
            ], 409);
        }
    }
}
