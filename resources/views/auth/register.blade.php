@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold mb-1">
                Name:
            </label>
            <input id="name" type="text" name="name" :value="old('name')"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <ul class="text-sm text-red-600 mt-1">
                @foreach ($errors->get('name') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            <label for="email" class="block text-sm font-semibold mb-1">
                E-mail:
            </label>
            <input id="email" type="email" name="email" :value="old('email')"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <ul class="text-sm text-red-600 mt-1">
                @foreach ($errors->get('email') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            <label for="password" class="block text-sm font-semibold mb-1">
                Password:
            </label>
            <input type="password"
                   name="password"
                   required autocomplete="current-password"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <ul class="text-sm text-red-600 mt-1">
                @foreach ($errors->get('password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block text-sm font-semibold mb-1">
                Password confirmation:
            </label>
            <input type="password"
                   name="password_confirmation"
                   required autocomplete="current-password"
                   class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm mr-2 w-full">
            <ul class="text-sm text-red-600 mt-1">
                @foreach ($errors->get('password_confirmation') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                Login
            </button>
        </div>
    </form>
@endsection
