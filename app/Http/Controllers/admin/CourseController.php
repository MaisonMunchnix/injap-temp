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
        return view('admin.courses.enrollments', compact('enrollments'));
    }

    public function updateEnrollmentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,refunded',
        ]);

        $enrollment->update(['payment_status' => $request->status]);

        return redirect()->back()->with('success', 'Enrollment payment status updated successfully.');
    }

    public function updateStatus(Request $request, Course $course)
    {
        $request->validate([
            'status' => 'required|in:pending,published,rejected',
        ]);

        $course->update(['status' => $request->status]);

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
        return response()->json($course->load('instructor'));
    }
}
