<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\User;
use App\Models\WalletTxn;
use App\Models\UserTxnHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    /**
      * This method is to get 5 order details
      *
      */
    public function index(Request $request,$userId)
    {
        $order = Order::where('user_id',$userId)->orderby('created_at','desc')->get();
        
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
          $userExist=User::where('id','=',$userId)->first();
            if(!$userExist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                if(!$pageNo){
                    $page=1;
                }else{
                    $page=$pageNo;
                    $limit=20;
                    $offset=($page-1)*$limit;
                    $resp= DB::select("SELECT * FROM user_txn_histories WHERE user_id = ".$userId." ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");
                    $notificationCount=DB::table('user_txn_histories')->where('user_id','=',$userId)->count();
			        $count= (int) ceil($notificationCount / $limit);
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Transaction history fetch successfully',
                'data' => $resp,
                'count'=>$count,
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
          $userExist=User::where('id','=',$userId)->first();
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
                    $resp= DB::select("SELECT * FROM user_txn_histories WHERE user_id = ".$userId." and type= 'QRcode scan' ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");
                    $notificationCount=DB::table('user_txn_histories')->where('user_id','=',$userId)->where('type','=','QRcode scan')->count();
			        $count= (int) ceil($notificationCount / $limit);
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Reward history with quanity',
                'data' => $resp,
                'count'=>$count,
            ]);

            } else {
                return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
            }
        
        }

        public function placeOrder(Request $request): JsonResponse
        {
          $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'mobile' => ['required', 'integer','digits:10'],
            'shipping_country' => ['nullable', 'string'],
            'shipping_address' => ['nullable', 'string'],
            'shipping_landmark' => ['nullable', 'string'],
            'shipping_city' => ['nullable', 'string'],
            'shipping_state' => ['nullable', 'string'],
            'shipping_pin' => ['nullable', 'integer','digits:6'],
          ]);
  
          if (!$validator->fails()) {
                $userExist=User::where('id',$request['user_id'])->first();
            if(!$userExist){
                return response()->json(['error'=>false, 'resp'=>'User is invalid']);
            }else{
                $userBalance=User::where('id',$request['user_id'])->first();
                if ((int) $request['amount'] > (int) $userBalance->total_points ) {
                    return response()->json(['error'=>false, 'resp'=>'Wallet balance is low','data'=>$userBalance->total_points]);
                }else{
                    //$order_no = "ONN".date('y').'/'.mt_rand();
                    // 1 order sequence
                    $OrderChk = Order::select('order_sequence_int')->latest('id')->first();
                    if($OrderChk->order_sequence_int == 0) $orderSeq = 1;
                    else $orderSeq = (int) $OrderChk->order_sequence_int + 1;

                    $ordNo = sprintf("%'.05d", $orderSeq);
                    $order_no = "MayurPaints".date('y').'/'.$ordNo;
                    $newEntry = new Order;
                    $newEntry->order_sequence_int = $orderSeq;
                    $newEntry->order_no = $order_no;
                    $newEntry->user_id = $request['user_id'];
                    $newEntry->product_id = $request['product_id'];
                    $newEntry->product_name = $request['product_name'];
                    $user=$newEntry->user_id;
                    $result = DB::select("select * from users where id='".$user."'");
                    $item=$result[0];
                    $newEntry->email = $item->email;
                    $newEntry->mobile = $item->mobile;
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
                    $user=User::findOrFail($userBalance->id);
                    $user->total_points -= $newEntry->amount;
                    $user->save();
                    $userAmount=WalletTxn::where('user_id',$request['user_id'])->orderby('id','desc')->first();
                    $walletTxn=new WalletTxn();
                    $walletTxn->user_id = $newEntry->user_id;
                    $walletTxn->qrcode_id = '';
                    $walletTxn->qrcode = '';
                    $walletTxn->amount = $newEntry->amount;
                    $walletTxn->type = 2 ?? '';
                    if(!$userAmount)
                        $walletTxn->final_amount -=  $newEntry->amount ?? '';
                    else
                        $walletTxn->final_amount =  $userAmount->final_amount - $newEntry->amount ?? '';
                    $walletTxn->created_at = date('Y-m-d H:i:s');
                    $walletTxn->updated_at = date('Y-m-d H:i:s');
                    $walletTxn->save();
                    $userwalletTxn=new UserTxnHistory();
                    $userwalletTxn->user_id = $request['user_id'];
                    $userwalletTxn->order_id = $newEntry->id;
                    $userwalletTxn->amount = $newEntry->amount;
                    $userwalletTxn->type = 'points redeem' ?? '';
                    $userwalletTxn->title = 'Redeem points';
                    $userwalletTxn->desc = 'You Purchase '.$request['product_name'];
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
