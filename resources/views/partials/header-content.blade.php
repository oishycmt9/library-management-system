
<!-- Mobile Menu and Search Start -->
<div class="me-auto pc-mob-drp">
    <ul class="list-unstyled">

        {{-- Sidebar collapse button --}}
        <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                <i class="ph ph-list"></i>
            </a>
        </li>

        {{-- Mobile sidebar button --}}
        <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                <i class="ph ph-list"></i>
            </a>
        </li>

        {{-- Search --}}
        <li class="dropdown pc-h-item">
            <a
                class="pc-head-link dropdown-toggle arrow-none m-0"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                aria-expanded="false"
            >
                <i class="ph ph-magnifying-glass"></i>
            </a>

            <div class="dropdown-menu pc-h-dropdown drp-search">
                <form class="px-3" action="#" method="GET">
                    <div class="form-group mb-0 d-flex align-items-center">
                        <input
                            type="search"
                            name="search"
                            class="form-control border-0 shadow-none"
                            placeholder="Search here..."
                        />
                        <button type="submit" class="btn btn-light-secondary btn-search">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </li>

    </ul>
</div>
<!-- Mobile Menu and Search End -->


<!-- User Profile Start -->
<div class="ms-auto">
    <ul class="list-unstyled">
        <li class="dropdown pc-h-item header-user-profile">

            <a
                class="pc-head-link dropdown-toggle arrow-none me-0"
                data-bs-toggle="dropdown"
                href="#"
                role="button"
                data-bs-auto-close="outside"
                aria-expanded="false"
            >
                <img
                    src="{{ asset('admin/assets/images/user/avatar-2.jpg') }}"
                    alt="User profile"
                    class="user-avtar"
                />
            </a>

            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-body">
                    <div
                        class="profile-notification-scroll position-relative"
                        style="max-height: calc(100vh - 225px)"
                    >
                        <ul class="list-group list-group-flush w-100">

                            <li class="list-group-item">
                                <a href="#" class="dropdown-item">
                                    <span class="d-flex align-items-center">
                                        <i class="ph ph-user-circle"></i>
                                        <span>My Profile</span>
                                    </span>
                                </a>

                                <a href="#" class="dropdown-item">
                                    <span class="d-flex align-items-center">
                                        <i class="ph ph-gear-six"></i>
                                        <span>Settings</span>
                                    </span>
                                </a>
                            </li>

                            <li class="list-group-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start">
                                        <span class="d-flex align-items-center">
                                            <i class="ph ph-power"></i>
                                            <span>Logout</span>
                                        </span>
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </li>
    </ul>
</div>
<!-- User Profile End -->

