<?php
 
namespace App\Http\Controllers\Instructor;
 
use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('instructor.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'suggested_price' => 'required|numeric|min:0',
        ]);

        Course::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'suggested_price' => $request->suggested_price,
            'status' => 'draft',
        ]);

        return redirect()->route('instructor.courses.index')->with('success', 'Course created as draft.');
    }

    public function edit(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'suggested_price' => 'required|numeric|min:0',
        ]);

        $course->update($request->only(['title', 'description', 'suggested_price']));

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted.');
    }
}
