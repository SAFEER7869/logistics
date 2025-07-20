@extends('layouts.guest')
@section('content')
<div>
<h4 class="mb-1">Forgot Password </h4>

        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
    <div class="font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-4">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
        <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>
        <a class="" href="{{ route('admin.login') }}" >
                {{ __('Already registered?') }}
            </a>
        <div class="flex items-center justify-end mt-4">
        <button type="submit" class="btn btn-primary d-grid w-100">Email Password Reset Link</button>

        </div>
    </form>
@endsection

