<x-guest-layout>
  @section('title', 'Registrarse')

  <h2><i class="fas fa-user-plus"></i> Crear cuenta</h2>
  <p class="subtitle">Regístrate para administrar el menú</p>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
      <label for="name">Nombre</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre">
      @error('name')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:16px;">
      <label for="email">Correo electrónico</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="tu@correo.com">
      @error('email')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:16px;">
      <label for="password">Contraseña</label>
      <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
      @error('password')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:16px;">
      <label for="password_confirmation">Confirmar contraseña</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
      @error('password_confirmation')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:24px;display:flex;align-items:center;justify-content:space-between;">
      <a href="{{ route('login') }}" style="font-size:.85rem;color:#6b5342;">
        <i class="fas fa-arrow-left"></i> ¿Ya tienes cuenta?
      </a>
      <button type="submit" class="btn-primary">
        <i class="fas fa-check"></i> Registrarse
      </button>
    </div>
  </form>
</x-guest-layout>
