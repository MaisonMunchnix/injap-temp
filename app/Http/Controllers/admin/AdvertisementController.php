<?php

namespace App\Http\Controllers\admin;

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
    public function index() {
       return view('admin.ads.index');
    }

    public function getAdvetisements(Request $request){
        if ($request->ajax()) {
           
            
            $advertisements = DB::table('advertisements')
                ->select('users.username','advertisements.*')
                ->join('users','advertisements.user_id','users.id')
                ->where('advertisements.status','!=',2)
                ->get();
            return Datatables::of($advertisements)
                ->editColumn('status', function($advertisements){
                    if($advertisements->status == 1){
                        $status_label = "<span class='text-success'>Active</span>";
                    } else if($advertisements->status == 0){
                        $status_label = "<span class='text-warning'>Pending</span>";
                    }
                    return $status_label;
                })
                ->addColumn('action', function($advertisements){
                    $user_id = Auth::id();
                    $actions = '';
                    if($advertisements->status == 0){
                        $actions = "<a href='#' class='dropdown-item btn-swal text-primary' data-id='$advertisements->id' data-action='accept'>Accept</a>
                        <a href='#' class='dropdown-item btn-swal text-danger' data-id='$advertisements->id' data-action='reject'>Reject</a>";
                    }

                    if($advertisements->user_id == $user_id){
                        $actions .= "<a href='#' class='dropdown-item btn-edit text-primary' data-id='$advertisements->id'>Edit</a>";
                    }
                    return "<div class='dropdown'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Action </button>
                        <div class='dropdown-menu'>
                            <a href='#' class='dropdown-item btn-view' data-id='$advertisements->id'>View</a>
                            $actions
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
    public function create()
    {
        //
    }

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

        $ads->status = 1;
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
    

    public function action(Request $request)
    {
        $ad = Advertisement::find($request->id);
        $status = $request->action;
        if($status == 'accept'){
            $stat = 1;
        } else {
            $stat = 2;
        }
        $ad->status = $stat;
        $ad->update();
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
