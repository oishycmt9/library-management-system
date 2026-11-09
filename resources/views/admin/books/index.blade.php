
@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-12">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Book Management</h4>
                    <p class="text-muted mb-0">Manage your Books</p>
                </div>

                <a href="{{ route('admin.books.create') }}"
                   class="btn btn-primary">
                    <i class="ti ti-plus"></i> + Add Book
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Book List --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Books</h5>
                </div>

                <div class="card-body">

                    {{-- Search --}}
                    <form method="GET"
                          action="{{ route('admin.books.index') }}"
                          class="mb-4">

                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search by book title or ISBN"
                                value="{{ request('search') }}"
                            >

                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>

                            <a href="{{ route('admin.books.index') }}"
                               class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </form>

                    {{-- Responsive Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th style="min-width: 150px;">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td>{{ $book->book_id }}</td>

                                    <td>
                                        @if($book->image && file_exists(public_path($book->image)))
                                            <img src="{{ asset($book->image) }}"
                                                 alt="{{ $book->title }}"
                                                 width="70"
                                                 height="90"
                                                 style="object-fit: cover;">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $book->title }}</td>

                                    <td>{{ $book->isbn }}</td>

                                    <td>
                                        {{ $book->category?->category_name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $book->author?->author_name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $book->publisher?->publisher_name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ number_format((float) $book->price, 2) }}
                                    </td>

                                    <td>{{ $book->stock_quantity }}</td>

                                    <td>
                                        @if($book->status === 'available')
                                            <span class="badge bg-success">
                                                Available
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Unavailable
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a
                                                href="{{ route('admin.books.edit', $book->book_id) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.books.destroy', $book->book_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this book?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10"
                                        class="text-center py-4 text-muted">
                                        <i class="ti ti-book-off"></i>
                                        No books found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end mt-3">
                        {{ $books->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
