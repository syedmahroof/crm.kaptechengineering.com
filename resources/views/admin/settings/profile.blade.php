@extends('layouts.admin')

@section('title', 'Profile Settings')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Profile Settings</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Update your account profile information</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @if(!Auth::user()->hasVerifiedEmail())
                <p class="text-sm text-yellow-600 mt-1">
                    Your email address is unverified. <a href="{{ route('verification.send') }}" class="underline">Click here to resend the verification email.</a>
                </p>
            @endif
        </div>

        @if(session('status'))
            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex justify-end space-x-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Changes</button>
        </div>
    </form>
</div>
@endsection

