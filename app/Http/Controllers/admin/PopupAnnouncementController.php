<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PopupAnnouncement;
use Illuminate\Support\Facades\File;
use DataTables;

class PopupAnnouncementController extends Controller
{
    public function index()
    {
        return view('admin.popup_announcements.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $announcements = PopupAnnouncement::latest()->get();
            return DataTables::of($announcements)
                ->editColumn('image', function($announcement) {
                    if ($announcement->image) {
                        return '<img src="'.asset($announcement->image).'" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->editColumn('description', function($announcement) {
                    return \Illuminate\Support\Str::limit(strip_tags($announcement->description), 50);
                })
                ->editColumn('is_active', function($announcement) {
                    return $announcement->is_active ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
                })
                ->addColumn('action', function($announcement) {
                    return '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="'.$announcement->id.'">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="'.$announcement->id.'">Delete</button>
                            </div>';
                })
                ->rawColumns(['image', 'description', 'is_active', 'action'])
                ->make(true);
        }
    }

    public function getSpecificData($id)
    {
        $announcement = PopupAnnouncement::findOrFail($id);
        return response()->json($announcement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'link' => 'nullable|url',
        ]);

        $announcement = new PopupAnnouncement();
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->link = $request->link;
        $announcement->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $announcement->image = $this->uploadImage($request->file('image'));
        }

        $announcement->save();

        return response()->json(['status' => 'Created']);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'link' => 'nullable|url',
        ]);

        $announcement = PopupAnnouncement::findOrFail($id);
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->link = $request->link;
        $announcement->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($announcement->image && File::exists(public_path($announcement->image))) {
                File::delete(public_path($announcement->image));
            }
            $announcement->image = $this->uploadImage($request->file('image'));
        }

        $announcement->save();

        return response()->json(['status' => 'Updated']);
    }

    public function destroy(Request $request)
    {
        $announcement = PopupAnnouncement::findOrFail($request->id);
        if ($announcement->image && File::exists(public_path($announcement->image))) {
            File::delete(public_path($announcement->image));
        }
        $announcement->delete();

        return response()->json(['status' => 'Deleted']);
    }

    private function uploadImage($file)
    {
        $name = time() . '_' . $file->getClientOriginalName();
        $path = 'assets/img/popup_announcements';
        $destinationPath = public_path($path);
        
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        $file->move($destinationPath, $name);
        return $path . '/' . $name;
    }
}
