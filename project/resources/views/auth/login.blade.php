@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white py-8 px-6 shadow-md rounded-lg auth-card">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Or
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    create a new account
                </a>
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('loginUser') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input id="password" name="password" type="password" autocomplete="current-password" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or continue with
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-google mr-2"></i>
                        Google
                    </a>
                </div>

                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-linkedin mr-2"></i>
                        LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

