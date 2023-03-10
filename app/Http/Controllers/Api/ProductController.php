<?php

namespace App\Http\Controllers\Api;
use App\Models\Enquery;
use App\Models\Product;
use App\User;
use App\Models\UserTxnHistory;
use App\Models\RewardProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
      * This method is to get reward product details
      *
      */
    public function rewardproductList(Request $request): JsonResponse
    {
 
         $products = RewardProduct::where('status',1)->orderby('id','desc')->get();
 
         return response()->json(['error'=>false, 'resp'=>'Product data fetched successfully','data'=>$products]);
 
    }

    /**
      * This method is to get top 5 reward product
      *
      */
    public function rewardproductView(Request $request,$id)
    {
  
          $products = RewardProduct::where('status',1)->orderby('id','desc')->take(5)->get();
          $data = User::where('id',$id)->first();
          //$txnHistory= DB::select("SELECT * FROM user_txn_histories WHERE user_id = ".$id."  ORDER BY id DESC LIMIT 5");
          $txnHistory=UserTxnHistory::where('user_id','=',$id)->orderby('id','desc')->take(5)->get();
          return response()->json(['error'=>false, 'resp'=>'Data fetched successfully','rewardproduct'=>$products,'userPoints'=>$data->total_points,'history'=>$txnHistory]);
  
    }
    /**
      * This method is for show product details
      * @param  $id
      *
      */
    public function show(Request $request,$id)
    {
         $products = Product::where('id',$id)->first();
         return response()->json(['error'=>false, 'resp'=>'Product data fetched successfully','data'=>$products]);
    }
     /**
      * This method is for add product query
      * 
      *
      */
      public function storeQuery(Request $request)
      {
        $validator = Validator::make($request->all(), [
          'user_id' => ['required', 'integer'],
          'name' => ['required', 'string', 'min:1'],
          'mobile' => ['required'],
          'whatsapp_no' => ['required'],
          'address' => ['required'],
          'message' => ['required'],
      ]);

      if (!$validator->fails()) {
          $data= new Enquery;
          $data->user_id = $request->user_id;
          $data->product_id = $request->product_id;
          $data->name = $request->name ?? '';
          $data->mobile = $request->mobile ?? '';
          $data->whatsapp_no = $request->whatsapp_no ?? '';
          $data->address = $request->address ?? '';
          $data->message = $request->message ?? '';
          $data->created_at = date('Y-m-d g:i:s');
          $data->updated_at = date('Y-m-d g:i:s');
          $data->save();
          return response()->json(['error' => false, 'message' => 'Query Submitted Successfully','data'=>$data]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
      }

     /**
      * This method is for show reward product details
      * @param  $id
      *
      */
      public function rewardproductShow(Request $request,$id)
      {
          $products = RewardProduct::where('id',$id)->first();
          return response()->json(['error'=>false, 'resp'=>'Product data fetched successfully','data'=>$products]);
      }
 
     
}
