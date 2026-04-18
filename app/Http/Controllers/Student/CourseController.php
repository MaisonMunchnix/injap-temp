<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Course;
use App\Enrollment;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        // Security check: ensure student is enrolled and paid
        $enrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->where('payment_status', 'paid')
            ->exists();

        if (!$enrolled) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course->load(['instructor', 'materials' => function ($query) {
            $query->where('status', 'approved')->latest();
        }]);

        $announcements = $course->materials->where('type', 'announcement')->sortByDesc('created_at');
        $filesAndLinks = $course->materials->whereIn('type', ['file', 'link'])->sortByDesc('created_at');

        return view('student.courses.show', compact('course', 'announcements', 'filesAndLinks'));
    }

    public function downloadMaterial(\App\CourseMaterial $material)
    {
        // Security check
        $enrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $material->course_id)
            ->where('payment_status', 'paid')
            ->exists();

        if (!$enrolled || $material->status !== 'approved' || $material->type !== 'file' || empty($material->file_path)) {
            abort(403, 'Unauthorized access or invalid file.');
        }

        $path = storage_path('app/public/' . $material->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'File not found on server.');
        }

        return response()->download($path, $material->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
