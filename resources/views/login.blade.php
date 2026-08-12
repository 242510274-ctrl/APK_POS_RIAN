@extends('layouts.app')

@section('title', 'Login POS')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Segoe UI', Arial, sans-serif;
        background:
            radial-gradient(circle at 10% 20%, rgba(59,130,246,.25), transparent 30%),
            radial-gradient(circle at 90% 80%, rgba(14,165,233,.20), transparent 30%),
            linear-gradient(135deg, #020617, #0f172a, #172554);
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
    }

    .login-card {
        width: 100%;
        max-width: 430px;
        padding: 42px;
        border-radius: 28px;
        background: rgba(255,255,255,.97);
        box-shadow: 0 30px 80px rgba(0,0,0,.45);
    }

    .brand {
        text-align: center;
        margin-bottom: 35px;
    }

    .brand-icon {
        width: 78px;
        height: 78px;
        margin: 0 auto 18px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 22px;

        background: linear-gradient(135deg, #2563eb, #0ea5e9);

        color: white;
        font-size: 25px;
        font-weight: 800;

        box-shadow: 0 15px 30px rgba(37,99,235,.35);
    }

    .brand h2 {
        margin: 0;
        color: #0f172a;
        font-size: 28px;
        font-weight: 750;
    }

    .brand p {
        margin: 8px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
    }

    .form-control {
        width: 100%;
        height: 54px;

        padding: 0 55px 0 45px;

        border: 1px solid #e2e8f0;
        border-radius: 13px;

        background: #f8fafc;
        color: #0f172a;

        font-size: 14px;
        outline: none;

        transition: .25s;
    }

    .form-control:focus {
        background: white;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37,99,235,.10);
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);

        width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: none;
        border-radius: 9px;

        background: transparent;
        color: #94a3b8;

        cursor: pointer;

        z-index: 10;
    }

    .password-toggle:hover {
        color: #2563eb;
        background: rgba(37,99,235,.08);
    }

    .error-message {
        display: block;
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
    }

    .btn-login {
        width: 100%;
        height: 54px;

        margin-top: 5px;

        border: none;
        border-radius: 13px;

        background: linear-gradient(135deg, #2563eb, #0ea5e9);

        color: white;
        font-size: 14px;
        font-weight: 700;

        cursor: pointer;

        transition: .25s;

        box-shadow: 0 10px 25px rgba(37,99,235,.25);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37,99,235,.35);
    }

    .login-footer {
        margin-top: 28px;
        padding-top: 20px;

        border-top: 1px solid #f1f5f9;

        text-align: center;

        color: #94a3b8;
        font-size: 12px;
    }

    .secure {
        margin-top: 8px;
        text-align: center;
        color: #64748b;
        font-size: 11px;
    }

    @media (max-width: 480px) {
        .login-wrapper {
            padding: 18px;
        }

        .login-card {
            padding: 32px 24px;
        }
    }
</style>


<div class="login-wrapper">

    <div class="login-card">

        <!-- LOGO -->
        <div class="brand">

            <div class="brand-icon">
                POS
            </div>

            <h2>Selamat Datang</h2>

            <p>
                Masuk ke sistem Point of Sale
            </p>

        </div>


        <!-- FORM LOGIN -->
        <form action="{{ route('auth') }}" method="POST">

            @csrf


            <!-- EMAIL -->
            <div class="form-group">

                <label for="email" class="form-label">
                    Email Address
                </label>

                <div class="input-wrapper">

                    <span class="input-icon">
                        ✉
                    </span>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                    >

                </div>

                @error('email')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-wrapper">

                    <span class="input-icon">
                        🔒
                    </span>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                    >

                    <!-- TOMBOL MATA -->
                    <button
                        type="button"
                        id="togglePassword"
                        class="password-toggle"
                    >
                        👁
                    </button>

                </div>

                @error('password')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- TOMBOL LOGIN -->
            <button
                type="submit"
                class="btn-login"
            >
                Masuk ke Dashboard
            </button>

        </form>


        <div class="login-footer">
            © {{ date('Y') }} POS System
        </div>

        <div class="secure">
            🔐 Sistem aman & terlindungi
        </div>

    </div>

</div>


<!-- JAVASCRIPT PASSWORD -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const password =
        document.getElementById('password');

    const toggle =
        document.getElementById('togglePassword');

    toggle.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';

            toggle.innerHTML = '🙈';

        } else {

            password.type = 'password';

            toggle.innerHTML = '👁';

        }

    });

});
</script>

@endsection
