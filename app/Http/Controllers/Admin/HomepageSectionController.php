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
    public function store(Request $request, HomepageSection $section)
{
    $data = $request->validate([
        'section_key' => 'required',
        'title' => 'nullable|string',
        'subtitle' => 'nullable|string',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image',
        'position' => 'required|integer',
        'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        'background_video' => 'nullable|mimetypes:video/mp4,video/avi,video/mov,video/wmv',
    ]);

    if ($request->hasFile('background_image')) {

        // delete old
        if ($section->background_image) {
            Storage::disk('public')->delete($section->background_image);
        }

        // store new
        $data['background_image'] = $request
            ->file('background_image')
            ->store('home_sections/backgrounds', 'public');
    }

    /* ✅ BACKGROUND VIDEO */
    if ($request->hasFile('background_video')) {

        if ($section->background_video) {
            Storage::disk('public')->delete($section->background_video);
        }

        $data['background_video'] = $request
            ->file('background_video')
            ->store('home_sections/videos', 'public');
    }

    $imagesPath = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imagesPath[] = $file->store('home_sections/', 'public');
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
        'background_image' => 'nullable|image',
        'background_video' => 'nullable|mimetypes:video/mp4,video/avi,video/mov,video/wmv',
    ]);
if ($request->hasFile('background_image')) {

        // delete old
        if ($section->background_image) {
            Storage::disk('public')->delete($section->background_image);
        }

        // store new
        $data['background_image'] = $request
            ->file('background_image')
            ->store('home_sections/background', 'public');
    }

    /* ✅ BACKGROUND VIDEO */
    if ($request->hasFile('background_video')) {

        if ($section->background_video) {
            Storage::disk('public')->delete($section->background_video);
        }

        $data['background_video'] = $request
            ->file('background_video')
            ->store('home_sections/videos', 'public');
    }

    /*if ($request->hasFile('images')) {
        $images = [];
        foreach ($request->file('images') as $img) {
            $images[] = $img->store('home/scroll_images', 'public');
        }
        $data['images'] = $images;
    }*/


    $images = $section->images ?? [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $images[] = $file->store('home_sections', 'public');
        }
    }

    $data['images'] = $images;

    $section->update($data);

    return redirect()->route('admin.home.sections.index')->with('success', 'Section updated!');
}

    public function destroy(HomepageSection $section)
    {
        $section->delete();
        return back()->with('success', 'Section removed!');
    }
}
