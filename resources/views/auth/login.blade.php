@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-header">
        <div style="display:flex; align-items:center; justify-content:center; gap:0.5rem; margin-bottom:1rem; color:#4f46e5;">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 256 256"><path fill="currentColor" d="M240,112H216V64a16,16,0,0,0-16-16H56A16,16,0,0,0,40,64v48H16a8,8,0,0,0,0,16H40v48a16,16,0,0,0,16,16h4.51c3,17.47,18.4,32,36.93,32h1.12c18.53,0,33.91-14.53,36.93-32H120.51c3,17.47,18.4,32,36.93,32h1.12c18.53,0,33.91-14.53,36.93-32H200a16,16,0,0,0,16-16V128h24a8,8,0,0,0,0-16ZM97.44,188H96.56a21.46,21.46,0,0,1-21-17.7A21.56,21.56,0,0,1,97.44,188Zm61.12,0H157.44A21.56,21.56,0,0,1,158.56,188ZM200,176H194.51a37.38,37.38,0,0,0-72,0H133.51a37.38,37.38,0,0,0-72,0H56V64H200ZM184,88a8,8,0,0,1-8,8H136a8,8,0,0,1,0-16h40A8,8,0,0,1,184,88Zm0,32a8,8,0,0,1-8,8H136a8,8,0,0,1,0-16h40A8,8,0,0,1,184,120ZM104,80H80A16,16,0,0,0,64,96v24a16,16,0,0,0,16,16h24a16,16,0,0,0,16-16V96A16,16,0,0,0,104,80Zm0,40H80V96h24Z"></path></svg>
            <span style="font-weight:700; font-size:1.5rem; letter-spacing:-0.025em; color: #1e293b;">Parkir Sek</span>
        </div>
        <h1>Masuk Sistem</h1>
        <p>Silakan login untuk mengakses aplikasi parkir</p>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            Username atau password salah!
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" 
                   id="username" 
                   name="username" 
                   class="form-input" 
                   value="{{ old('username') }}" 
                   placeholder="Masukkan username"
                   required
                   autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="form-input" 
                   placeholder="Masukkan password"
                   required>
        </div>

        <button type="submit" class="btn-submit">Sign In</button>
    </form>
</div>
@endsection
