@extends('layouts.app')

@section('title', 'Login POS Rian')

@section('content')

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', Arial, sans-serif;
        background: 
            radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.15), transparent 40%),
            radial-gradient(circle at 20% 80%, rgba(14, 165, 233, 0.15), transparent 40%),
            linear-gradient(135deg, #090d16, #0f172a);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-wrapper {
        width: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    /* Efek Ornamen Estetik di Background */
    .bg-blur-1, .bg-blur-2 {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 1;
        opacity: 0.5;
    }
    .bg-blur-1 { top: -50px; right: -50px; background: #4f46e5; }
    .bg-blur-2 { bottom: -50px; left: -50px; background: #0ea5e9; }

    .login-card {
        width: 100%;
        max-width: 420px;
        padding: 48px 40px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        z-index: 2;
        position: relative;
    }

    .brand {
        text-align: center;
        margin-bottom: 36px;
    }

    .brand-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        color: white;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 1px;
        box-shadow: 0 12px 24px rgba(99, 102, 241, 0.3);
    }

    .brand h2 {
        color: #f8fafc;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .brand p {
        margin-top: 6px;
        color: #94a3b8;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 2;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .form-control {
        width: 100%;
        height: 52px;
        padding: 0 48px 0 46px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        background: rgba(15, 23, 42, 0.4);
        color: #f8fafc;
        font-size: 14px;
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control::placeholder {
        color: #475569;
    }

    .form-control:focus {
        border-color: #6366f1;
        background: rgba(15, 23, 42, 0.6);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    .form-control:focus + .input-icon {
        color: #6366f1;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 8px;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        z-index: 10;
        font-size: 16px;
        transition: all 0.2s ease;
    }

    .password-toggle:hover {
        color: #f8fafc;
        background: rgba(255, 255, 255, 0.05);
    }

    .error-message {
        display: block;
        margin-top: 6px;
        color: #f87171;
        font-size: 12px;
    }

    .btn-login {
        width: 100%;
        height: 52px;
        margin-top: 8px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        transform: translateY(-1px);
    }

    .btn-login:active {
        transform: translateY(1px);
    }

    .login-footer {
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        text-align: center;
        color: #64748b;
        font-size: 12px;
    }

    .secure {
        margin-top: 10px;
        text-align: center;
        color: #475569;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 36px 24px;
        }
    }
</style>

<div class="login-wrapper">
    <!-- Ambient Blur Background -->
    <div class="bg-blur-1"></div>
    <div class="bg-blur-2"></div>

    <div class="login-card">

        <!-- LOGO & BRAND -->
        <div class="brand">
            <div class="brand-icon">
                RIAN
            </div>
            <h2>POS Rian</h2>
            <p>Masuk ke sistem Point of Sale</p>
        </div>

        <!-- FORM LOGIN -->
        <form action="{{ route('auth') }}" method="POST">
            @csrf

            <!-- EMAIL -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <span class="input-icon">✉</span>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Masukkan email Anda"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                    >
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password Anda"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" id="togglePassword" class="password-toggle">👁</button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- TOMBOL LOGIN -->
            <button type="submit" class="btn-login">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="login-footer">
            &copy; {{ date('Y') }} POS Rian System
        </div>

        <div class="secure">
            <span>🔐</span> Sistem aman & terlindungi
        </div>

    </div>
</div>

<!-- JAVASCRIPT PASSWORD TOGGLE -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');

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
