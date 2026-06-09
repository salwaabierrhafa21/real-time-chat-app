<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Realtime Chat</span>

    @auth
        <form action="/logout" method="POST">
            @csrf
            <button class="btn btn-sm btn-danger">Logout</button>
        </form>
    @endauth
</nav>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>