
@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Edit Borrowing #{{ $borrowing->borrowing_id }}</h4>

                <a href="{{ route('admin.borrowings.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.borrowings.update', $borrowing->borrowing_id) }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>

                            <select name="user_id" id="user_id"
                                    class="form-select" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}"
                                        @selected(old('user_id', $borrowing->user_id) == $user->user_id)>
                                        {{ $user->name }} (ID: {{ $user->user_id }})
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="book_id" class="form-label">Book</label>

                            <select name="book_id" id="book_id"
                                    class="form-select" required>
                                @foreach($books as $book)
                                    <option value="{{ $book->book_id }}"
                                        @selected(old('book_id', $borrowing->book_id) == $book->book_id)>
                                        {{ $book->title }} (ID: {{ $book->book_id }})
                                    </option>
                                @endforeach
                            </select>

                            @error('book_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="borrow_date" class="form-label">
                                Borrow Date
                            </label>

                            <input type="date" name="borrow_date" id="borrow_date"
                                   class="form-control"
                                   value="{{ old('borrow_date', $borrowing->borrow_date) }}"
                                   required>

                            @error('borrow_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>

                            <input type="date" name="due_date" id="due_date"
                                   class="form-control"
                                   value="{{ old('due_date', $borrowing->due_date) }}"
                                   required>

                            @error('due_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="return_date" class="form-label">
                                Return Date (Optional)
                            </label>

                            <input type="date" name="return_date" id="return_date"
                                   class="form-control"
                                   value="{{ old('return_date', $borrowing->return_date) }}">

                            @error('return_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>

                            <select name="status" id="status"
                                    class="form-select" required>
                                <option value="borrowed"
                                    @selected(old('status', $borrowing->status) == 'borrowed')>
                                    Borrowed
                                </option>

                                <option value="returned"
                                    @selected(old('status', $borrowing->status) == 'returned')>
                                    Returned
                                </option>

                                <option value="overdue"
                                    @selected(old('status', $borrowing->status) == 'overdue')>
                                    Overdue
                                </option>
                            </select>

                            @error('status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Update Borrowing
                        </button>

                        <a href="{{ route('admin.borrowings.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
