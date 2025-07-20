@extends('layouts.guest')
@section('content')
<h4 class="mb-1">Register New User👋</h4>
<form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
        <label for="first_name" class="form-label">Email</label>
            <input id="name" class="form-control" type="text" name="first_name" :value="old('name')" required autofocus autocomplete="name" />
            @error('first_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Last Name -->
        <div>
        <label for="last_name" class="form-label">Last Name</label>
            <input id="name" class="form-control" type="text" name="last_name" :value="old('name')"  autofocus autocomplete="name" />
            @error('last_name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
        <label for="email" class="form-label">First Name</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
            @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
        <label for="password" class="form-label">Password</label>

            <input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

                            @error('password')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>

            <input id="password_confirmation" class="form-control"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                            @error('password_confirmation')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <div class="flex items-center justify-end mt-3">
            <a class="" href="{{ route('admin.login') }}">
                {{ __('Already registered?') }}
            </a>
            <button type="submit" class="btn btn-primary d-grid w-100 mt-3 ">Register</button>

        </div>
    </form>
@endsection
