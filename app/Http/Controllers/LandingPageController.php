<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Advertisement;
use App\Currency;
use App\Course;
use App\Enrollment;
use App\PopupAnnouncement;

class LandingPageController extends Controller
{
    public function home()
    {
        $currencies = DB::table('currencies')->select('id', 'sell', 'buy')->get();
        $yen = $currencies->where('id', 1)->first();
        $hkd = $currencies->where('id', 2)->first();
        $usd = $currencies->where('id', 3)->first();

        $popup = PopupAnnouncement::where('is_active', true)->latest()->first();

        return view('landing.home', compact('yen', 'hkd', 'usd', 'popup'));
    }

    public function legalAssistance()
    {
        return view('landing.legal_assistance');
    }

    public function translationService()
    {
        return view('landing.translation_service');
    }

    public function financialAssistance()
    {
        return view('landing.financial_assistance');
    }

    public function benefit()
    {
        return view('landing.benefit');
    }

    public function recruitment()
    {
        return view('landing.recruitment');
    }

    public function socialObligation()
    {
        return view('landing.social_obligation');
    }

    public function application()
    {
        // Get all active packages for member type selection
        $packages = DB::table('packages')
            ->where('status', 1)
            ->select('id', 'type', 'amount')
            ->get();

        return view('landing.application', compact('packages'));
    }

    public function about()
    {
        $galleries = \App\AboutGallery::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('landing.about', compact('galleries'));
    }

    public function announcements()
    {
        return view('landing.announcements');
    }

    public function announcement($slug)
    {
        return view('landing.announcement');
    }

    public function products()
    {
        return view('landing.product');
    }

    public function advertisements()
    {

        $ads = DB::table('advertisements')
            ->select('users.username', 'advertisements.title', 'advertisements.slug', 'advertisements.content', 'advertisements.image')
            ->join('users', 'advertisements.user_id', 'users.id')
            ->where('advertisements.status', 1)
            ->paginate(6);

        return view('landing.advertisements', compact('ads'));
    }

    public function advertisement($slug)
    {
        $advertisement = Advertisement::where('slug', $slug)
            ->where('status', 1)
            ->with('user')
            ->firstOrFail();

        return view('landing.advertisement', compact('advertisement'));
    }


    public function getPackage($package)
    {
        if (!in_array($package, ['silver', 'wgc-membership', 'gold', 'diamond'])) {
            abort(404);
        }
        return view('landing.' . $package);
    }



    public function contact()
    {
        return view('landing.contact');
    }

    public function getCurrencies()
    {
        $currencies = DB::table('currencies')
            ->select('name', 'buy', 'sell')
            ->get();

        return response()->json($currencies, 200);
    }


    public function education()
    {
        $courses = Course::where('status', 'published')->with('instructor')->get();
        return view('landing.education', compact('courses'));
    }

    public function courseDetails(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }
        return view('landing.course_details', compact('course'));
    }

    public function enroll(\Illuminate\Http\Request $request, Course $course)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'age' => 'required|integer|min:1',
        ]);

        // Age Validation
        if ($course->min_age && $request->age < $course->min_age) {
            return back()->withInput()->withErrors(['age' => "Minimum age for this course is {$course->min_age}."]);
        }
        if ($course->max_age && $request->age > $course->max_age) {
            return back()->withInput()->withErrors(['age' => "Maximum age for this course is {$course->max_age}."]);
        }

        // Guardian Validation if under 18
        if ($request->age < 18) {
            $request->validate([
                'guardian_name' => 'required|string|max:255',
                'guardian_contact' => 'required|string|max:255',
            ]);
        }

        Enrollment::create([
            'course_id' => $course->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'guardian_name' => $request->guardian_name,
            'guardian_contact' => $request->guardian_contact,
            'payment_status' => 'pending',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'You have successfully enrolled! Please wait for further instructions for payment and your instructor to contact you.');
    }
}
