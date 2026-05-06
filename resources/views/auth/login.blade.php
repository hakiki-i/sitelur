@extends('layouts.landing')

@section('content')
<style>
.auth-card {
    border-radius: 24px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    background: rgba(255,255,255,0.98) !important;
    border: none;
}
.auth-input {
    border-radius: 12px;
    padding: 0.8rem 1.2rem;
    border: 1px solid #e3e6f0;
    background-color: #f8f9fc;
    transition: all 0.3s;
}
.auth-input:focus {
    background-color: #fff;
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
}
.btn-auth {
    border-radius: 12px;
    padding: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    transition: all 0.3s;
}
.btn-auth:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
}
.auth-label {
    font-weight: 600;
    color: #5a5c69;
    font-size: 0.9rem;
    margin-bottom: 0.4rem;
}
</style>
<div class="landing-bg min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
        <div class="col-md-5 col-lg-4 mx-auto">
            <div class="card auth-card animate__animated animate__fadeInDown mt-5">
                <div class="card-body p-5">
                    <div class="mb-4 text-center">
                        <span class="bg-gradient-primary rounded-circle p-3 d-inline-block shadow-sm mb-3">
                            <i class="fas fa-egg fa-2x text-warning"></i>
                        </span>
                        <h3 class="mb-1 text-primary fw-bold" style="letter-spacing: -0.5px;">Selamat Datang</h3>
                        <p class="text-muted small">SIM Ayam Petelur</p>
                    </div>
                    @if(session('status'))
                        <div class="alert alert-success mb-3 rounded-3 border-0">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label auth-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control auth-input" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email @gmail Anda" oninput="validateGmailLogin(this)">
                            <div id="gmail-warning-login" class="text-danger small mt-1 fw-medium" style="display:none;"><i class="fas fa-exclamation-circle me-1"></i>Domain harus @gmail.com</div>
                            @error('email')<div class="text-danger small mt-1 fw-medium">{{ $message }}</div>@enderror
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
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label auth-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control auth-input pr-5" required autocomplete="current-password" placeholder="Masukkan password">
                            <span class="position-absolute text-muted" style="top:72%; right:16px; transform:translateY(-50%); cursor:pointer;" onclick="togglePassword('password', this)">
                                <i class="fa fa-eye" id="eye-password"></i>
                            </span>
                            @error('password')<div class="text-danger small mt-1 fw-medium">{{ $message }}</div>@enderror
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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label text-muted small">Ingat saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary fw-medium text-decoration-none small" href="{{ route('password.request') }}">Lupa password?</a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-auth mb-3">Masuk <i class="fas fa-sign-in-alt ms-1"></i></button>
                        <a href="/" class="btn btn-light w-100 btn-auth text-muted border-0" style="background: #f8f9fc;">Kembali ke Beranda</a>
                    </form>
                    <div class="mt-4 text-center border-top pt-3">
                        <span class="text-muted small">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none small ms-1">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
