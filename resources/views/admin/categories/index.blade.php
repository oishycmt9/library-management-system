
@extends('layouts.admin')

@section('title', 'Category Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Category Management</h4>
            <p class="text-muted mb-0">Manage your book categories</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-primary">
            <i class="ti ti-plus"></i> + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

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
            <h5 class="mb-3">All Categories</h5>

            <form method="GET"
                  action="{{ route('admin.categories.index') }}"
                  class="d-flex gap-2">
                <input type="text" name="search"
                       class="form-control"
                       placeholder="Search category..."
                       value="{{ request('search') }}">

                <button class="btn btn-outline-primary"
                        type="submit">Search</button>

                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-outline-secondary">Reset</a>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->category_id }}</td>
                            <td>
                                <span class="fw-semibold">
                                    {{ $category->category_name }}
                                </span>
                            </td>
                            <td>
                                {{ $category->description ?: '—' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.categories.edit', $category->category_id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.categories.destroy', $category->category_id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="text-center text-muted py-4">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
