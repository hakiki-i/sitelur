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
                    <a href="/" class="btn btn-secondary mb-3">Kembali</a>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username" oninput="validateGmail(this)">
                            <div id="gmail-warning" class="text-danger small mt-1" style="display:none;">Email harus menggunakan domain @gmail.com</div>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <script>
                        function validateGmail(input) {
                            var warning = document.getElementById('gmail-warning');
                            if (input.value && !input.value.endsWith('@gmail.com')) {
                                warning.style.display = 'block';
                            } else {
                                warning.style.display = 'none';
                            }
                        }
                        </script>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control pr-5" required autocomplete="new-password">
                            <span class="position-absolute" style="top:70%; right:16px; transform:translateY(-50%); cursor:pointer;" onclick="togglePassword('password', this)">
                                <i class="fa fa-eye" id="eye-password"></i>
                            </span>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control pr-5" required autocomplete="new-password">
                            <span class="position-absolute" style="top:70%; right:16px; transform:translateY(-50%); cursor:pointer;" onclick="togglePassword('password_confirmation', this)">
                                <i class="fa fa-eye" id="eye-password-confirm"></i>
                            </span>
                            @error('password_confirmation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                    <div class="mt-3 text-center">
                        <span class="text-muted">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="text-success fw-bold">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

