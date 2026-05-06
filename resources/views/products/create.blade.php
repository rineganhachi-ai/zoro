@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card"><div class="card-body p-4">
            <h4 class="mb-4">Tambah Produk Baru</h4>

            <!-- enctype="multipart/form-data" WAJIB untuk upload file -->
            <form method="POST" action="{{ route('products.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku"
                                   class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku') }}" 
                                   style="text-transform:uppercase;"
                                   placeholder="LAPTOP-001">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    >
                                <option value="">-- Pilih --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}"
                                        {{ old('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}"  min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   value="{{ old('stock', 0) }}"  min="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input type="checkbox" name="is_active" value="1"
                                   class="form-check-input"
                                   {{ !old('is_active', true) ? '' : 'checked' }}>
                            <label class="form-check-label">Produk Aktif</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">
                                {{ old('description') }}
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label>Gambar Produk</label>
                            <input type="file" name="image" accept="image/*"
                                   class="form-control @error('image') is-invalid @enderror">
                            <div class="form-text">JPEG, PNG, GIF. Maks 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div></div>
    </div>
</div>

@push('scripts')
<script>
// Auto-uppercase SKU
document.querySelector('[name="sku"]').addEventListener('input', function() {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9\-]/g, '');
});
</script>
@endpush
@endsection