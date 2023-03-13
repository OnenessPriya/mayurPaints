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

    public function fetchMessages($id)
    {
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
        // dd($request->all());

        $receiver_id = $request->userId;
        $channel_id = $request->channel_id;
        $message = $request->message;

        if ($channel_id == "new") {
            $channel = new Channel();
            $channel->sender_id = 0;
            $channel->receiver_id = $receiver_id;
            $channel->save();

            $channel_id = $channel->id;
        }

        $chat = new Chat();
        $chat->channel_id = $channel_id;
        $chat->message = $message;
        $chat->file_extension = '';
        $chat->flag = 'text';
        $chat->sender_id = 0;
        $chat->receiver_id = $receiver_id;
        $chat->read_flag = 0;
        $chat->save();

        /*
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
        */
    }

    public function storeFileAjax(Request $request, $channel_id, $receiver_id)
    {
        // dd($channel_id, $request->all());

        // $receiver_id = $request->userId;
        // $channel_id = $request->channel_id;
        // $message = $request->message;

        if ($channel_id == "new") {
            $channel = new Channel();
            $channel->sender_id = 0;
            $channel->receiver_id = $receiver_id;
            $channel->save();

            $channel_id = $channel->id;
        }


        $upload_path = "public/uploads/chat/document/";
        $file = $request->file;
        $fileName = time().".".mt_rand().".".$file->getClientOriginalExtension();
        $file->move($upload_path, $fileName);
        // $uploadedImage = $fileName;
        $message = $upload_path.$fileName;


        $chat = new Chat();
        $chat->channel_id = $channel_id;
        $chat->message = $message;
        $chat->file_extension = '.'.$file->getClientOriginalExtension();
        $chat->flag = 'document';
        $chat->sender_id = 0;
        $chat->receiver_id = $receiver_id;
        $chat->read_flag = 0;
        $chat->save();
    }

}
