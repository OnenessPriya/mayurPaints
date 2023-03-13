<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complain;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class ComplaintController extends Controller
{
    /**
      * This method is for add product query
      * 
      *
      */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'user_id' => ['required', 'integer'],
          'name' => ['required', 'string', 'min:1'],
          'mobile' => ['nullable'],
          'whatsapp_no' => ['nullable'],
          'address' => ['nullable'],
          'message' => ['required'],
      ]);

      if (!$validator->fails()) {
          $data= new Complain;
          $data->user_id = $request->user_id;
          $data->name = $request->name ?? '';
          $data->mobile = $request->mobile ?? '';
          $data->whatsapp_no = $request->whatsapp_no ?? '';
          $data->address = $request->address ?? '';
          $data->message = $request->message ?? '';
          $data->created_at = date('Y-m-d g:i:s');
          $data->updated_at = date('Y-m-d g:i:s');
          $data->save();
          return response()->json(['error' => false, 'message' => 'Complaint Submitted Successfully','data'=>$data]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }
}
