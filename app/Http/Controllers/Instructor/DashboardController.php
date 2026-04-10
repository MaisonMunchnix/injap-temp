<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Course;
use App\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        $courseIds = $courses->pluck('id');
        
        $stats = [
            'total_courses' => $courses->count(),
            'published_courses' => $courses->where('status', 'published')->count(),
            'pending_courses' => $courses->where('status', 'pending')->count(),
            'total_students' => Enrollment::whereIn('course_id', $courseIds)->count(),
        ];

        return view('instructor.dashboard', compact('stats'));
    }
}
