<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comida Casera</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
</head>
<body>

<header>
  <div class="container">
    <h1><i class="fas fa-utensils"></i> Comida Casera</h1>
    <p><i class="fas fa-check-circle"></i> Las mejores tortas, desayunos, comida corrida, postres y antojitos</p>
    @auth
      @if(Auth::user()->is_admin)
        <div style="margin-top: 15px;">
          <a href="{{ route('admin.products.index') }}" style="background:#fff;color:#e85d3a;padding:8px 20px;border-radius:30px;font-weight:700;text-decoration:none;font-size:.9rem;">
            <i class="fas fa-cog"></i> Administrar
          </a>
        </div>
      @endif
    @endauth
  </div>
</header>

<div class="page-layout">
  <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
  <button class="sidebar-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
  <nav class="sidebar">
    <a href="#" onclick="window.scrollTo({top:0,behavior:'smooth'});return false"><i class="fas fa-home"></i> Inicio</a>
    <div class="sidebar-header">Categorías</div>
    @foreach ($categories as $cat)
      <a href="#{{ $cat }}"><i class="fas fa-{{ $cat === 'tortas' ? 'bread-slice' : ($cat === 'desayunos' ? 'sun' : ($cat === 'comida' ? 'utensil-spoon' : ($cat === 'postres' ? 'cake' : 'taco'))) }}"></i> {{ ucfirst($cat === 'comida' ? 'Comida corrida' : $cat) }}</a>
    @endforeach
  </nav>

  <div class="main-content">
    <div class="container">

      @foreach ($categories as $cat)
      <section id="{{ $cat }}">
        @php
          $icon = match($cat) {
            'tortas' => 'bread-slice',
            'desayunos' => 'sun',
            'comida' => 'utensil-spoon',
            'postres' => 'cake',
            'antojitos' => 'taco',
          };
          $label = match($cat) {
            'tortas' => 'Tortas',
            'desayunos' => 'Desayunos',
            'comida' => 'Comida corrida',
            'postres' => 'Postres',
            'antojitos' => 'Antojitos',
          };
        @endphp
        <h2><i class="fas fa-{{ $icon }}"></i> {{ $label }}</h2>
        <div class="menu-grid">
          @forelse ($productsByCategory[$cat] as $product)
            @php
              $mainImg = $product->image
                ? (Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image))
                : 'https://via.placeholder.com/400x300?text=Sin+imagen';
            @endphp
            <div class="card visible">
              <div class="carousel" data-current="0">
                @php
                  $allImages = collect([$mainImg]);
                  $allImages = $allImages->merge($product->images->map(fn($i) => Storage::url($i->image_path)));
                @endphp
                @foreach ($allImages as $idx => $img)
                  <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy"
                    class="carousel-img {{ $idx === 0 ? 'active' : '' }}" onclick="openLightbox(this.src)">
                @endforeach
                @if ($allImages->count() > 1)
                  <button class="carousel-btn carousel-prev" onclick="moveCarousel(this, -1)">&#10094;</button>
                  <button class="carousel-btn carousel-next" onclick="moveCarousel(this, 1)">&#10095;</button>
                  <div class="carousel-dots">
                    @foreach ($allImages as $idx => $img)
                      <span class="carousel-dot {{ $idx === 0 ? 'active' : '' }}" onclick="goToSlide(this, {{ $idx }})"></span>
                    @endforeach
                  </div>
                @endif
              </div>
              <div class="card-body">
                <h3>{{ $product->name }}</h3>
                <p class="desc">{{ $product->description }}</p>
                <div class="card-footer">
                  <span class="price">${{ number_format($product->price, 2) }}</span>
                  <button class="btn-cart" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                    <i class="fas fa-plus"></i> Agregar
                  </button>
                </div>
              </div>
            </div>
          @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 20px;background:#fff;border-radius:16px;border:2px dashed #e8ddd0;">
              <div style="font-size:3rem;margin-bottom:16px;color:#e8ddd0;"><i class="fas fa-utensils"></i></div>
              <p style="font-size:1.1rem;font-weight:600;color:#6b5342;">No hay productos disponibles</p>
              <p style="color:#b8a596;font-size:.9rem;margin-top:4px;">Estamos preparando algo delicioso para ti</p>
            </div>
          @endforelse
        </div>
      </section>
    @endforeach

  </div>
</div>

</div>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
  <span class="lightbox-close">&times;</span>
  <img id="lightboxImg" src="">
</div>

<!-- Cart -->
<div class="modal-overlay" id="cartOverlay" onclick="toggleCart()">
  <div class="modal cart-modal" id="cartModal" onclick="event.stopPropagation()">
    <div class="cart-header">
      <h3><i class="fas fa-shopping-cart"></i> Carrito</h3>
      <button onclick="toggleCart()"><i class="fas fa-times"></i></button>
    </div>
    <div class="cart-items" id="cartItems">
      <div class="cart-empty">Tu carrito está vacío</div>
    </div>
    <div class="cart-footer">
      <div class="cart-total">
        <span>Total</span>
        <span id="cartTotal">$0.00</span>
      </div>
      <button class="btn-whatsapp-order" id="btnWhatsapp" onclick="sendToWhatsApp()" disabled>
        <i class="fab fa-whatsapp"></i> Enviar a WhatsApp
      </button>
    </div>
  </div>
