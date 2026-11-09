
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Home - Library Management System</title>
</head>
<body>
<h1>Welcome to Library Management System</h1>
<p>You are logged in successfully.</p>
<img src="{{ asset('images/home/library-management-system.png') }}"
     alt="Library Banner"
     style="width: 100%; height: 500px; object-fit: cover;">

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>
