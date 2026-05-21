<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} — @yield('title', 'Iniciar sesión')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <style>
    body {
      background: #fef9f4;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .auth-wrapper {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }
    .auth-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0,0,0,.06);
      padding: 36px 32px;
      width: 100%;
      max-width: 420px;
    }
    .auth-card h2 {
      font-size: 1.5rem;
      text-align: center;
      margin-bottom: 8px;
      color: #3d2b1f;
    }
    .auth-card .subtitle {
      text-align: center;
      color: #6b5342;
      font-size: .9rem;
      margin-bottom: 24px;
    }
    .auth-card label {
      display: block;
      font-weight: 600;
      margin-bottom: 4px;
      font-size: .85rem;
      color: #3d2b1f;
    }
    .auth-card input[type="email"],
    .auth-card input[type="password"],
    .auth-card input[type="text"] {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #d4c5b8;
      border-radius: 10px;
      font-size: .95rem;
      font-family: inherit;
      outline: none;
      transition: border .2s;
      background: #fef9f4;
    }
    .auth-card input:focus {
      border-color: #e85d3a;
    }
    .auth-card .checkbox-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: .85rem;
      color: #6b5342;
      cursor: pointer;
    }
    .auth-card .checkbox-label input[type="checkbox"] {
      accent-color: #e85d3a;
      width: 16px;
      height: 16px;
    }
    .btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      background: linear-gradient(135deg, #e85d3a, #d94f2b);
      color: #fff;
      border: none;
      padding: 12px 28px;
      border-radius: 30px;
      font-weight: 700;
      font-size: .95rem;
      cursor: pointer;
      transition: opacity .2s;
      text-decoration: none;
    }
    .btn-primary:hover { opacity: .9; }
    .auth-card .forgot-link {
      font-size: .85rem;
      color: #6b5342;
    }
    .auth-card .forgot-link:hover { color: #e85d3a; }
    .auth-card .error-msg {
      background: #fef2f2;
      border: 1px solid #fca5a5;
      color: #991b1b;
      padding: 10px 14px;
      border-radius: 10px;
      font-size: .85rem;
      margin-bottom: 16px;
    }
    .auth-card .success-msg {
      background: #f0fdf4;
      border: 1px solid #86efac;
      color: #166534;
      padding: 10px 14px;
      border-radius: 10px;
      font-size: .85rem;
      margin-bottom: 16px;
    }
    .auth-footer {
      text-align: center;
      padding: 20px;
      color: #6b5342;
      font-size: .85rem;
      border-top: 1px solid #eee;
      background: #fff;
    }
    .auth-footer a { color: #e85d3a; text-decoration: none; font-weight: 600; }
    .auth-footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

<header style="padding: 30px 20px;">
  <div class="container">
    <a href="/" style="color:#fff;text-decoration:none;">
      <h1 style="font-size:2rem;margin-bottom:4px;"><i class="fas fa-utensils"></i> Comida Casera</h1>
      <p style="font-size:1rem;opacity:.9;"><i class="fas fa-check-circle"></i> Las mejores tortas, desayunos, comida corrida, postres y antojitos</p>
    </a>
  </div>
</header>

<div class="auth-wrapper">
  <div class="auth-card">
    {{ $slot }}
  </div>
</div>

<footer class="auth-footer">
  <p><i class="fas fa-heart" style="color:#e85d3a;"></i> Comida Casera — Hecho con amor</p>
</footer>

</body>
</html>
