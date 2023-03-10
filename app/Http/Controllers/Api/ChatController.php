<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Chat;
use App\Models\Channel;
class ChatController extends Controller
{
    //chat initiate list
    public function index(Request $request){
        $validator = Validator::make($request->all(), [
			'user_id' => ['required'],
		]);
		
		if (!$validator->fails()) {
            $id = $request->user_id;
            $Exist=User::where('id','=',$id)->first();
            if(!$Exist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
            
                $list= DB::select("select * from channels where sender_id='$id' or receiver_id='$id'");
                if(!$list){
                    return response()->json(['error' => true, 'message' => 'Chat not started yet']);
                }else{   
		       
                    return response()->json(['error'=>false, 'resp'=>'Chat initiate list','data'=>$list]);
                }
            }
        }else{
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
		}
    }
    //message list
    public function showChat(Request $request){
        $validator = Validator::make($request->all(), [
			'channel_id' => ['required'],
		]);
		
		if (!$validator->fails()) {
            $id = $request->channel_id	;
            $Exist=Channel::where('id','=',$id)->first();
            if(!$Exist){
                return response()->json(['error'=>false, 'resp'=>'Chat not started']);
            }else{
                $chat= DB::select("select * from chats where channel_id	='$id' ORDER BY id desc");
                if(!$chat){
                    return response()->json(['error' => true, 'message' => 'No chat found']);
                    
                }else{   
                    return response()->json(['error'=>false, 'resp'=>'Message fetch successfully','data'=>$chat]);
                }
            }
        }else{
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
		}
    }
    //chat initiate
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => ['required'],
        ]);

        if (!$validator->fails()) {
            $id = $request->sender_id;
            $Exist=User::where('id','=',$id)->first();
            if(!$Exist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                $channelExist=DB::select("select * from channels where sender_id='$id' or receiver_id='$id'");
                if($channelExist){
                    return response()->json(['error'=>false, 'resp'=>'Chat already started','data'=>$channelExist]);
                }else{
                    $channel= new Channel;
                    $channel->sender_id = $request->sender_id;
                    $channel->receiver_id = 0;
                    $channel->created_at = now();
                    $channel->updated_at = now();
                    $channel->save();
                return response()->json(['error' => false, 'message' => 'Chat initiated','data'=>$channel]);
                }
            }
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }
    //document upload
	public function createDocument(Request $request) {
		$validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if (!$validator->fails()) {
				$imageName = mt_rand().'.'.$request->message->extension();
				$uploadPath = 'public/uploads/chat/document';
				$request->message->move($uploadPath, $imageName);
				$total_path = $uploadPath.'/'.$imageName;
			    $resp =  $total_path;
			return response()->json(['error' => false, 'message' => 'Document added', 'data' => $resp]);
		} else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
		
	}
    //store mesage
     public function chatStore(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'channel_id' => ['required'],
         ]);
 
         if (!$validator->fails()) {
             $id = $request->channel_id;
             $Exist=Channel::where('id','=',$id)->first();
             if(!$Exist){
                 return response()->json(['error'=>false, 'resp'=>'Chat not started']);
             }else{
                 $channel= new Chat();
                 $channel->channel_id = $id;
                 $channel->sender_id = $request->sender_id;
                 $channel->receiver_id = 0;
                 $channel->message = $request->message;
                 $channel->flag = $request->flag;
                 $channel->created_at = now();
                 $channel->updated_at = now();
                 $channel->save();
                 return response()->json(['error' => false, 'message' => 'Chat initiated','chat'=>$channel]);
             }
         } else {
             return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
         }
    }
    //read unread check
    public function readChat(Request $request){
        $validator = Validator::make($request->all(), [
			'chat_id' => ['required'],
		]);
		
		if (!$validator->fails()) {
            $id = $request->chat_id;
            $Exist=Chat::where('id','=',$id)->first();
            if(!$Exist){
                return response()->json(['error'=>false, 'resp'=>'chat id is invalid']);
            }else{
                $read_time = date("Y-m-d G:i:s");
            
                DB::select("update chats set read_flag=1, read_at='$read_time' where id='$id'");
		
		        return response()->json(['error' => false, 'message' => 'Chat data updated successfully']);
            }
        }else{
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
		}
    }
	

}
