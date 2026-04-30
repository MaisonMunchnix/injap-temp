<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AboutGallery;
use Illuminate\Support\Facades\File;
use DataTables;

class AboutGalleryController extends Controller
{
    public function index()
    {
        return view('admin.about_gallery.index');
    }

    public function getGalleryData(Request $request)
    {
        if ($request->ajax()) {
            $galleries = AboutGallery::orderBy('order', 'asc')->get();
            return DataTables::of($galleries)
                ->editColumn('image_path', function($gallery) {
                    return '<img src="'.asset($gallery->image_path).'" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                })
                ->editColumn('description', function($gallery) {
                    return \Illuminate\Support\Str::limit(strip_tags($gallery->description), 50);
                })
                ->editColumn('is_active', function($gallery) {
                    return $gallery->is_active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
                })
                ->addColumn('action', function($gallery) {
                    return '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="'.$gallery->id.'">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$gallery->id.'">Delete</button>
                            </div>';
                })
                ->rawColumns(['image_path', 'description', 'is_active', 'action'])
                ->make(true);
        }
    }

    public function getData($id)
    {
        $gallery = AboutGallery::findOrFail($id);
        return response()->json($gallery);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'order' => 'nullable|integer',
        ]);

        $gallery = new AboutGallery();
        $gallery->description = $request->description;
        $gallery->order = $request->order ?? 0;
        $gallery->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $gallery->image_path = $this->uploadImage($request->file('image'));
        }

        $gallery->save();

        return response()->json(['status' => 'Created']);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'order' => 'nullable|integer',
        ]);

        $gallery = AboutGallery::findOrFail($id);
        $gallery->description = $request->description;
        $gallery->order = $request->order ?? 0;
        $gallery->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($gallery->image_path && File::exists(public_path($gallery->image_path))) {
                File::delete(public_path($gallery->image_path));
            }
            $gallery->image_path = $this->uploadImage($request->file('image'));
        }

        $gallery->save();

        return response()->json(['status' => 'Updated']);
    }

    public function destroy(Request $request)
    {
        $gallery = AboutGallery::findOrFail($request->id);
        if ($gallery->image_path && File::exists(public_path($gallery->image_path))) {
            File::delete(public_path($gallery->image_path));
        }
        $gallery->delete();

        return response()->json(['status' => 'Deleted']);
    }

    private function uploadImage($file)
    {
        $name = time() . '_' . $file->getClientOriginalName();
        $path = 'assets/img/about_gallery/';
        
        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true, true);
        }

        $file->move(public_path($path), $name);
        return $path . $name;
    }
}
