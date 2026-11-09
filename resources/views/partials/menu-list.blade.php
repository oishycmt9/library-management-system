
{{-- Navigation --}}
<li class="pc-item pc-caption">
    <label></label>
</li>

{{-- Dashboard --}}
<li class="pc-item">
    <a href="{{ url('/admin/dashboard') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-gauge"></i>
        </span>
        <span class="pc-mtext">Dashboard</span>
    </a>
</li>

{{-- Library Management --}}
<li class="pc-item pc-caption">
    <label>Library Management</label>
    <i class="ph ph-books"></i>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/books') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-book-open"></i>
        </span>
        <span class="pc-mtext">Books</span>
    </a>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/categories') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-folders"></i>
        </span>
        <span class="pc-mtext">Categories</span>
    </a>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/authors') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-user-list"></i>
        </span>
        <span class="pc-mtext">Authors</span>
    </a>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/publishers') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-buildings"></i>
        </span>
        <span class="pc-mtext">Publishers</span>
    </a>
</li>

{{-- Sales and Orders --}}
<li class="pc-item pc-caption">
    <label>Sales Management</label>
    <i class="ph ph-shopping-cart"></i>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/orders') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-receipt"></i>
        </span>
        <span class="pc-mtext">Orders</span>
    </a>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/payments') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-credit-card"></i>
        </span>
        <span class="pc-mtext">Payments</span>
    </a>
</li>

{{-- Borrowing --}}
<li class="pc-item pc-caption">
    <label>Borrowing Management</label>
</li>

<li class="pc-item">
    <a href="{{ url('/admin/borrowings') }}" class="pc-link">
        <span class="pc-micon">
            <i class="ph ph-calendar-check"></i>
        </span>
        <span class="pc-mtext">Borrowings</span>
    </a>
</li>

