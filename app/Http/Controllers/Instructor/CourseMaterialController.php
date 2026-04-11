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
            'title' => 'required|string|max:255',
            'material' => 'required|mimes:pdf|max:10240', // 10MB limit
        ]);

        $course = Course::findOrFail($request->course_id);
        if ($course->instructor_id != Auth::id()) {
            return back()->with('error', 'Unauthorized access.');
        }

        $file = $request->file('material');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('course_materials', $filename, 'public');

        $status = $course->status === 'published' ? 'approved' : 'pending';

        CourseMaterial::create([
            'course_id' => $request->course_id,
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'file_path' => $path,
            'status' => $status,
            'admin_note' => $status === 'approved' ? 'Auto-approved because course is published.' : null,
        ]);

        $message = $status === 'approved' 
            ? 'Learning material uploaded and automatically approved.' 
            : 'Learning material uploaded successfully and awaiting approval.';

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
}
