<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Course;
use App\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->withCount('materials')->get();
        return view('instructor.courses.materials.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        
        if ($course->instructor_id != Auth::id()) {
            return redirect()->route('instructor.materials.index')->with('error', 'Unauthorized access.');
        }

        $materials = CourseMaterial::where('course_id', $course->id)->latest()->get();
        return view('instructor.courses.materials.show', compact('course', 'materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:file,link,announcement',
            'title' => 'required|string|max:255',
            'material' => 'required_if:type,file|nullable|mimes:pdf,docx,doc|max:10240',
            'link_url' => 'required_if:type,link|nullable|url',
            'content' => 'required_if:type,announcement|nullable|string',
        ]);

        $course = Course::findOrFail($request->input('course_id'));
        if ($course->instructor_id != Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        $path = null;
        if ($request->input('type') === 'file' && $request->hasFile('material')) {
            $file = $request->file('material');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('course_materials', $filename, 'public');
        }

        $status = $course->status === 'published' ? 'approved' : 'pending';

        CourseMaterial::create([
            'course_id' => $request->input('course_id'),
            'instructor_id' => Auth::id(),
            'type' => $request->input('type'),
            'title' => $request->input('title'),
            'file_path' => $path,
            'link_url' => $request->input('link_url'),
            'content' => $request->input('content'),
            'status' => $status,
            'admin_note' => $status === 'approved' ? 'Auto-approved because course is published.' : null,
        ]);

        $message = $status === 'approved' 
            ? 'Learning material/resource created and automatically approved.' 
            : 'Learning material/resource created successfully and awaiting approval.';

        return back()->with('success', $message);
    }

    public function destroy($id)
    {
        $material = CourseMaterial::findOrFail($id);
        if ($material->instructor_id != Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        Storage::disk('public')->delete($material->file_path);
        $material->delete();

        return back()->with('success', 'Material deleted successfully.');
    }

    public function download(\App\CourseMaterial $material)
    {
        if ($material->instructor_id != Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        if ($material->type !== 'file' || empty($material->file_path)) {
            return back()->with('error', 'Invalid material or no file associated.');
        }
        
        $path = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($path)) {
            return back()->with('error', 'File not found on server.');
        }

        return response()->download($path, $material->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
