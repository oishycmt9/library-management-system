
@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">Edit Book</h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('admin.books.update', $book->book_id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Book Title</label>
                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ old('title', $book->title) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ISBN</label>
                                <input
                                    type="text"
                                    name="isbn"
                                    class="form-control"
                                    value="{{ old('isbn', $book->isbn) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category ID</label>
                                <input
                                    type="number"
                                    name="category_id"
                                    class="form-control"
                                    value="{{ old('category_id', $book->category_id) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Author ID</label>
                                <input
                                    type="number"
                                    name="author_id"
                                    class="form-control"
                                    value="{{ old('author_id', $book->author_id) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Publisher ID</label>
                                <input
                                    type="number"
                                    name="publisher_id"
                                    class="form-control"
                                    value="{{ old('publisher_id', $book->publisher_id) }}"
                                    required
                                >
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="4"
                                >{{ old('description', $book->description) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input
                                    type="number"
                                    name="price"
                                    class="form-control"
                                    step="0.01"
                                    min="0"
                                    value="{{ old('price', $book->price) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity</label>
                                <input
                                    type="number"
                                    name="stock_quantity"
                                    class="form-control"
                                    min="0"
                                    value="{{ old('stock_quantity', $book->stock_quantity) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select
                                    name="status"
                                    class="form-select"
                                    required
                                >
                                    <option value="available"
                                        {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>
                                        Available
                                    </option>

                                    <option value="unavailable"
                                        {{ old('status', $book->status) == 'unavailable' ? 'selected' : '' }}>
                                        Unavailable
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Current Book Cover</label>

                                @if ($book->image)
                                    <div class="mb-3">
                                        <img
                                            src="{{ asset('storage/' . $book->image) }}"
                                            alt="Book Cover"
                                            class="img-thumbnail"
                                            style="width: 150px; height: auto;"
                                        >
                                    </div>
                                @else
                                    <p class="text-muted">No image uploaded.</p>
                                @endif

                                <label class="form-label">Change Book Cover</label>
                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    accept="image/*"
                                >
                                <small class="text-muted">
                                    Leave empty to keep the current image.
                                </small>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update Book
                        </button>

                        <a href="{{ route('admin.books.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
