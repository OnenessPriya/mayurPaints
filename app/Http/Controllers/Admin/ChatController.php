<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
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

            $messages = Channel::
            where(function ($query) use($id) {
                $query->where('sender_id', Auth::user()->id)
                        ->where('receiver_id', $id);
            })
            ->orWhere(function ($query) use($id) {
                $query->where('sender_id', $id)
                        ->where('receiver_id', Auth::user()->id);
            })
            ->latest()
            ->paginate(20);
            return Response::json($messages);
        
        }
    //store mesage
    public function store(Request $request)
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

}
