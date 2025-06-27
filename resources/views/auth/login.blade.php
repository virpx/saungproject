@extends('layouts.login')

@section('title', 'Admin Login')
@section('subtitle', 'Masuk ke dashboard admin Saung DMS')

@section('content')
    @if(session('status'))
        <div class="mb-4 text-green-400">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-green-300 mb-1">Email</label>
            <input id="email" type="email" name="email" required autofocus class="w-full px-3 py-2 rounded input-custom" value="{{ old('email') }}">
            @error('email') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-green-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required class="w-full px-3 py-2 rounded input-custom">
            @error('password') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="flex items-center mb-4">
            <input id="remember_me" type="checkbox" name="remember" class="mr-2">
            <label for="remember_me" class="text-gray-300 text-sm">Ingat saya</label>
        </div>
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-green-400 hover:text-green-200" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
            <button type="submit" class="login-btn px-6 py-2 rounded-lg shadow">Log in</button>
        </div>
    </form>
@endsection
