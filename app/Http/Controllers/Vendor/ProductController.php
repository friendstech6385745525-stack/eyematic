<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:vendor,superadmin']);
    }

    /**
     * Show all products created by this vendor.
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->latest()->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('vendor.products.create');
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|max:5120', // 5MB
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('products', 'public');
            }
        }

        Product::create([
            'user_id'     => auth()->id(),
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']) . '-' . uniqid(),
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'images'      => $images,
        ]);

        return redirect()->route('vendor.products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Edit existing product.
     */
    public function edit(Product $product)
    {
        // Allow vendor to edit only their own products
        abort_if($product->user_id !== auth()->id() && auth()->user()->role !== 'superadmin', 403);

        return view('vendor.products.edit', compact('product'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== auth()->id() && auth()->user()->role !== 'superadmin', 403);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'images.*'    => 'nullable|image|max:5120',
        ]);

        $images = $product->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('products', 'public');
            }
        }

        $product->update([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']) . '-' . uniqid(),
            'description' => $data['description'] ?? null,
            'price'       => $data['price'],
            'stock'       => $data['stock'],
            'images'      => $images,
        ]);

        return redirect()->route('vendor.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        abort_if($product->user_id !== auth()->id() && auth()->user()->role !== 'superadmin', 403);

        if ($product->images) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }
}
