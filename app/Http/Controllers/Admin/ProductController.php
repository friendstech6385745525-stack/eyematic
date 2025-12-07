<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function __construct(){ $this->middleware(['auth','role:admin,superadmin']); }

    public function index(Request $request)
{
    $query = \App\Models\Product::with(['brand','category','user']);

    // ✅ Filter by name
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }

    // ✅ Filter by brand
    if ($request->filled('brand_id')) {
        $query->where('brand_id', $request->brand_id);
    }

    // ✅ Filter by category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $products = $query->latest()->paginate(10)->withQueryString();
    $brands = \App\Models\Brand::orderBy('name')->get();
    $categories = \App\Models\Category::orderBy('name')->get();

    return view('admin.products.index', compact('products','brands','categories'));
}

    public function create(){ 
        $brands = \App\Models\Brand::all();
        $categories = \App\Models\Category::all();
        return view('admin.products.create', compact('brands','categories'));

        }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'stock'=>'integer|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'images.*'=>'image|max:5120'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products','public');
                $images[] = $path;
            }
        }

        $product = Product::create([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']).'-'.uniqid(),
            'description'=>$data['description'] ?? null,
            'price'=>$data['price'],
            'discount'=>$data['discount'] ?? 0,
            'stock'=>$data['stock'] ?? 0,
            'category_id'=>$data['category_id'] ?? null,
            'brand_id'=>$data['brand_id'] ?? null,
            'images'=>$images
        ]);

        return redirect()->route('admin.products.index')->with('success','Product created');
    }

    public function edit(Product $product){ 
        $brands = \App\Models\Brand::all();
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product','brands','categories'));
    }

    public function update(Request $request, Product $product){
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'stock'=>'integer|min:0',
            'images.*'=>'image|max:5120'
        ]);

        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products','public');
                $images[] = $path;
            }
        }

        $product->update([
            'name'=>$data['name'],
            'slug'=>Str::slug($data['name']).'-'.uniqid(),
            'description'=>$data['description'] ?? null,
            'price'=>$data['price'],
            'discount'=>$data['discount'] ?? 0,
            'stock'=>$data['stock'] ?? 0,
            'images'=>$images
        ]);

        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function destroy(Product $product){
        // delete images from storage
        if ($product->images) {
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();
        return back()->with('success','Deleted');
    }
}
