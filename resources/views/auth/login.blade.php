@extends('layouts.landing')

@section('content')
<div class="landing-bg min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
        <div class="col-md-4 mx-auto">
            <div class="card shadow-lg border-0 animate__animated animate__fadeInDown mt-5" style="background: rgba(255,255,255,0.97);">
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <span class="bg-gradient-primary rounded-circle p-3">
                            <i class="fas fa-egg fa-2x text-warning"></i>
                        </span>
                        <h3 class="mt-3 mb-2 text-primary fw-bold">SIM Ayam Petelur</h3>
                    </div>
                    @if(session('status'))
                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    @endif
                    <a href="/" class="btn btn-secondary mb-3">Kembali</a>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" oninput="validateGmailLogin(this)">
                            <div id="gmail-warning-login" class="text-danger small mt-1" style="display:none;">Email harus menggunakan domain @gmail.com</div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <script>
                        function validateGmailLogin(input) {
                            var warning = document.getElementById('gmail-warning-login');
                            if (input.value && !input.value.endsWith('@gmail.com')) {
                                warning.style.display = 'block';
                            } else {
                                warning.style.display = 'none';
                            }
                        }
                        </script>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control pr-5" required autocomplete="current-password">
                            <span class="position-absolute" style="top:70%; right:16px; transform:translateY(-50%); cursor:pointer;" onclick="togglePassword('password', this)">
                                <i class="fa fa-eye" id="eye-password"></i>
                            </span>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <script>
                        function togglePassword(id, el) {
                            var input = document.getElementById(id);
                            var icon = el.querySelector('i');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        }
                        </script>
                        <div class="mb-3 form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Remember me</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success w-100">Masuk</button>
                    </form>
                    <div class="mt-3 text-center">
                        <span class="text-muted">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-primary fw-bold">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

