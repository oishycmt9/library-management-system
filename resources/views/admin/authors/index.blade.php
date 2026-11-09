
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Author Management</h4>
                <p class="text-muted mb-0">Manage all book authors</p>
            </div>

            <a href="{{ route('admin.authors.create') }}"
               class="btn btn-primary">
                + Add Author
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error message --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                {{-- Search form --}}
                <form action="{{ route('admin.authors.index') }}"
                      method="GET" class="mb-3">

                    <div class="input-group">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search author name..."
                               value="{{ request('search') }}">

                        <button class="btn btn-outline-primary"
                                type="submit">
                            Search
                        </button>

                        <a href="{{ route('admin.authors.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                {{-- Authors table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Author Name</th>
                            <th>Biography</th>
                            <th width="180">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($authors as $author)
                            <tr>
                                <td>{{ $author->author_id }}</td>

                                <td>
                                    {{ $author->author_name }}
                                </td>

                                <td>
                                    {{ $author->biography ?: 'N/A' }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.authors.edit', $author->author_id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.authors.destroy', $author->author_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this author?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center py-4">
                                    No authors found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $authors->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
