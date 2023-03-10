<?php

namespace App\Http\Controllers\Api;

use App\Models\QRCode;
use App\User;
use App\Models\WalletTxn;
use App\Models\UserTxnHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class QRcodeController extends Controller
{
    /**
      * This method is to get qrcode details
      *
      */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required'],
            'user_id' =>['required'],
        ]);

        if (!$validator->fails()) {
            $code = $request->code;
            $userId =$request->user_id;
            $qrCode=QRCode::where('code',$code)->first();
            //qrCode exist check
            if(!$qrCode){
                return response()->json(['error'=>true, 'resp'=>'QRcode is invalid']);
            }else{
                // qrCode validity check
                if ($qrCode->end_date < \Carbon\Carbon::now() || $qrCode->status == 0) {
                    return response()->json(['error'=>true, 'resp'=>'QRcode is expired']);
                }else{
                    //no of usage check
                    if ($qrCode->no_of_usage == $qrCode->max_time_of_use || $qrCode->no_of_usage >= $qrCode->max_time_of_use) {
                        return response()->json(['error'=>true, 'resp'=>'Usage limit expired']);
                    }else{
                        $userExist=User::where('id',$userId)->first();
                        if(!$userExist){
                            return response()->json(['error'=>false, 'resp'=>'User is invalid']);
                        }else{
                            $user=User::findOrFail($userId);
                            $user->total_points += $qrCode->points;
                            $user->save();
                            $userAmount=WalletTxn::where('user_id',$userId)->orderby('id','desc')->first();
                            $walletTxn=new WalletTxn();
                            $walletTxn->user_id = $userId;
                            $walletTxn->qrcode_id = $qrCode->id;
                            $walletTxn->qrcode = $qrCode->code;
                            $walletTxn->amount = $qrCode->points;
                            $walletTxn->type = 1 ?? '';
                            if(!$userAmount)
                                $walletTxn->final_amount += $qrCode->points ?? '';
                            else
                                $walletTxn->final_amount = $userAmount->final_amount+ $qrCode->amount ?? '';
                            $walletTxn->created_at = date('Y-m-d H:i:s');
                            $walletTxn->updated_at = date('Y-m-d H:i:s');
                            $walletTxn->save();
                            $userwalletTxn=new UserTxnHistory();
                            $userwalletTxn->user_id = $userId;
                            $userwalletTxn->qrcode_id = $qrCode->id;
                            $userwalletTxn->qrcode = $qrCode->code;
                            $userwalletTxn->amount = $qrCode->points;
                            $userwalletTxn->type = 'QRcode scan' ?? '';
                            $userwalletTxn->title = $qrCode->points.' points earn';
                            $userwalletTxn->desc = 'Using '.$qrCode->code.' code';
                            $userwalletTxn->status = 'increment';
                            $userwalletTxn->created_at = date('Y-m-d H:i:s');
                            $userwalletTxn->updated_at = date('Y-m-d H:i:s');
                            $userwalletTxn->save();
                            $qrcodeDetails=QRCode::findOrFail($qrCode->id);
                            $qrcodeDetails->no_of_usage = $qrCode->no_of_usage+1;
                            $qrcodeDetails->save();
                        }
                    }

                }
                return response()->json(['error'=>false, 'resp'=>'QRCode data fetched successfully','data'=>$qrCode]);
            }
        }
        else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
   
    }
}
