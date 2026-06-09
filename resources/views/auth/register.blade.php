@extends('layouts.app')

@section('title', 'Register')

@section('content')
<h2>Register</h2>

@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/register">
    @csrf

    <div>
        <label>Nama</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div>
        <label>Password</label><br>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Konfirmasi Password</label><br>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Register</button>
</form>

<a href="/login">Sudah punya akun? Login</a>
@endsection