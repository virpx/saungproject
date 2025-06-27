@extends('layouts.login')

@section('title', 'Login Koki')
@section('subtitle', 'Masuk ke dashboard koki Saung DMS')

@section('content')
    @if(session('error'))
        <div class="mb-4 text-red-400">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('koki.login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-blue-300 mb-1">Email</label>
            <input id="email" type="email" name="email" required autofocus class="w-full px-3 py-2 rounded input-custom" value="{{ old('email') }}">
            @error('email') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-blue-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required class="w-full px-3 py-2 rounded input-custom">
            @error('password') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
        </div>
        <div class="flex items-center justify-between mb-4">
            @if (Route::has('koki.register'))
                <a class="underline text-sm text-blue-400 hover:text-blue-200" href="{{ route('koki.register') }}">
                    Register Koki
                </a>
            @endif
        </div>
        <div class="flex items-center justify-end">
            <button type="submit" class="login-btn px-6 py-2 rounded-lg shadow">Log in</button>
        </div>
    </form>
@endsection