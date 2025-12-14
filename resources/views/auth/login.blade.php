@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Login</button>
    </form>

    <p class="mt-4 text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-green-600">Register</a>
    </p>
</div>
@endsection