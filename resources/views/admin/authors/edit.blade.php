
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">
            <h4>Edit Author</h4>
            <p class="text-muted">Update the author information below.</p>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.authors.update', $author->author_id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Author Name --}}
                    <div class="mb-3">
                        <label for="author_name" class="form-label">
                            Author Name
                        </label>

                        <input
                            type="text"
                            id="author_name"
                            name="author_name"
                            class="form-control @error('author_name') is-invalid @enderror"
                            value="{{ old('author_name', $author->author_name) }}"
                            maxlength="100"
                            required
                        >

                        @error('author_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Biography --}}
                    <div class="mb-3">
                        <label for="biography" class="form-label">
                            Biography
                        </label>

                        <textarea
                            id="biography"
                            name="biography"
                            class="form-control @error('biography') is-invalid @enderror"
                            rows="4"
                        >{{ old('biography', $author->biography) }}</textarea>

                        @error('biography')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Author
                    </button>

                    <a href="{{ route('admin.authors.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>
@endsection
