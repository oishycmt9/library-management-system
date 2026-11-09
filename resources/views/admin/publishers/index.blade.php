
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Publisher Management</h4>
                <p class="text-muted mb-0">Manage all book publishers</p>
            </div>

            <a href="{{ route('admin.publishers.create') }}"
               class="btn btn-primary">
                + Add Publisher
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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

                {{-- Search --}}
                <form action="{{ route('admin.publishers.index') }}"
                      method="GET"
                      class="mb-3">

                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search publisher name..."
                            value="{{ request('search') }}"
                        >

                        <button type="submit"
                                class="btn btn-outline-primary">
                            Search
                        </button>

                        <a href="{{ route('admin.publishers.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                {{-- Publisher table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Publisher Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th width="180">Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($publishers as $publisher)
                            <tr>
                                <td>{{ $publisher->publisher_id }}</td>
                                <td>{{ $publisher->publisher_name }}</td>
                                <td>{{ $publisher->address ?: 'N/A' }}</td>
                                <td>{{ $publisher->phone ?: 'N/A' }}</td>

                                <td>
                                    <a
                                        href="{{ route('admin.publishers.edit', $publisher->publisher_id) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.publishers.destroy', $publisher->publisher_id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this publisher?')">

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
                                <td colspan="5" class="text-center py-4">
                                    No publishers found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $publishers->links() }}
                </div>

            </div>
        </div>

    </div>
@endsection
