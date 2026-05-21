const menu = {
  tortas: [
    { name: 'Torta de milanesa', desc: 'Milanesa de res, lechuga, jitomate, aguacate y crema', price: 55, img: 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a7?w=400&h=300&fit=crop' },
    { name: 'Torta de jamón', desc: 'Jamón de pierna, queso panela, lechuga y jitomate', price: 45, img: 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=400&h=300&fit=crop' },
    { name: 'Torta de pastor', desc: 'Pastor, piña, cebolla, cilantro y salsa', price: 60, img: 'https://images.unsplash.com/photo-1552332386-f8dd00dc0f58?w=400&h=300&fit=crop' },
    { name: 'Torta de pierna', desc: 'Pierna de cerdo adobada, guacamole y frijoles', price: 50, img: 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=400&h=300&fit=crop' },
  ],
  desayunos: [
    { name: 'Huevos al gusto', desc: 'Huevos estrellados, revueltos o a la mexicana', price: 45, img: 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=400&h=300&fit=crop' },
    { name: 'Chilaquiles verdes', desc: 'Totopos bañados en salsa verde, crema y queso', price: 65, img: 'https://images.unsplash.com/photo-1534352956036-cd81e27dd615?w=400&h=300&fit=crop' },
    { name: 'Hot cakes', desc: 'Stack de 3 hot cakes con miel y mantequilla', price: 55, img: 'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=300&fit=crop' },
    { name: 'Molletes', desc: 'Bolillo con frijoles, queso gratinado y pico de gallo', price: 40, img: 'https://images.unsplash.com/photo-1559742811-822f4580b12e?w=400&h=300&fit=crop' },
  ],
  comida: [
    { name: 'Comida corrida', desc: 'Guisado del día, arroz, frijoles y tortillas', price: 75, img: 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop' },
    { name: 'Mole con pollo', desc: 'Pechuga de pollo bañada en mole poblano con arroz', price: 85, img: 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400&h=300&fit=crop' },
    { name: 'Bisteces a la mexicana', desc: 'Bisteces en salsa de jitomate, cebolla y chile', price: 80, img: 'https://images.unsplash.com/photo-1553163147-622ab57be1c7?w=400&h=300&fit=crop' },
    { name: 'Pechuga empanizada', desc: 'Pechuga empanizada con ensalada y papas', price: 80, img: 'https://images.unsplash.com/photo-1432139555190-58524dae6a55?w=400&h=300&fit=crop' },
  ],
  postres: [
    { name: 'Flan napolitano', desc: 'Flan cremoso con caramelo', price: 35, img: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop' },
    { name: 'Gelatina de mosaico', desc: 'Gelatina de leche con cuadros de colores', price: 25, img: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400&h=300&fit=crop' },
    { name: 'Pastel de chocolate', desc: 'Rebanada de pastel de chocolate con chantillín', price: 45, img: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400&h=300&fit=crop' },
    { name: 'Arroz con leche', desc: 'Arroz con leche tradicional canela y pasas', price: 30, img: 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&h=300&fit=crop' },
  ],
  antojitos: [
    { name: 'Quesadillas', desc: 'Quesadillas de harina con queso y tu guisado favorito', price: 25, img: 'https://images.unsplash.com/photo-1618040996337-56904b7850b9?w=400&h=300&fit=crop' },
    { name: 'Sopes', desc: 'Sopes de masa con frijoles, crema, queso y salsa', price: 20, img: 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400&h=300&fit=crop' },
    { name: 'Tacos de canasta', desc: 'Tacos de canasta surtidos (chicharrón, papa, frijoles)', price: 15, img: 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=400&h=300&fit=crop' },
    { name: 'Elote preparado', desc: 'Elote desgranado con crema, queso, mayonesa y chile', price: 35, img: 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=400&h=300&fit=crop' },
  ],
};

const WHATSAPP_NUMBER = '521234567890';

function render() {
  for (const [cat, items] of Object.entries(menu)) {
    const grid = document.getElementById(`grid-${cat}`);
    grid.innerHTML = items.map((item, i) => `
      <div class="card">
        <img src="${item.img}" alt="${item.name}" loading="lazy">
        <div class="card-body">
          <h3>${item.name}</h3>
          <p class="desc">${item.desc}</p>
          <div class="card-footer">
            <span class="price">$${item.price}</span>
            <button class="btn-whatsapp" data-cat="${cat}" data-idx="${i}">
              <i class="fab fa-whatsapp"></i> Pedir
            </button>
          </div>
        </div>
      </div>
    `).join('');
  }
}

render();

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.card').forEach(card => observer.observe(card));

let currentProduct = null;
let quantity = 1;
const modal = document.getElementById('modal');
const modalProduct = document.getElementById('modal-product');
const qtyDisplay = document.getElementById('qty-display');
const modalNotes = document.getElementById('modal-notes');
const modalAddress = document.getElementById('modal-address');
const modalPayment = document.getElementById('modal-payment');
const modalTitle = document.getElementById('modal-title');

document.addEventListener('click', e => {
  const btn = e.target.closest('[data-cat]');
  if (!btn) return;
  const cat = btn.dataset.cat;
  const idx = btn.dataset.idx;
  currentProduct = menu[cat][idx];
  quantity = 1;
  modalProduct.value = currentProduct.name;
  qtyDisplay.textContent = '1';
  modalNotes.value = '';
  modalAddress.value = '';
  modalPayment.value = 'Efectivo';
  modalTitle.textContent = `Pedir: ${currentProduct.name}`;
  modal.classList.add('active');
});

document.getElementById('qty-dec').addEventListener('click', () => {
  if (quantity > 1) { quantity--; qtyDisplay.textContent = quantity; }
});

document.getElementById('qty-inc').addEventListener('click', () => {
  quantity++; qtyDisplay.textContent = quantity;
});

document.getElementById('modal-cancel').addEventListener('click', () => {
  modal.classList.remove('active');
});

modal.addEventListener('click', e => {
  if (e.target === modal) modal.classList.remove('active');
});

document.getElementById('modal-send').addEventListener('click', () => {
  if (!currentProduct) return;
  const notes = modalNotes.value.trim();
  const address = modalAddress.value.trim();
  const payment = modalPayment.value;

  let msg = `Hola, quiero hacer un pedido:\n\n`;
  msg += `Producto: ${currentProduct.name}\n`;
  msg += `Cantidad: ${quantity}\n`;
  if (notes) msg += `Notas: ${notes}\n`;
  if (address) msg += `Dirección: ${address}\n`;
  msg += `Forma de pago: ${payment}`;

  const url = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`;
  window.open(url, '_blank');
  modal.classList.remove('active');
});
