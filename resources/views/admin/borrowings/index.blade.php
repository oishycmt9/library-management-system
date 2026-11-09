
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Borrowing Management</h4>

                <a href="{{ route('admin.borrowings.create') }}"
                   class="btn btn-primary">
                    + Add Borrowing
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.borrowings.index') }}"
                  method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Search user or book..."
                           value="{{ request('search') }}">

                    <button class="btn btn-primary" type="submit">
                        Search
                    </button>

                    <a href="{{ route('admin.borrowings.index') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->borrowing_id }}</td>

                                <td>
                                    {{ $borrowing->user->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $borrowing->book->title ?? 'N/A' }}
                                </td>

                                <td>{{ $borrowing->borrow_date }}</td>
                                <td>{{ $borrowing->due_date }}</td>

                                <td>
                                    {{ $borrowing->return_date ?? 'Not returned' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($borrowing->status) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.borrowings.edit', $borrowing->borrowing_id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.borrowings.destroy', $borrowing->borrowing_id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this borrowing record?')">
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
                                <td colspan="8" class="text-center">
                                    No borrowing records found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $borrowings->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
