<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopContent;
use Illuminate\Http\Request;

class ShopContentController extends Controller
{
    public function index()
    {
        $contents = ShopContent::latest()->paginate(10);
        return view('admin.shop_content.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.shop_content.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);

        $path = $request->file('image')?->store('shop_content', 'public');

        ShopContent::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path
        ]);

        return redirect()->route('admin.shop_content.index')
            ->with('success', 'Content created successfully');
    }

    public function edit(ShopContent $shop_content)
    {
        return view('admin.shop_content.edit', compact('shop_content'));
    }

    public function update(Request $request, ShopContent $shop_content)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('shop_content', 'public');
            $shop_content->image = $path;
        }

        $shop_content->update($request->only('title', 'description'));

        return redirect()->route('admin.shop_content.index')
            ->with('success', 'Content updated');
    }

    public function destroy(ShopContent $shop_content)
    {
        $shop_content->delete();
        return back()->with('success', 'Deleted successfully');
    }
}