</div>
<button class="cart-fab" onclick="toggleCart()">
  <i class="fas fa-shopping-cart"></i>
  <span class="badge" id="cartBadge">0</span>
</button>
<div class="cart-toast" id="cartToast">Agregado al carrito</div>

<!-- Contacto -->
<section id="contacto">
  <div class="container">
    <div class="text-center mb-4">
      <h2 style="font-size:1.8rem;"><i class="fas fa-envelope"></i> Contáctanos</h2>
      <p style="color:#6b5342;">¿Tienes alguna pregunta o pedido especial? Escríbenos</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="contact-form-card">
          <div id="contactError" style="display:none;background:#fce4d6;color:#c0392b;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;align-items:center;gap:10px;">
            <i class="fas fa-info-circle fa-lg"></i> <span id="contactErrorText">Se deben llenar todos los campos del formulario.</span>
          </div>
          <div id="contactSuccess" style="display:none;background:#d4edda;color:#155724;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-weight:600;align-items:center;gap:10px;">
            <i class="fas fa-check-circle fa-lg"></i> El mensaje se envió correctamente.
          </div>
          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label for="contactName" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="contactName" placeholder="Tu nombre">
              </div>
              <div class="col-md-6">
                <label for="contactPhone" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="contactPhone" placeholder=" Tu teléfono">
              </div>
              <div class="col-md-6">
                <label for="contactEmail" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="contactEmail" placeholder="tu@correo.com">
              </div>
              <div class="col-12">
                <label for="contactMessage" class="form-label">Mensaje</label>
                <textarea class="form-control" id="contactMessage" rows="4" placeholder="Escribe tu mensaje..."></textarea>
              </div>
              <div class="col-12 text-center">
                <button type="button" onclick="sendContact()" class="btn-contact-send" id="btnContactSend">
                  <span class="spinner"></span>
                  <span class="btn-text"><i class="fas fa-paper-plane"></i> Enviar mensaje</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="social">
      <a href="https://www.facebook.com/people/JuanPanchos-Computers-Tehuac%C3%A1n/61577993078029/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
      <a href="https://www.instagram.com/juanpanchos_tehuacan/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    </div>
    <p style="margin-top: 8px;"><i class="fas fa-heart" style="color: #e85d3a;"></i> Comida Casera — Hecho con amor by 
      <a href="https://resendiz1.github.io/juanpancho-s/" target="_blank" style="color: #6b5342; text-decoration: none;">
      &lt;JuanPancho's/&gt; 
      </a>
    </p>
    @guest
      <p style="margin-top: 12px; font-size: .75rem; opacity: .4;">
        <a href="{{ route('login') }}" style="color: #6b5342; text-decoration: none;">
          <i class="fas fa-lock"></i>
        </a>
      </p>
    @endguest
  </div>
</footer>

</body>
<script>
// ── Carousel ──
function moveCarousel(btn, dir) {
  const carousel = btn.closest('.carousel');
  const imgs = carousel.querySelectorAll('.carousel-img');
  const dots = carousel.querySelectorAll('.carousel-dot');
  let current = parseInt(carousel.dataset.current);
  imgs[current].classList.remove('active');
  if (dots.length) dots[current].classList.remove('active');
  current = (current + dir + imgs.length) % imgs.length;
  imgs[current].classList.add('active');
  if (dots.length) dots[current].classList.add('active');
  carousel.dataset.current = current;
}
function goToSlide(dot, idx) {
  const carousel = dot.closest('.carousel');
  const imgs = carousel.querySelectorAll('.carousel-img');
  const dots = carousel.querySelectorAll('.carousel-dot');
  let current = parseInt(carousel.dataset.current);
  imgs[current].classList.remove('active');
  dots[current].classList.remove('active');
  imgs[idx].classList.add('active');
  dots[idx].classList.add('active');
  carousel.dataset.current = idx;
}

// ── Sidebar ──
function toggleSidebar() {
  document.querySelector('.sidebar').classList.toggle('open');
  document.querySelector('.sidebar-overlay').classList.toggle('show');
}
document.querySelectorAll('.sidebar a').forEach(a => {
  a.addEventListener('click', () => {
    document.querySelector('.sidebar').classList.remove('open');
    document.querySelector('.sidebar-overlay').classList.remove('show');
  });
});
// scroll-spy
(function() {
  const sections = document.querySelectorAll('section[id]');
  const links = document.querySelectorAll('.sidebar a');
  if (!sections.length) return;
  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(s => {
      if (window.scrollY >= s.offsetTop - 120) current = s.id;
    });
    links.forEach(l => {
      l.classList.toggle('active', l.getAttribute('href') === '#' + current);
    });
  });
})();

// ── Cart ──
let cart = [];
try { cart = JSON.parse(localStorage.getItem('comidaCart') || '[]'); } catch(e) { cart = []; }

