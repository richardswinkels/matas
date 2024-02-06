@extends('layouts.guest')

@section('content')
    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
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

            <div class="mt-4 flex justify-between">
                <a href="{{ route('register') }}" class="underline self-center text-sm">Register</a>

                <button type="submit"
                        class="px-3 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white font-semibold text-sm inline-flex">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection
