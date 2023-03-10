<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request){
		$validator = Validator::make($request->all(), [
			'user_id' => ['required'],
			'pageNo' => ['nullable'],
		]);
		
		if (!$validator->fails()) {
			$user_id = $request->user_id;
          	$pageNo =$request->pageNo;
            $notificationCount=DB::table('notifications')->where('receiver','=',$user_id)->count();
			if(!$pageNo){
               $page=1;
             }else{
              $page=$pageNo;
			  }
              $limit=20;
              $offset=($page-1)*$limit;
              $count= (int) ceil($notificationCount / $limit);
			  $notifications = DB::select("select * from notifications where receiver='$user_id' ORDER BY id desc LIMIT ".$limit." OFFSET ".$offset."");
			return response()->json(['error' => false, 'message' => 'User wise notification list', 'data' => $notifications,'count'=>$count]);
            
			
		}else{
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
		}
	}
	
	
	public function readNotification(Request $request){
        $validator = Validator::make($request->all(), [
			'id' => ['required'],
		]);
		
		if (!$validator->fails()) {
            $id = $request->id;
            $Exist=Notification::where('id','=',$id)->first();
            if(!$Exist){
                return response()->json(['error'=>false, 'resp'=>'id is invalid']);
            }else{
                $read_time = date("Y-m-d G:i:s");
            
                DB::select("update notifications set read_flag=1, read_at='$read_time' where id='$id'");
		
		        return response()->json(['error' => false, 'message' => 'Notification date updated successfully']);
            }
        }else{
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
		}
    }
	
}
