@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card"><div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf  {{-- WAJIB di setiap form --}}

                {{-- PATTERN ERROR DISPLAY --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="text-center mt-3">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </div></div>
    </div>
</div>
@endsection