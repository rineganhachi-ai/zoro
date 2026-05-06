<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    // Middleware: semua method butuh login
    public function __construct()
    {
        $this->middleware('auth');
    }

    // LIST: Dengan pagination, search, filter
    public function index(Request $request)
    {
        $query = Product::where('user_id', auth()->id());

        // Search by name/SKU
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // Filter category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pagination: 10 per halaman, pertahankan query string filter
        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $categories = ['Elektronik', 'Fashion', 'Makanan', 'Lainnya'];
        return view('products.index', compact('products', 'categories'));
    }

    // STORE: Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:50|unique:products,sku|regex:/^[A-Z0-9\-]+$/',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|in:Elektronik,Fashion,Makanan,Lainnya',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required'   => 'Nama produk wajib diisi',
            'sku.required'    => 'SKU wajib diisi',
            'sku.unique'      => 'SKU sudah digunakan',
            'sku.regex'       => 'SKU hanya boleh huruf besar, angka, dan dash',
            'price.required'  => 'Harga wajib diisi',
            'price.numeric'   => 'Harga harus berupa angka',
            'stock.required'  => 'Stok wajib diisi',
            'stock.integer'   => 'Stok harus bilangan bulat',
            'category.required' => 'Kategori wajib dipilih',
            'image.image'     => 'File harus berupa gambar',
            'image.max'       => 'Ukuran gambar maksimal 2MB',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE: Ubah produk
    public function update(Request $request, Product $product)
    {
        // Authorization: hanya pemilik yang bisa edit
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke produk ini');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:50|regex:/^[A-Z0-9\-]+$/|'
                           . Rule::unique('products', 'sku')->ignore($product->id),
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'required|in:Elektronik,Fashion,Makanan,Lainnya',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active'   => 'nullable|boolean',
        ], [
            'name.required'   => 'Nama produk wajib diisi',
            'sku.unique'      => 'SKU sudah digunakan',
            'price.required'  => 'Harga wajib diisi',
            'stock.required'  => 'Stok wajib diisi',
            'category.required' => 'Kategori wajib dipilih',
        ]);

        // Hapus gambar lama jika ada gambar baru
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // DESTROY: Hapus produk
    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // create(), show(), edit() -- mengembalikan view saja
    public function create()
    {
        return view('products.create', [
            'categories' => ['Elektronik', 'Fashion', 'Makanan', 'Lainnya']
        ]);
    }

    public function show(Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== auth()->id()) abort(403);
        return view('products.edit', [
            'product'    => $product,
            'categories' => ['Elektronik', 'Fashion', 'Makanan', 'Lainnya']
        ]);
    }
}