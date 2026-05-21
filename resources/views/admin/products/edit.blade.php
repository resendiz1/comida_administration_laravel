<x-admin-layout>
  @section('title', 'Editar producto')

  <div style="margin-bottom:20px;">
    <a href="{{ route('admin.products.index') }}" style="color:#6b5342;text-decoration:none;font-size:.9rem;">
      <i class="fas fa-arrow-left"></i> Volver a productos
    </a>
  </div>

  <h2 class="admin-title"><i class="fas fa-edit"></i> Editar producto</h2>

  <div class="admin-card">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div style="margin-bottom:16px;">
        <label class="admin-label">Nombre</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="admin-input" required>
        @error('name') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Descripción</label>
        <textarea name="description" rows="3" class="admin-textarea" required>{{ old('description', $product->description) }}</textarea>
        @error('description') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Precio ($)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="admin-input" required>
        @error('price') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Categoría</label>
        <select name="category" class="admin-select" required>
          <option value="">Seleccionar...</option>
          <option value="tortas" @selected(old('category', $product->category) == 'tortas')>Tortas</option>
          <option value="desayunos" @selected(old('category', $product->category) == 'desayunos')>Desayunos</option>
          <option value="comida" @selected(old('category', $product->category) == 'comida')>Comida corrida</option>
          <option value="postres" @selected(old('category', $product->category) == 'postres')>Postres</option>
          <option value="antojitos" @selected(old('category', $product->category) == 'antojitos')>Antojitos</option>
        </select>
        @error('category') <p class="admin-error">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Imagen principal actual</label>
        @if($product->image)
          @php
            $mainImg = Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image);
          @endphp
          <div style="margin-top:6px;">
            <img src="{{ $mainImg }}" style="height:100px;width:100px;object-fit:cover;border-radius:12px;border:1px solid #d4c5b8;">
          </div>
        @endif
      </div>

      <div style="margin-bottom:16px;">
        <label class="admin-label">Agregar imágenes adicionales</label>
        <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" id="imageInput" class="admin-file-input">
        <p style="font-size:.8rem;color:#6b5342;margin-top:4px;">JPEG, PNG o WebP. Máximo 2MB por imagen.</p>
        @error('images.*') <p class="admin-error">{{ $message }}</p> @enderror
        <div id="preview" class="admin-grid-4" style="margin-top:12px;"></div>

        @if($product->images->count())
          <div style="margin-top:16px;">
            <p style="font-weight:600;font-size:.85rem;color:#3d2b1f;margin-bottom:8px;">Imágenes guardadas</p>
            <div class="admin-grid-4">
              @foreach($product->images as $img)
                <div class="admin-grid-item">
                  <img src="{{ Storage::url($img->image_path) }}">
                  <form action="{{ route('admin.products.image.destroy', $img) }}" method="POST" class="admin-grid-remove" style="display:none;">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-grid-remove" style="display:flex;" onclick="return confirm('¿Eliminar esta imagen?')">&times;</button>
                  </form>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      <div style="margin-bottom:24px;">
        <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;">
          <input type="checkbox" name="visible" value="1" {{ old('visible', $product->visible) ? 'checked' : '' }} class="admin-checkbox">
          <span style="font-size:.9rem;color:#3d2b1f;">Visible en la página</span>
        </label>
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="admin-btn"><i class="fas fa-save"></i> Actualizar producto</button>
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
        <span class="admin-grid-badge">Nueva ${i + 1}</span>
        <button type="button" class="admin-grid-remove" onclick="this.parentElement.remove()" style="display:flex">&times;</button>
      `;
      preview.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
});
</script>
