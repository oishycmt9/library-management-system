
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <!-- Page Heading -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Library Dashboard</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mt-4">

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">Total Books</h6>
                    <h3 class="mb-0">{{ $totalBooks }}</h3>
                    <p class="text-muted mb-0">Books in library</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">Categories</h6>
                    <h3 class="mb-0">{{ $totalCategories }}</h3>
                    <p class="text-muted mb-0">Book categories</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">Total Orders</h6>
                    <h3 class="mb-0">{{ $totalOrders }}</h3>
                    <p class="text-muted mb-0">Book purchase orders</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2">Borrowings</h6>
                    <h3 class="mb-0">{{ $totalBorrowings }}</h3>
                    <p class="text-muted mb-0">Borrowing records</p>
                </div>
            </div>
        </div>

    </div>

@endsection
