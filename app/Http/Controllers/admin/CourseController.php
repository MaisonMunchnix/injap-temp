<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Course;
use App\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function allEnrollments()
    {
        $enrollments = Enrollment::with('course.instructor')->latest()->get();
        $courses     = Course::orderBy('title')->get(['id', 'title']);
        return view('admin.courses.enrollments', compact('enrollments', 'courses'));
    }

    public function updateEnrollmentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,refunded',
        ]);

        $enrollment->update(['payment_status' => $request->status]);

        return redirect()->back()->with('success', 'Enrollment payment status updated successfully.');
    }

    public function destroyEnrollment(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->back()->with('success', 'Enrollment deleted successfully.');
    }

    public function updateStatus(Request $request, Course $course)
    {
        $request->validate([
            'status' => 'required|in:pending,published,rejected',
        ]);

        $course->update(['status' => $request->status]);

        // Auto-approve pending materials if course is specifically being approved (published)
        if ($request->status === 'published') {
            \App\CourseMaterial::where('course_id', $course->id)
                ->where('status', 'pending')
                ->update(['status' => 'approved', 'admin_note' => 'Auto-approved alongside course publication.']);
        }

        return redirect()->back()->with('success', 'Course status updated successfully.');
    }

    public function updatePrice(Request $request, Course $course)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $course->update(['price' => $request->price]);

        return redirect()->back()->with('success', 'Course price updated successfully.');
    }

    public function show(Course $course)
    {
        return response()->json($course->load(['instructor', 'materials']));
    }

    public function allMaterials()
    {
        $materials = \App\CourseMaterial::with(['course', 'instructor'])->latest()->get();
        $courses   = Course::orderBy('title')->get(['id', 'title']);
        return view('admin.courses.materials', compact('materials', 'courses'));
    }

    public function updateMaterialStatus(Request $request, \App\CourseMaterial $material)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string',
        ]);

        $material->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->back()->with('success', 'Material status updated successfully.');
    }
}
