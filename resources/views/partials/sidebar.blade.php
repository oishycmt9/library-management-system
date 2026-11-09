
<!-- Sidebar Menu Start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">


        <div class="m-header">
            <a href="{{ url('/admin/dashboard') }}"
               class="b-brand text-decoration-none"
               style="display: block; color: #ffffff !important; white-space: normal;">

        <span style="font-size: 18px; font-weight: 700;">
            📚 Library Management
        </span>

            </a>
        </div>


        <div class="navbar-content">
            <ul class="pc-navbar">
                @include('partials.menu-list')
            </ul>

            <div class="card nav-action-card bg-brand-color-1">
                <div
                    class="card-body"
                    style="background-image: url('{{ asset('admin/assets/images/layout/nav-card-bg.svg') }}')"
                >
                    <h5 class="text-white">Library Management System</h5>
                    <p class="text-white text-opacity-75">
                        Manage books, authors, categories and orders.
                    </p>
                </div>
            </div>
        </div>

    </div>
</nav>
<!-- Sidebar Menu End -->

