<x-admin-layout>
  @section('title', 'Productos')

  <div class="admin-toolbar">
    <h2 class="admin-title" style="margin-bottom:0;"><i class="fas fa-box"></i> Productos</h2>
    <a href="{{ route('admin.products.create') }}" class="admin-btn">
      <i class="fas fa-plus"></i> Nuevo producto
    </a>
  </div>

  <div class="admin-card">
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Visible</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
            <tr>
              <td class="td-img" data-label="Imagen">
                <div class="admin-img-stack">
                  @php
                    $mainImg = $product->image
                      ? (Str::startsWith($product->image, 'http') ? $product->image : Storage::url($product->image))
                      : 'https://via.placeholder.com/80x80?text=Sin+img';
                  @endphp
                  <img src="{{ $mainImg }}">
                  @foreach($product->images->take(2) as $img)
                    <img src="{{ Storage::url($img->image_path) }}">
                  @endforeach
                  @if($product->images->count() > 2)
                    <span>+{{ $product->images->count() - 2 }}</span>
                  @endif
                </div>
              </td>
              <td class="td-name" data-label="Nombre"><strong>{{ $product->name }}</strong></td>
              <td data-label="Categoría"><span class="admin-badge" style="background:#fce4d6;color:#e85d3a;">{{ ucfirst($product->category) }}</span></td>
              <td class="td-price" data-label="Precio"><strong>${{ number_format($product->price, 2) }}</strong></td>
              <td data-label="Visible">
                <span class="admin-badge {{ $product->visible ? 'admin-badge-yes' : 'admin-badge-no' }}">
                  {{ $product->visible ? 'Sí' : 'No' }}
                </span>
              </td>
              <td data-label="Acciones">
                <div class="td-actions">
                  <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn" style="padding:6px 14px;font-size:.8rem;">
                    <i class="fas fa-edit"></i> Editar
                  </a>
                  <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn-red" style="padding:6px 14px;font-size:.8rem;">
                      <i class="fas fa-trash"></i> Eliminar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="admin-pagination">
      {{ $products->links() }}
    </div>
  </div>
</x-admin-layout>
