<x-guest-layout>
  @section('title', 'Confirmar contraseña')

  <h2><i class="fas fa-shield-alt"></i> Confirmar contraseña</h2>
  <p class="subtitle">Por seguridad, confirma tu contraseña para continuar</p>

  <form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div>
      <label for="password">Contraseña</label>
      <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
      @error('password')
        <p style="color:#991b1b;font-size:.8rem;margin-top:4px;">{{ $message }}</p>
      @enderror
    </div>

    <div style="margin-top:24px;">
      <button type="submit" class="btn-primary" style="width:100%;">
        <i class="fas fa-check"></i> Confirmar
      </button>
    </div>
  </form>
</x-guest-layout>
