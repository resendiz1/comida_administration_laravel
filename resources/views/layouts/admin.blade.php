<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Administrar') — Comida Casera</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <style>
    body { background: #fef9f4; margin: 0; min-height: 100vh; }
    .admin-layout { display: flex; min-height: 100vh; }
    .admin-sidebar {
      width: 240px; background: #fff; border-right: 1px solid #eee;
      display: flex; flex-direction: column; position: fixed; top: 0; left: 0;
      height: 100vh; z-index: 30;
      transform: translateX(-100%); transition: transform .3s ease;
    }
    .admin-sidebar.open { transform: translateX(0); }
    .admin-sidebar-overlay {
      display: none; position: fixed; inset: 0; z-index: 25;
      background: rgba(0,0,0,.3);
    }
    .admin-sidebar-overlay.show { display: block; }
    .admin-toggle {
      display: flex; position: fixed; top: 16px; left: 16px; z-index: 35;
      background: #e85d3a; color: #fff; border: none;
      width: 42px; height: 42px; border-radius: 10px;
      font-size: 1.1rem; cursor: pointer;
      box-shadow: 0 4px 12px rgba(232,93,58,.4);
      align-items: center; justify-content: center;
    }
    .admin-toggle:hover { transform: scale(1.05); }
    .admin-sidebar-header {
      padding: 20px 16px 12px; border-bottom: 1px solid #eee;
    }
    .admin-sidebar-header a { text-decoration: none; color: #3d2b1f; display: block; }
    .admin-sidebar-header h1 {
      font-size: 1.15rem; margin: 0; display: flex; align-items: center; gap: 8px;
      background: none; -webkit-text-fill-color: initial;
    }
    .admin-sidebar-header h1 i { color: #e85d3a; }
    .admin-sidebar-header p {
      font-size: .75rem; color: #999; margin: 4px 0 0 26px;
    }
    .admin-sidebar-nav {
      flex: 1; padding: 16px 12px; display: flex; flex-direction: column; gap: 4px;
      background: transparent; position: static; box-shadow: none; overflow: visible; justify-content: flex-start;
    }
    .admin-sidebar-nav a, .nav-btn-logout {
      display: flex; align-items: center; gap: 10px;
      text-decoration: none; color: #3d2b1f; font-weight: 600;
      padding: 12px 16px; border-radius: 12px; font-size: .9rem;
      transition: background .2s;
      background: none; border: none; cursor: pointer; font-family: inherit; width: 100%; white-space: normal; justify-content: flex-start;
    }
    .admin-sidebar-nav a:hover, .admin-sidebar-nav a.active, .nav-btn-logout:hover { background: #fce4d6; }
    .admin-sidebar-nav a.active { background: #e85d3a; color: #fff; }
    .admin-sidebar-nav .spacer { flex: 1; }
    .admin-main {
      margin-left: 0; flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    }
    .admin-content { flex: 1; padding: 30px; padding-top: 70px; max-width: 1100px; width: 100%; margin: 0 auto; }
    .admin-card {
      background: #fff; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,.06);
      padding: 24px; overflow: hidden;
    }
    .admin-title {
      font-size: 1.3rem; font-weight: 700; color: #3d2b1f; margin-bottom: 20px;
    }
    .admin-btn {
      display: inline-flex; align-items: center; gap: 6px;
      background: linear-gradient(135deg, #e85d3a, #d94f2b); color: #fff; border: none;
      padding: 10px 20px; border-radius: 30px; font-weight: 700; font-size: .88rem;
      cursor: pointer; transition: opacity .2s; text-decoration: none;
    }
    .admin-btn:hover { opacity: .9; }
    .admin-btn-secondary {
      display: inline-flex; align-items: center; gap: 6px;
      background: #eee; color: #3d2b1f; border: none;
      padding: 10px 20px; border-radius: 30px; font-weight: 600; font-size: .88rem;
      cursor: pointer; transition: background .2s; text-decoration: none;
    }
    .admin-btn-secondary:hover { background: #ddd; }
    .admin-btn-red {
      display: inline-flex; align-items: center; gap: 6px;
      background: #dc2626; color: #fff; border: none;
      padding: 10px 20px; border-radius: 30px; font-weight: 700; font-size: .88rem;
      cursor: pointer; transition: opacity .2s; text-decoration: none;
    }
    .admin-btn-red:hover { opacity: .85; }
    .admin-table { width: 100%; border-collapse: collapse; font-size: .9rem; }
    .admin-table th { text-align: left; padding: 12px 8px; border-bottom: 2px solid #fce4d6; color: #6b5342; font-weight: 700; }
    .admin-table td { padding: 12px 8px; border-bottom: 1px solid #f0ebe6; }
    .admin-table tr:hover td { background: #fef9f4; }
    .admin-label { display: block; font-weight: 600; margin-bottom: 4px; font-size: .85rem; color: #3d2b1f; }
    .admin-input {
      width: 100%; padding: 10px 14px; border: 1px solid #d4c5b8; border-radius: 10px;
      font-size: .95rem; font-family: inherit; outline: none; transition: border .2s;
      background: #fef9f4;
    }
    .admin-input:focus { border-color: #e85d3a; }
    .admin-select {
      width: 100%; padding: 10px 14px; border: 1px solid #d4c5b8; border-radius: 10px;
      font-size: .95rem; font-family: inherit; outline: none; transition: border .2s;
      background: #fef9f4;
    }
    .admin-select:focus { border-color: #e85d3a; }
    .admin-textarea {
      width: 100%; padding: 10px 14px; border: 1px solid #d4c5b8; border-radius: 10px;
      font-size: .95rem; font-family: inherit; outline: none; transition: border .2s;
      background: #fef9f4; resize: vertical;
    }
    .admin-textarea:focus { border-color: #e85d3a; }
    .admin-checkbox { accent-color: #e85d3a; width: 16px; height: 16px; }
    .admin-badge {
      display: inline-block; padding: 2px 10px; border-radius: 30px;
      font-size: .75rem; font-weight: 700;
    }
    .admin-badge-yes { background: #dcfce7; color: #166534; }
    .admin-badge-no { background: #fee2e2; color: #991b1b; }
    .admin-error { color: #991b1b; font-size: .8rem; margin-top: 4px; }
    .admin-footer {
      text-align: center; padding: 16px; color: #6b5342; font-size: .8rem;
      border-top: 1px solid #eee; background: #fff; margin-left: 240px;
    }
    .admin-pagination { margin-top: 20px; display: flex; justify-content: center; }
    .compact-pagination { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .compact-pagination-btn {
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 32px; height: 32px; padding: 0 8px;
      font-size: .82rem; font-weight: 600; border-radius: 8px;
      background: #fff; color: #3d2b1f; text-decoration: none;
      border: 1px solid #e8ddd0; transition: all .15s;
    }
    .compact-pagination-btn:hover { background: #fce4d6; border-color: #e85d3a; color: #e85d3a; }
    .compact-pagination-btn.active { background: #e85d3a; border-color: #e85d3a; color: #fff; }
    .compact-pagination-btn.disabled { opacity: .4; cursor: default; pointer-events: none; }
    .compact-pagination-dots { padding: 0 4px; color: #999; font-size: .8rem; }
    .admin-img-stack { display: flex; }
    .admin-img-stack img, .admin-img-stack span {
      width: 36px; height: 36px; border-radius: 50%; object-fit: cover;
      border: 2px solid #fff; margin-right: -8px;
    }
    .admin-img-stack span {
      background: #fce4d6; display: inline-flex; align-items: center;
      justify-content: center; font-size: .7rem; font-weight: 700; color: #e85d3a;
    }
    .admin-file-input { font-size: .9rem; color: #6b5342; }
    .admin-file-input::file-selector-button {
      margin-right: 12px; padding: 8px 16px; border-radius: 30px; border: none;
      background: #fce4d6; color: #e85d3a; font-weight: 700; font-size: .85rem;
      cursor: pointer; transition: background .2s;
    }
    .admin-file-input::file-selector-button:hover { background: #f8d5c4; }
    .admin-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
    .admin-grid-item { position: relative; }
    .admin-grid-item img { height: 120px; width: 100%; object-fit: cover; border-radius: 12px; border: 1px solid #d4c5b8; }
    .admin-grid-badge {
      position: absolute; top: 4px; left: 4px; background: rgba(0,0,0,.6); color: #fff;
      font-size: .7rem; padding: 2px 8px; border-radius: 8px;
    }
    .admin-grid-badge-main { background: #e85d3a; }
    .admin-grid-remove {
      position: absolute; top: 4px; right: 4px; background: #dc2626; color: #fff;
      border: none; border-radius: 50%; width: 22px; height: 22px;
      font-size: .7rem; cursor: pointer; display: none; align-items: center; justify-content: center;
    }
    .admin-grid-item:hover .admin-grid-remove { display: flex; }
    .admin-grid-remove:hover { background: #b91c1c; }
    .admin-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .admin-table-wrap { overflow: hidden; }
    .td-actions { display: flex; gap: 8px; }
    .td-img, .td-name, .td-price { white-space: nowrap; }
    @media (max-width: 768px) {
      .admin-sidebar { width: 100%; max-width: 280px; }
      .admin-sidebar.open + .admin-main .admin-content { padding-top: 70px; }
      .admin-main, .admin-footer { margin-left: 0; }
      .admin-sidebar-nav { flex-direction: column; }
      .admin-sidebar-nav .spacer { display: block; }
      .admin-content { padding: 16px; padding-top: 70px; }
      .admin-card { padding: 16px; }
      .admin-grid-4 { grid-template-columns: repeat(2, 1fr); }
      .admin-toolbar { flex-direction: column; gap: 12px; align-items: flex-start; }
      .admin-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      .admin-table-wrap table { min-width: 600px; }
    }
  </style>
</head>
<body>
<div class="admin-sidebar-overlay" onclick="toggleAdminSidebar()"></div>
<button class="admin-toggle" onclick="toggleAdminSidebar()"><i class="fas fa-bars"></i></button>
<div class="admin-layout">
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
      <a href="{{ route('home') }}">
        <h1><i class="fas fa-utensils"></i> Comida Casera</h1>
        <p>Panel de administración</p>
      </a>
    </div>
    <nav class="admin-sidebar-nav">
      @if(Auth::user()?->is_admin)
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
          <i class="fas fa-box"></i> Productos
        </a>
        <a href="{{ route('home') }}" target="_blank">
          <i class="fas fa-eye"></i> Ver tienda
        </a>
      @endif
      <div class="spacer"></div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-btn-logout">
          <i class="fas fa-sign-out-alt"></i> Salir
        </button>
      </form>
    </nav>
  </aside>

  <main class="admin-main">
    <div class="admin-content">
  {{ $slot }}
    </div>
  </main>
</div>

<footer class="admin-footer">
  <p><i class="fas fa-heart" style="color:#e85d3a;"></i> Comida Casera — Hecho con amor by &lt;JuanPancho's/&gt;</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
function toggleAdminSidebar() {
  document.getElementById('adminSidebar').classList.toggle('open');
  document.querySelector('.admin-sidebar-overlay').classList.toggle('show');
}
toastr.options = {
  closeButton: true,
  progressBar: true,
  positionClass: "toast-top-right",
  timeOut: 4000,
};
@if (session('success'))
  toastr.success("{{ session('success') }}");
@endif
@if (session('error'))
  toastr.error("{{ session('error') }}");
@endif
</script>
</body>
</html>
