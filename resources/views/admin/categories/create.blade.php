
@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="mb-4">
        <h4>Add Category</h4>
        <p class="text-muted">Create a new book category</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Category Information</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}"
                  method="POST">
                @csrf

                <div class="mb-3">
                    <label for="category_name" class="form-label">
                        Category Name <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="category_name"
                           name="category_name"
                           class="form-control @error('category_name') is-invalid @enderror"
                           value="{{ old('category_name') }}"
                           maxlength="100" required>

                    @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea id="description" name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4">{{ old('description') }}</textarea>

                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Category
                </button>

                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
@endsection
