<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;

class ShopController extends Controller {
    public function home(){
        $products = Product::latest()->take(8)->get();

        $contents = \App\Models\ShopContent::latest()->take(3)->get();

        return view('shop.home', compact('products', 'contents'));
    }

    // 🛍️ Show all products
    public function index(Request $request)
    {
        $query = Product::with(['brand','category'])->latest();

        if ($request->filled('search')) {
            $query->where('name','like','%'.$request->search.'%');
        }

        $products = $query->paginate(12);
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('shop.products.index', compact('products','brands','categories'));
    }

    public function show(Product $product){
        return view('shop.products.show', compact('product'));
    }

        // 🏷️ Filter by brand
    public function filterByBrand($slug)
    {
        $brand = Brand::where('slug',$slug)->firstOrFail();
        $products = Product::with(['brand','category'])
                    ->where('brand_id',$brand->id)
                    ->paginate(12);

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('shop.products.index', compact('products','brands','categories','brand'));
    }

    // 🗂️ Filter by category
    public function filterByCategory($slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        $products = Product::with(['brand','category'])
                    ->where('category_id',$category->id)
                    ->paginate(12);

        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('shop.products.index', compact('products','brands','categories','category'));
    }

}


