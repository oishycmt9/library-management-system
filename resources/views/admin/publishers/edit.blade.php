
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">
            <h4>Edit Publisher</h4>
            <p class="text-muted">Update publisher information below.</p>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.publishers.update', $publisher->publisher_id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Publisher Name --}}
                    <div class="mb-3">
                        <label for="publisher_name" class="form-label">
                            Publisher Name
                        </label>

                        <input
                            type="text"
                            id="publisher_name"
                            name="publisher_name"
                            class="form-control @error('publisher_name') is-invalid @enderror"
                            value="{{ old('publisher_name', $publisher->publisher_name) }}"
                            maxlength="100"
                            required
                        >

                        @error('publisher_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label for="address" class="form-label">
                            Address
                        </label>

                        <input
                            type="text"
                            id="address"
                            name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address', $publisher->address) }}"
                            maxlength="255"
                        >

                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $publisher->phone) }}"
                            maxlength="30"
                        >

                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Publisher
                    </button>

                    <a href="{{ route('admin.publishers.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>
@endsection
