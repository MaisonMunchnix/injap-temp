<?php

namespace App\Http\Controllers\member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Advertisement;
use DataTables;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $auth_id = Auth::id();
        $get_donations = DB::table('donations')->where('user_id',$auth_id)->get();
        $total_donations = DB::table('donations')->where('user_id',$auth_id)->where('status',1)->sum('amount');
       return view('user.advertisements.index', compact('auth_id','get_donations','total_donations'));
    }

    public function getAdvetisements(Request $request){
        if ($request->ajax()) {
            $user_id = Auth::id();
            
            $advertisements = DB::table('advertisements')
                ->where('user_id',$user_id)
                ->get();

            return Datatables::of($advertisements)
                ->editColumn('status', function($advertisements){
                    if($advertisements->status == 1){
                        $status_label = "<span class='text-success'>Active</span>";
                    } else {
                        $status_label = "<span class='text-warning'>Pending</span>";
                    }
                    return $status_label;
                })
                ->addColumn('action', function($advertisements){
                    return "<div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
                        <div class='dropdown-menu'>
                            <a href='#' class='dropdown-item btn-view' data-id='$advertisements->id'>View</a>
                            <a href='#' class='dropdown-item btn-edit' data-id='$advertisements->id'>Edit</a>
                            <a href='#' class='dropdown-item btn-delete' data-id='$advertisements->id'>Delete</a>
                        </div>
                    </div>";
                })
                ->rawColumns(['status','action'])
                ->make(true);
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'title' => 'required|unique:advertisements',
            'image' => 'image',
            'content' => 'required',
        ]);

        $ads = new Advertisement();
        $ads->user_id = $user_id;

        if ($request->hasFile('image')) {
            $ads->image = $this->uploadImage($request->file('image'), $user_id);
        }

        $ads->title = $request->title;
        $ads->content = $request->content;
        $ads->save();
    }

    private function uploadImage($file, $user_id)
    {
        $name = $file->getClientOriginalName();
        $path = 'assets/img/ads/' . $user_id . '/';
        
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $file->move($path, $name);
        return $path . $name;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ads = Advertisement::find($id);
        return response()->json($ads);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:advertisements,title,' . $request->id,
            'image' => 'image',
            'content' => 'required',
        ]);
    
        $ads = Advertisement::find($request->id);
    
        if (!$ads) {
            return response()->json([
                'error' => 'Advertisement not found',
            ], 404);
        }
    
        $ads->title = $request->title;

        if ($request->hasFile('image')) {
            $ads->image = $this->uploadImage($request->file('image'), $ads->user_id);
        }
    
        $ads->content = $request->content;
        $ads->save();
    
        return response()->json([
            'status' => 'Updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ads = Advertisement::findOrFail($request->id);
        $ads->delete();
        return response()->json([
            'status' => 'Deleted'
        ],200);
    }
}
