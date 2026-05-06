@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Daftar Produk</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>
</div>

{{-- FILTER FORM --}}
<form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control"
               value="{{ request('search') }}" placeholder="Cari...">
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-auto">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

{{-- TABEL PRODUK --}}
<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Produk</th>
                <th>SKU</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <a href="{{ route('products.show', $product) }}">
                            {{ Str::limit($product->name, 40) }}
                        </a>
                        <br><small class="text-muted">{{ $product->category }}</small>
                    </td>
                    <td><code>{{ $product->sku }}</code></td>
                    <td>{{ $product->price_formatted }}</td>
                    <td>
                        <span class="badge @if($product->stock > 10) bg-success
                              @elseif($product->stock > 0) bg-warning text-dark
                              @else bg-danger @endif">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="badge @if($product->is_active) bg-success @else bg-secondary @endif">
                            {{ $product->status_text }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('products.show', $product) }}"
                               class="btn btn-outline-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}"
                               class="btn btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            {{-- FORM DELETE --}}
                            <form method="POST"
                                  action="{{ route('products.destroy', $product) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')  {{-- Override method ke DELETE --}}
                                <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <p class="text-muted">Belum ada produk</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            Tambah Produk Pertama
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection