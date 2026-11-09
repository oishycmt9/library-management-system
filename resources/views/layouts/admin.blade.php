
<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head-page-meta')

    @include('partials.head-css')
</head>

<body>

@include('partials.loader')

@include('partials.sidebar')

@include('partials.topbar')

<!-- Main Content Start -->
<div class="pc-container">
    <div class="pc-content">
        @yield('content')
    </div>
</div>
<!-- Main Content End -->

@include('partials.footer-block')

@include('partials.footer-js')

</body>

</html>