function saveCart() {
  localStorage.setItem('comidaCart', JSON.stringify(cart));
  renderCart();
}

// ── Lightbox ──
window.openLightbox = function(src) {
  document.getElementById('lightboxImg').src = src;
  document.getElementById('lightbox').classList.add('show');
}
window.closeLightbox = function() {
  document.getElementById('lightbox').classList.remove('show');
}
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') window.closeLightbox();
});

function addToCart(id, name, price) {
  const existing = cart.find(item => item.id === id);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ id, name, price, qty: 1 });
  }
  saveCart();
  showToast('✓ ' + name + ' agregado');
}

function removeFromCart(id) {
  cart = cart.filter(item => item.id !== id);
  saveCart();
}

function changeQty(id, delta) {
  const item = cart.find(i => i.id === id);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) {
    removeFromCart(id);
  } else {
    saveCart();
  }
}

function renderCart() {
  const container = document.getElementById('cartItems');
  const badge = document.getElementById('cartBadge');
  const totalEl = document.getElementById('cartTotal');
  const btn = document.getElementById('btnWhatsapp');

  const totalItems = cart.reduce((sum, i) => sum + i.qty, 0);
  const totalPrice = cart.reduce((sum, i) => sum + i.price * i.qty, 0);

  badge.textContent = totalItems;
  badge.classList.toggle('show', totalItems > 0);
  totalEl.textContent = '$' + totalPrice.toFixed(2);
  btn.disabled = totalItems === 0;

  if (totalItems === 0) {
    container.innerHTML = '<div class="cart-empty">Tu carrito está vacío</div>';
    return;
  }

  container.innerHTML = cart.map(item => `
    <div class="cart-item">
      <div class="cart-item-info">
        <h4>${item.name}</h4>
        <div class="item-price">$${item.price.toFixed(2)}</div>
      </div>
      <div class="cart-item-qty">
        <button onclick="changeQty(${item.id}, -1)">−</button>
        <span>${item.qty}</span>
        <button onclick="changeQty(${item.id}, 1)">+</button>
      </div>
      <button class="cart-item-remove" onclick="removeFromCart(${item.id})"><i class="fas fa-trash"></i></button>
    </div>
  `).join('');
}

function toggleCart() {
  const overlay = document.getElementById('cartOverlay');
  overlay.classList.toggle('active');
}

function sendToWhatsApp() {
  if (cart.length === 0) return;
  const total = cart.reduce((sum, i) => sum + i.price * i.qty, 0);
  let msg = '¡Hola! Quiero hacer un pedido:\n';
  cart.forEach(item => {
    msg += `\n• ${item.qty}x ${item.name} — $${(item.price * item.qty).toFixed(2)}`;
  });
  msg += `\n\n📦 Total: $${total.toFixed(2)}`;
  window.open(`https://wa.me/521234567890?text=${encodeURIComponent(msg)}`, '_blank');
}

function showToast(text) {
  const el = document.getElementById('cartToast');
  el.textContent = text;
  el.classList.add('show');
  clearTimeout(el._timer);
  el._timer = setTimeout(() => el.classList.remove('show'), 2000);
}

renderCart();
</script>

<!-- EmailJS -->
<script>
emailjs.init('m202FJpgz8JlMhJrh');

function sendContact() {
  const btn = document.getElementById('btnContactSend');
  const name = document.getElementById('contactName').value.trim();
  const phone = document.getElementById('contactPhone').value.trim();
  const email = document.getElementById('contactEmail').value.trim();
  const message = document.getElementById('contactMessage').value.trim();
  const error = document.getElementById('contactError');
  const errorText = document.getElementById('contactErrorText');
  const success = document.getElementById('contactSuccess');

  error.style.display = 'none';
  success.style.display = 'none';

  if (!name || !phone || !message) {
    errorText.textContent = 'Se deben llenar todos los campos del formulario.';
    error.style.display = 'flex';
    setTimeout(() => { error.style.display = 'none'; }, 4000);
    return;
  }

  if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    errorText.textContent = 'Ingresa un correo electrónico válido.';
    error.style.display = 'flex';
    setTimeout(() => { error.style.display = 'none'; }, 4000);
    return;
  }

  btn.disabled = true;
  btn.classList.add('loading');

  const params = {
    to_email: 'arturo.resendiz@grupopabsa.com',
    name: name,
    phone: phone,
    email: email || 'No proporcionado',
    message: message
  };

  emailjs.send('service_9m5rcfq', 'template_cfgl7gs', params)
    .then(() => {
      success.style.display = 'flex';
      setTimeout(() => { success.style.display = 'none'; }, 4000);
      document.getElementById('contactName').value = '';
      document.getElementById('contactPhone').value = '';
      document.getElementById('contactEmail').value = '';
      document.getElementById('contactMessage').value = '';
    })
    .catch(() => {
      alert('Error al enviar el mensaje. Intenta de nuevo.');
    })
    .finally(() => {
      btn.disabled = false;
      btn.classList.remove('loading');
    });
}
</script>

</html>
