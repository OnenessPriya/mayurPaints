<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Channel;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $users=User::where('type',2)->orderby('id','desc')->get();
        return view('admin.chat.index',compact('users'));
    }
    /**
     * Fetch all messages related to specific contact
     *
     * @return Message
     */
        public function fetchMessages($id)
        {
            /*
            $messages = Channel::
            where(function ($query) use($id) {
                $query->where('sender_id', 0)
                        ->where('receiver_id', $id);
            })
            ->orWhere(function ($query) use($id) {
                $query->where('sender_id', $id)
                        ->where('receiver_id', 0);
            })
            ->latest()
            ->first();

            if(!$messages){
                return response()->json(['error'=>false, 'resp'=>'Chat not started']);
            }else{
                $chat= DB::select("select * from chats where channel_id	='$messages->id' ORDER BY id desc");
                if(!$chat){
                    return response()->json(['error' => true, 'message' => 'No chat found']);
                    
                }else{   
                    return response()->json(['error'=>false, 'resp'=>'Message fetch successfully','data'=>$chat]);
                }
            }
            */

            $channel = Channel::where('sender_id', $id)->orWhere('receiver_id', $id)->first();

            if (!empty($channel)) {
                $chatMessages = Chat::where('channel_id', $channel->id)->get();

                return response()->json([
                    'status' => 200,
                    'message' => 'Messages found',
                    'data' => $chatMessages
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'No messages found',
                ]);
            }
        }



    //store mesage
    public function store(Request $request)
    {
        dd($request->all());
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
                $channel->sender_id = 0;
                $channel->receiver_id = $request->sender_id;
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
    //store mesage
    public function storeAjax(Request $request)
    {
        dd($request->all());
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
                $channel->sender_id = 0;
                $channel->receiver_id = $request->sender_id;
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

}
