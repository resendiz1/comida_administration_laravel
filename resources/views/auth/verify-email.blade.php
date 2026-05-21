<x-guest-layout>
  @section('title', 'Verificar email')

  <h2><i class="fas fa-envelope"></i> Verifica tu correo</h2>
  <p class="subtitle">Gracias por registrarte! Antes de empezar, verifica tu dirección de correo electrónico.</p>

  @if (session('status') == 'verification-link-sent')
    <div class="success-msg">
      <i class="fas fa-check-circle"></i> Se ha enviado un nuevo enlace de verificación a tu correo.
    </div>
  @endif

  <div style="margin-top:24px;display:flex;flex-direction:column;gap:12px;">
    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="btn-primary" style="width:100%;">
        <i class="fas fa-redo"></i> Reenviar email de verificación
      </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" style="width:100%;padding:12px;border:1px solid #d4c5b8;border-radius:30px;background:#fff;color:#6b5342;font-weight:600;cursor:pointer;font-size:.9rem;">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
      </button>
    </form>
  </div>
</x-guest-layout>
