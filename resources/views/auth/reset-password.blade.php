@extends('layouts.guest')
@section('content')
<h4 class="mb-1">Reset Password👋</h4>
<form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
        <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
        <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
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

        <div class="flex items-center justify-end mt-4">
        <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
        </div>
    </form>
@endsection
