<?php

namespace App\Http\Controllers;

use App\User;
use App\Announcement;
use App\AnnouncementAttachment;
use App\UserInfo;
use App\ProductCode;
use App\Referral;
use App\Network;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Filesystem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



class AnnouncementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function viewAnnouncement($type){
        $auth_id =Auth::id();
        $user_data = DB::table('users')
			->join('user_infos', 'user_infos.user_id', '=', 'users.id')
            ->join('networks', 'networks.user_id', '=', 'users.id')
            ->join('packages', 'networks.package', '=', 'packages.id')
			->select('users.id AS user_id','users.created_at AS user_created_at','users.*','user_infos.*','networks.*','packages.type AS package_type')
			->where('users.id',$auth_id)
            ->first();
       
            
            return view('user.announcement.index',compact('auth_id','user_data'));
    }

    public function index(){
        $announcement = Announcement::get();
        return view('admin.announcement.index',compact('announcement'));
    }
	
	public function insertAnnouncement(Request $request){
        $validator = Validator::make($request->all(), [
            'add_title' => 'required',
            'add_subject' => 'required',
            'add_message' => 'required',
            'priority' => 'required'
        ]);
        $announcement_count=Announcement::where('title',$request['add_title'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fieldsss',
            ],400);
        }else if($announcement_count>=1){
            return response()->json([
                'message' => 'Announcement name already exists.',
            ],400);
        }else{
            DB::beginTransaction();
            try {
                $announcement = new Announcement();
                $announcement->title = $request['add_title'];
                $announcement->subject = $request['add_subject'];
                $announcement->content = $request['add_message'];
                $announcement->date_end = $request['date_end'];
                $announcement->priority = $request['priority'];
                $announcement->created_by = Auth::id();
                if($announcement->save()){
					if($request->hasfile('attachment')){
						foreach($request->file('attachment') as $file){
							$name=$file->getClientOriginalName();
							$file->move(public_path('assets/img/announcement/' . $announcement->id.'/'), $name);
							$attachment= new AnnouncementAttachment();
							$attachment->announcement_id = $announcement->id;
							$attachment->name = $name;
							$attachment->source = "assets/img/announcement/$announcement->id/" . $name; 
							$attachment->save();
						}
					}
				}
				
				//$request['add_attachment'];
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
        
    }
	
	public function editAnnouncement($id){
        $announcement_data=Announcement::where('id',$id)->first();
		return response()->json($announcement_data);
        /*return response()->json([
            'announcement_data' => $announcement_data,
        ]);*/
    }
	
	public function updateAnnouncement(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'date_end' => 'required',
            'priority' => 'required'
        ]);
        $announcement_count=Announcement::where('title',$request['edit_title'])->where('id','!=',$request['id'])->count();
         
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields (SERVER)',
            ],400);
        }else if($announcement_count>=1){
            return response()->json([
                'message' => 'Announcement name already exists.',
            ],400);
        }else{
            DB::beginTransaction();
            try {
				$announcement=Announcement::find($request['id']);
				$announcement->title = $request['title'];
                $announcement->subject = $request['subject'];
                $announcement->content = $request['message'];
                $announcement->date_end = $request['date_end'];
                $announcement->priority = $request['priority'];

                if($announcement->save()){
					if($request->hasfile('edit_attachment')){
						
						foreach($request->file('edit_attachment') as $file){
							$name=$file->getClientOriginalName();
							$file->move(public_path('assets/img/announcement/' . $announcement->id .'/'), $name);
							$attachment= new AnnouncementAttachment();
							$attachment->announcement_id = $announcement->id;
							$attachment->name = $name;
							$attachment->source = "assets/img/announcement/" . $announcement->id  . '/' . $name; 
							if($attachment->save()){
								$announcement_files=AnnouncementAttachment::where('announcement_id',$announcement->id)->where('created_at','<',Carbon::now())->get();
								foreach($announcement_files as $announcement_file){
									$source = public_path()."/assets/img/announcement/" . $announcement->id . '/' . $announcement_file->name;
									File::delete($source);
									//unlink($source);
								}									  
								$deletedRows = AnnouncementAttachment::where('announcement_id', $announcement->id)->where('created_at','<',Carbon::now())->delete();
							}
						}
					}
				}
				
				//$request['add_attachment'];
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
        
    }
    
    public function deleteAnnouncement(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        $id = $request['id'];
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check empty input fields (SERVER)',
            ],400);
        }else{
            DB::beginTransaction();
            try {
				$announcement=Announcement::find($id);

                if($announcement->delete()){
					$announcement_files=AnnouncementAttachment::where('announcement_id',$id)->get();
                    foreach($announcement_files as $announcement_file){
                        $source = public_path()."/assets/img/announcement/" . $id . '/' . $announcement_file->name;
                        $source_directory = public_path()."/assets/img/announcement/" . $id;
                        File::delete($source);
                        Storage::deleteDirectory($source_directory);
                        //unlink($source);
                    }									  
                    $deletedRows = AnnouncementAttachment::where('announcement_id', $id)->delete();
				}
				
				//$request['add_attachment'];
                DB::commit();
				return response()->json([
					'message' => 'ok',
				],200);

            }catch(\Throwable $e){
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ],400);
            }
        }
        
    }



   
}
