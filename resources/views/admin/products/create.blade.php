<x-admin-layout>
  @section('title', 'Nuevo producto')

  <div style="margin-bottom:20px;">
    <a href="{{ route('admin.products.index') }}" style="color:#6b5342;text-decoration:none;font-size:.9rem;">
      <i class="fas fa-arrow-left"></i> Volver a productos
    </a>
  </div>

  <h2 class="admin-title"><i class="fas fa-plus-circle"></i> Nuevo producto</h2>

  <div class="admin-card">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
      @csrf

      <div style="margin-bottom:16px;">
        <label class="admin-label">Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}" class="admin-input" required>
        @error('name') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Descripción</label>
        <textarea name="description" rows="3" class="admin-textarea" required>{{ old('description') }}</textarea>
        @error('description') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Precio ($)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="admin-input" required>
        @error('price') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Categoría</label>
        <select name="category" class="admin-select" required>
          <option value="">Seleccionar...</option>
          <option value="tortas" @selected(old('category') == 'tortas')>Tortas</option>
          <option value="desayunos" @selected(old('category') == 'desayunos')>Desayunos</option>
          <option value="comida" @selected(old('category') == 'comida')>Comida corrida</option>
          <option value="postres" @selected(old('category') == 'postres')>Postres</option>
          <option value="antojitos" @selected(old('category') == 'antojitos')>Antojitos</option>
        </select>
        @error('category') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Imágenes del producto</label>
        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" id="imageInput" class="admin-file-input" required>
        <p style="font-size:.8rem;color:#6b5342;margin-top:4px;">La primera imagen será la principal. JPEG, PNG o WebP. Máximo 2MB c/u.</p>
        @error('images') <p class="admin-error">{{ $message }}</p> @enderror
        @error('images.*') <p class="admin-error">{{ $message }}</p> @enderror
        <div id="preview" class="admin-grid-4" style="margin-top:12px;"></div>
      </div>

      <div style="margin-bottom:24px;">
        <label class="inline-flex items-center" style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;">
          <input type="checkbox" name="visible" value="1" checked class="admin-checkbox">
          <span style="font-size:.9rem;color:#3d2b1f;">Visible en la página</span>
        </label>
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="admin-btn"><i class="fas fa-save"></i> Guardar producto</button>
        <a href="{{ route('admin.products.index') }}" class="admin-btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
      </div>
    </form>
  </div>
</x-admin-layout>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
  const preview = document.getElementById('preview');
  preview.innerHTML = '';
  Array.from(e.target.files).forEach((file, i) => {
    const reader = new FileReader();
    reader.onload = function(ev) {
      const div = document.createElement('div');
      div.className = 'admin-grid-item';
      div.innerHTML = `
        <img src="${ev.target.result}">
        <span class="admin-grid-badge ${i === 0 ? 'admin-grid-badge-main' : ''}">${i === 0 ? 'Principal' : i}</span>
        <button type="button" class="admin-grid-remove" onclick="this.parentElement.remove()" style="display:flex">&times;</button>
      `;
      preview.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
});
</script>
