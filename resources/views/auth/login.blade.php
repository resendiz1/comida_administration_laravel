<x-guest-layout>
  @section('title', 'Iniciar sesión')

  <h2><i class="fas fa-sign-in-alt"></i> Iniciar sesión</h2>
  <p class="subtitle">Accede al panel de administración</p>

  @if (session('status'))
    <div class="success-msg">
      <i class="fas fa-check-circle"></i> {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
      <label for="email">Correo electrónico</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu@correo.com">
      @error('email')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:16px;">
      <label for="password">Contraseña</label>
      <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
      @error('password')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:16px;">
      <label class="checkbox-label">
        <input type="checkbox" name="remember" id="remember_me">
        Recordarme
      </label>
    </div>

    <div style="margin-top:24px;display:flex;align-items:center;justify-content:flex-end;">
      <button type="submit" class="btn-primary">
        <i class="fas fa-arrow-right"></i> Entrar
      </button>
    </div>

    <div style="margin-top:20px;text-align:center;font-size:.85rem;color:#6b5342;border-top:1px solid #eee;padding-top:20px;">
      ¿No tienes cuenta?
      <a href="{{ route('register') }}" style="color:#e85d3a;font-weight:700;text-decoration:none;">Regístrate</a>
    </div>
  </form>
</x-guest-layout>
