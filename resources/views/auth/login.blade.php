@extends('layouts.guest')
@section('content')
<!-- Content -->


        <!-- Login -->


            <h4 class="mb-1">Welcome to Aethon Payroll! 👋</h4>
            <p class="mb-6">Please sign-in to your account</p>
            @if ($errors->any())
              <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
          @endif
            <form id="formAuthentication" class="mb-4"  method="POST" action="{{ route('adminlogin') }}">
            @csrf
             <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email"
                  autofocus />

                  @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                    @error('password')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
                  <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
              </div>
              <div class="my-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="/forgot-password">
                    <p class="mb-0">Forgot Password?</p>
                  </a>
                  <a href="/register">
                    <p class="mb-0">Register</p>
                  </a>
                </div>
              </div>
              <button class="btn btn-primary d-grid w-100">Sign in</button>
            </form>

          </div>
        </div>
        <!-- /Login -->




    <!-- / Content -->
@endsection
