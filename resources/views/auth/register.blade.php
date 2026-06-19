@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>Bengkel</b> AHASS</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                </div>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="input-group mt-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>
                </div>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="input-group mt-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="input-group mt-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-8">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3">
                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </p>
        </div>
    </div>
</div>
@endsection
