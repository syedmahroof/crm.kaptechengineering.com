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

    <!-- Delete Account -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-800 p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Account</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
        <form action="{{ route('profile.destroy') }}" method="POST" data-confirm="Are you sure you want to delete your account? This action cannot be undone.">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" placeholder="Enter your password to confirm">
            </div>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete Account</button>
        </form>
    </div>
</div>
@endsection

