<?php

namespace App\Http\Controllers\Retailer;

use App\Models\RetailerBarcode;
use App\Models\RetailerUser;
use App\Models\RetailerWalletTxn;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BarcodeController extends Controller
{
    /**
      * This method is to get barcode details
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
            $barcode=RetailerBarcode::where('code',$code)->first();
            //barcode exist check
            if(!$barcode){
                return response()->json(['error'=>false, 'resp'=>'Barcode is invalid']);
            }else{
                // coupon code validity check
                if ($barcode->end_date < \Carbon\Carbon::now() || $barcode->status == 0) {
                    return response()->json(['error'=>true, 'resp'=>'Barcode is expired']);
                }else{
                    //no of usage check
                    if ($barcode->no_of_usage == $barcode->max_time_of_use || $barcode->no_of_usage >= $barcode->max_time_of_use) {
                        return response()->json(['error'=>true, 'resp'=>'Usage limit expired']);
                    }else{
                        $userExist=RetailerUser::where('id',$userId)->first();
                        if(!$userExist){
                            return response()->json(['error'=>false, 'resp'=>'User is invalid']);
                        }else{
                            $user=RetailerUser::findOrFail($userId);
                            $user->wallet += $barcode->amount;
                            $user->save();
                            $userAmount=RetailerWalletTxn::where('user_id',$userId)->orderby('id','desc')->first();
                            $walletTxn=new RetailerWalletTxn();
                            $walletTxn->user_id = $userId;
                            $walletTxn->barcode_id = $barcode->id;
                            $walletTxn->barcode = $barcode->code;
                            $walletTxn->amount = $barcode->amount;
                            $walletTxn->type = 1 ?? '';
                            if(!$userAmount)
                                $walletTxn->final_amount += $barcode->amount ?? '';
                            else
                                $walletTxn->final_amount = $userAmount->final_amount+ $barcode->amount ?? '';
                            $walletTxn->created_at = date('Y-m-d H:i:s');
                            $walletTxn->updated_at = date('Y-m-d H:i:s');
                            $walletTxn->save();
                            $userwalletTxn=new RetailerUserTxnHistory();
                            $userwalletTxn->user_id = $userId;
                            $userwalletTxn->barcode_id = $barcode->id;
                            $userwalletTxn->barcode = $barcode->code;
                            $userwalletTxn->amount = $barcode->amount;
                            $userwalletTxn->type = 'barcode scan' ?? '';
                            $userwalletTxn->title = $barcode->amount.' points earn';
                            $userwalletTxn->description = 'Using '.$barcode->code.' code';
                            $userwalletTxn->status = 'increment';
                            $userwalletTxn->created_at = date('Y-m-d H:i:s');
                            $userwalletTxn->updated_at = date('Y-m-d H:i:s');
                            $userwalletTxn->save();
                            $barcodeDetails=RetailerBarcode::findOrFail($barcode->id);
                            $barcodeDetails->no_of_usage = $barcode->no_of_usage+1;
                            $barcodeDetails->save();
                        }
                    }

                }
                return response()->json(['error'=>false, 'resp'=>'Barcode data fetched successfully','data'=>$barcode]);
            }
        }
        else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
   
    }
}
