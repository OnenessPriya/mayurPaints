<?php

namespace App\Http\Controllers\Retailer;

use App\Models\RetailerOrder;
use App\Models\RetailerUser;
use App\Models\RetailerWalletTxn;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class RetailerOrderController extends Controller
{
    /**
      * This method is to get 5 order details
      *
      */
    public function index(Request $request,$userId)
    {
        $order = RetailerOrder::where('user_id',$userId)->orderby('created_at','desc')->get();
        
        return response()->json(['error'=>false, 'resp'=>'Order history fetched successfully','data'=>$order]);
    }

    /**
      * This method is to get all order 
      *
      */
    public function view(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' =>['required'],
			'pageNo' => ['required'],
            
        ]);
        if (!$validator->fails()) {
          $resp = [];
          $pageNo =$request->pageNo;
          $userId =$request->user_id;
          $userExist=RetailerUser::where('id','=',$userId)->first();
            if(!$userExist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                if(!$pageNo){
                    $page=1;
                }else{
                    $page=$pageNo;
                    $limit=20;
                    $offset=($page-1)*$limit;
                    $resp= DB::select("SELECT * FROM retailer_user_txn_histories WHERE user_id = ".$userId." ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Transaction history fetch successfully',
                'data' => $resp,
            ]);

        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
        
    }

      /**
      * This method is to get reward 
      *
      */
      public function reward(Request $request)
      {
        //dd($userId);
        $validator = Validator::make($request->all(), [
            'user_id' =>['required'],
			'pageNo' => ['required'],
            
        ]);
        if (!$validator->fails()) {
          $resp = [];
          $pageNo =$request->pageNo;
          $userId =$request->user_id;
          $userExist=RetailerUser::where('id','=',$userId)->first();
            if(!$userExist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                if(!$pageNo){
                    $page=1;
                }else{
                    $page=$pageNo;
                    $limit=20;
                    $offset=($page-1)*$limit;
                   // $resp = RetailerWalletTxn::where('user_id',$userId)->orderby('id','desc')->offset($offset)->take($limit)->get();
                    $resp= DB::select("SELECT * FROM retailer_user_txn_histories WHERE user_id = ".$userId." ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Reward history with quanity',
                'data' => $resp,
            ]);

            } else {
                return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
            }
        
        }

        public function placeOrder(Request $request): JsonResponse
        {
          $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'shop_name' => ['required'],
            'email' => ['required', 'email'],
            'mobile' => ['required', 'integer','digits:10'],
            'shipping_country' => ['required', 'string'],
            'shipping_address' => ['required', 'string'],
            'shipping_landmark' => ['required', 'string'],
            'shipping_city' => ['required', 'string'],
            'shipping_state' => ['required', 'string'],
            'shipping_pin' => ['required', 'integer','digits:6'],
          ]);
  
          if (!$validator->fails()) {
                $userExist=RetailerUser::where('id',$request['user_id'])->first();
            if(!$userExist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                $userBalance=RetailerUser::where('id',$request['user_id'])->first();
                if ((int) $request['amount'] > (int) $userBalance->wallet ) {
                    return response()->json(['error'=>false, 'resp'=>'Wallet balance is low','data'=>$userBalance->wallet]);
                }else{
                    //$order_no = "ONN".date('y').'/'.mt_rand();
                    // 1 order sequence
                    $OrderChk = RetailerOrder::select('order_sequence_int')->latest('id')->first();
                    if($OrderChk->order_sequence_int == 0) $orderSeq = 1;
                    else $orderSeq = (int) $OrderChk->order_sequence_int + 1;

                    $ordNo = sprintf("%'.05d", $orderSeq);
                    $order_no = "ONNREWARD".date('y').'/'.$ordNo;
                    $newEntry = new RetailerOrder;
                    $newEntry->order_sequence_int = $orderSeq;
                    $newEntry->order_no = $order_no;
                    $newEntry->user_id = $request['user_id'];
                    $newEntry->product_id = $request['product_id'];
                    $newEntry->product_name = $request['product_name'];
                    $user=$newEntry->user_id;
                    $result = DB::select("select * from retailer_users where id='".$user."'");
                    $item=$result[0];
                    $name = $item->shop_name;
                    $newEntry->email = $item->email;;
                    $newEntry->mobile = $item->mobile;;
                    $newEntry->billing_country = $request['billing_country'] ?? null;
                    $newEntry->billing_address = $request['billing_address'] ?? null;
                    $newEntry->billing_landmark = $request['billing_landmark'] ?? null;
                    $newEntry->billing_city = $request['billing_city'] ?? null;
                    $newEntry->billing_state = $request['billing_state'] ?? null;
                    $newEntry->billing_pin = $request['billing_pin'] ?? null;

                    // shipping & billing address check
                    $shippingSameAsBilling = $request['shippingSameAsBilling'] ?? 0;
                    $newEntry->shippingSameAsBilling = $shippingSameAsBilling;
                    if ($shippingSameAsBilling == 0) {
                        $newEntry->shipping_country = $request['shipping_country'] ?? null;
                        $newEntry->shipping_address = $request['shipping_address'] ?? null;
                        $newEntry->shipping_landmark = $request['shipping_landmark'] ?? null;
                        $newEntry->shipping_city = $request['shipping_city'] ?? null;
                        $newEntry->shipping_state = $request['shipping_state'] ?? null;
                        $newEntry->shipping_pin = $request['shipping_pin'] ?? null;
                    } else {
                        $newEntry->shipping_country = $request['billing_country'] ?? null;
                        $newEntry->shipping_address = $request['billing_address'] ?? null;
                        $newEntry->shipping_landmark = $request['billing_landmark'] ?? null;
                        $newEntry->shipping_city = $request['billing_city'] ?? null;
                        $newEntry->shipping_state = $request['billing_state'] ?? null;
                        $newEntry->shipping_pin = $request['billing_pin'] ?? null;
                    }
                    $subtotal = $totalOrderQty = 0;
                    $newEntry->qty = $request['qty'];
                    $subtotal += $request['amount'] * $request['qty'];
                    $newEntry->amount =$request['amount'];
                    $newEntry->final_amount = $subtotal;
                    $newEntry->save();
                    $user=RetailerUser::findOrFail($userBalance->id);
                    $user->wallet -= $newEntry->amount;
                    $user->save();
                    $userAmount=RetailerWalletTxn::where('user_id',$request['user_id'])->orderby('id','desc')->first();
                    $walletTxn=new RetailerWalletTxn();
                    $walletTxn->user_id = $newEntry->user_id;
                    $walletTxn->barcode_id = '';
                    $walletTxn->barcode = '';
                    $walletTxn->amount = $newEntry->amount;
                    $walletTxn->type = 2 ?? '';
                    if(!$userAmount)
                        $walletTxn->final_amount -=  $newEntry->amount ?? '';
                    else
                        $walletTxn->final_amount =  $userAmount->final_amount - $newEntry->amount ?? '';
                    $walletTxn->created_at = date('Y-m-d H:i:s');
                    $walletTxn->updated_at = date('Y-m-d H:i:s');
                    $walletTxn->save();
                    $userwalletTxn=new RetailerUserTxnHistory();
                    $userwalletTxn->user_id = $userId;
                    $userwalletTxn->order_id = $newEntry->id;
                    $userwalletTxn->amount = $barcode->amount;
                    $userwalletTxn->type = 'points redeem' ?? '';
                    $userwalletTxn->title = 'Redeem points';
                    $userwalletTxn->description = 'You Purchase '.$request['product_name'];
                    $userwalletTxn->status = 'decrement';
                    $userwalletTxn->created_at = date('Y-m-d H:i:s');
                    $userwalletTxn->updated_at = date('Y-m-d H:i:s');
                    $userwalletTxn->save();
                
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Order placed successfully',
                'data' => $newEntry,
            ]);
            } else {
              return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
            }
  
        }

}
