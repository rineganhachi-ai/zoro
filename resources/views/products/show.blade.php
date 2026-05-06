@extends('layouts.app')

@section('title', 'Detail - ' . $product->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Detail Produk</h5>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="rounded img-fluid"
                                 style="max-height: 300px; object-fit: contain;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="height: 300px;">
                                <div class="text-muted">
                                    <i class="bi bi-image fs-1"></i>
                                    <p class="mt-2">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama Produk</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th>SKU</th>
                                <td><code>{{ $product->sku }}</code></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><span class="badge bg-info">{{ $product->category }}</span></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td class="fs-5 fw-bold text-primary">{{ $product->price_formatted }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    <span class="badge @if($product->stock > 10) bg-success @elseif($product->stock > 0) bg-warning text-dark @else bg-danger @endif fs-6">
                                        {{ $product->stock }} unit
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge @if($product->is_active) bg-success @else bg-secondary @endif">
                                        {{ $product->status_text }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat oleh</th>
                                <td>{{ $product->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat pada</th>
                                <td>{{ $product->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate pada</th>
                                <td>{{ $product->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>

                        @if($product->description)
                            <h6 class="mt-3">Deskripsi:</h6>
                            <p class="text-muted">{{ nl2br(e($product->description)) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 text-end">
            <form method="POST"
                  action="{{ route('products.destroy', $product) }}"
                  onsubmit="return confirm('YAKIN ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection