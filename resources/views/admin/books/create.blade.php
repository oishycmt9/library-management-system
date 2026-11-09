
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Add New Book</h4>

                <a href="{{ route('admin.books.index') }}"
                   class="btn btn-secondary">
                    Back to Books
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Book Information</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.books.store') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Book Title *</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       value="{{ old('title') }}"
                                       maxlength="200"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ISBN *</label>
                                <input type="text"
                                       name="isbn"
                                       class="form-control"
                                       value="{{ old('isbn') }}"
                                       maxlength="20"
                                       required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category_id"
                                        class="form-select"
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}"
                                            @selected(old('category_id') == $category->category_id)>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Author *</label>
                                <select name="author_id"
                                        class="form-select"
                                        required>
                                    <option value="">Select Author</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->author_id }}"
                                            @selected(old('author_id') == $author->author_id)>
                                            {{ $author->author_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Publisher *</label>
                                <select name="publisher_id"
                                        class="form-select"
                                        required>
                                    <option value="">Select Publisher</option>
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->publisher_id }}"
                                            @selected(old('publisher_id') == $publisher->publisher_id)>
                                            {{ $publisher->publisher_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price *</label>
                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price') }}"
                                       min="0"
                                       step="0.01"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number"
                                       name="stock_quantity"
                                       class="form-control"
                                       value="{{ old('stock_quantity', 0) }}"
                                       min="0"
                                       required>
                            </div>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Book Cover Image</label>

                                <input
                                    type="file"
                                    name="image"
                                    id="bookImage"
                                    class="form-control"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                                <small class="text-muted">
                                    JPG, PNG or WebP. Maximum 2 MB.
                                </small>

                                <div class="mt-3">
                                    <img
                                        id="imagePreview"
                                        src="#"
                                        alt="Book cover preview"
                                        style="display:none; max-width:160px; max-height:200px; object-fit:contain;"
                                    >
                                </div>
                            </div>

                            <script>
                                document.getElementById('bookImage').addEventListener('change', function () {
                                    const preview = document.getElementById('imagePreview');
                                    const file = this.files[0];

                                    if (file && file.type.startsWith('image/')) {
                                        preview.src = URL.createObjectURL(file);
                                        preview.style.display = 'block';
                                    } else {
                                        preview.removeAttribute('src');
                                        preview.style.display = 'none';
                                    }
                                });
                            </script>


                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status"
                                        class="form-select"
                                        required>
                                    <option value="available"
                                        @selected(old('status', 'available') == 'available')>
                                        Available
                                    </option>
                                    <option value="unavailable"
                                        @selected(old('status') == 'unavailable')>
                                        Unavailable
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="4">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Book
                        </button>

                        <a href="{{ route('admin.books.index') }}"
                           class="btn btn-light">
                            Cancel
                        </a>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
