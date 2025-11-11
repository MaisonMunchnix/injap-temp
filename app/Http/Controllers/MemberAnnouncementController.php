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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;



class MemberAnnouncementController extends Controller
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
        $date_now = date('Y-m-d');
        $announcements=Announcement::where('date_end', '>=', date('Y-m-d'))->orderBy('created_at','DESC')->get();
        $announcement_count=Announcement::where('date_end', '>=', date('Y-m-d'))->orderBy('created_at','DESC')->count();
        $get_announcement = DB::table('announcements')
						->join('announcement_attachments', 'announcement_attachments.announcement_id', '=', 'announcements.id')
						->select('announcement_attachments.id','announcement_attachments.announcement_id','announcement_attachments.name','announcement_attachments.source')
						->where('announcements.date_end', '>=', date('Y-m-d'))
						->get();
        return view('user.announcement.index',compact('auth_id','announcements','announcement_count','get_announcement'));
    }

    public function loadMoreAnnouncement($offset){
        $auth_id =Auth::id();
        $limit=10;
        $announcements=Announcement::orderBy('created_at','DESC')->offset($offset)->limit($limit)->get();
        $announcement_count=Announcement::count();
        return response()->json([
            'announcements' => $announcements,
            'announcement_count' => $announcement_count
        ]);
    }

    public function getAnnouncementData($id){
        $announcements=Announcement::where('id',$id)->first();
        $created;
        if(!empty($announcements)){
            $created=UserInfo::select('first_name','last_name')->where('user_id',$announcements->created_by)->first();
        }
        $attachments=AnnouncementAttachment::where('announcement_id',$id)->get();
        return response()->json([
            'announcements' => $announcements,
            'attachments' => $attachments,
            'created' => $created
        ]);
    }

    

     



   
}
