<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    public function index()
    {
        $sections = HomepageSection::orderBy('position')->get();
        return view('admin.home_sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.home_sections.create');
    }

/*    public function store(Request $request)
    {
        $data = $request->validate([
            'section_key' => 'required|string',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'position' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home_sections', 'public');
        }

        HomepageSection::create($data);

        return redirect()->route('admin.home.sections.index')->with('success', 'Section added successfully!');
    }
*/
    public function store(Request $request)
{
    $data = $request->validate([
        'section_key' => 'required',
        'title' => 'nullable|string',
        'subtitle' => 'nullable|string',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image',
        'position' => 'required|integer',
    ]);

    $imagesPath = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imagesPath[] = $file->store('home_sections', 'public');
        }
    }

    $data['images'] = $imagesPath;

    HomepageSection::create($data);

    return redirect()->route('admin.home.sections.index')->with('success', 'Section created!');
}


    public function edit(HomepageSection $section)
    {
        return view('admin.home_sections.edit', compact('section'));
    }

/*    public function update(Request $request, HomepageSection $section)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'position' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home_sections', 'public');
        }

        $section->update($data);

        return back()->with('success', 'Section updated successfully!');
    }
*/

public function update(Request $request, HomepageSection $section)
{
    $data = $request->validate([
        'title' => 'nullable|string',
        'subtitle' => 'nullable|string',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image',
        'position' => 'required|integer',
    ]);

    $images = $section->images ?? [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $images[] = $file->store('home_sections', 'public');
        }
    }

    $data['images'] = $images;

    $section->update($data);

    return back()->with('success', 'Section updated!');
}

    public function destroy(HomepageSection $section)
    {
        $section->delete();
        return back()->with('success', 'Section removed!');
    }
}
