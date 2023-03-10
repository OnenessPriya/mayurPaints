<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\UserTxnHistory;
use App\Models\WalletTxn;
use App\User;
use App\Models\RewardProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
   
    public function index(Request $request)
    {
        if (isset($request->date_from) || isset($request->date_to) ||isset($request->product) ||isset($request->term) || isset($request->user_id) ) {
            $from = $request->date_from ? $request->date_from : date('Y-m-01');
            $to = date('Y-m-d', strtotime(request()->input('date_to'). '+1 day'))? date('Y-m-d', strtotime(request()->input('date_to'). '+1 day')) : '';
            $term = $request->term ? $request->term : '';
            $user_id = $request->user_id ? $request->user_id : '';
            $product = $request->product ? $request->product : '';
            $data=Order::when($user_id, function($query) use ($user_id){
                            $query->where('user_id', 'like', '%' . $user_id . '%');
                        })
                        ->when($product, function($query) use ($product){
                            $query->where('product_name', 'like', '%' . $product .'%');
                        })
                        ->when($term, function($query) use ($term){
                            $query->where('order_no', 'like', '%' . $term .'%');
                        })
                       ->whereBetween('created_at', [$from, $to])->latest('id')
                        ->paginate(25);
            
           
            //dd($data);
        } else {
            $data = Order::orderBy('id', 'desc')->latest('id')->paginate(25);
            
        }
        $allUser=User::where('type',1)->orderby('name')->get();
        $products=RewardProduct::orderby('name')->get();
        return view('admin.order.index', compact('data','allUser','products','request'));
    }

    public function show(Request $request, $id)
    {
        $data = Order::where('id',$id)->first();
        return view('admin.order.detail', compact('data'));
    }

    public function status(Request $request, $id, $status)
    {
        $storeData = Order::findOrFail($id);
        $storeData->status = $status;
        $storeData->save();
        if ($storeData) {
            return redirect()->back();
        } else {
            return redirect()->route('admin.order.index');
        }
    }
      //export csv for reward order report

      public function exportCSV(Request $request)
      {
        if (isset($request->date_from) || isset($request->date_to) ||isset($request->product) ||isset($request->term) || isset($request->user_id) ) {
            $from = $request->date_from ? $request->date_from : date('Y-m-01');
            $to = date('Y-m-d', strtotime(request()->input('date_to'). '+1 day'))? date('Y-m-d', strtotime(request()->input('date_to'). '+1 day')) : '';
            $term = $request->term ? $request->term : '';
            $user_id = $request->user_id ? $request->user_id : '';
            $product = $request->product ? $request->product : '';
            $data=Order::when($user_id, function($query) use ($user_id){
                            $query->where('user_id', 'like', '%' . $user_id . '%');
                        })
                        ->when($product, function($query) use ($product){
                            $query->where('product_name', 'like', '%' . $product .'%');
                        })
                        ->when($term, function($query) use ($term){
                            $query->where('order_no', 'like', '%' . $term .'%');
                        })
                       ->whereBetween('created_at', [$from, $to])->latest('id')
                        ->paginate(25);
            
           
        //dd($data);
        } else {
            $data = Order::orderBy('id', 'desc')->latest('id')->paginate(25);
            
        }
  
          if (count($data) > 0) {
              $delimiter = ",";
              $filename = "reward-order-report-".date('Y-m-d').".csv";
  
              // Create a file pointer 
              $f = fopen('php://memory', 'w');
  
              // Set column headers 
              $fields = array('SR',  'PRODUCT NAME','QUANTITY', 'ORDER NUMBER', 
               'USER','EMAIL','MOBILE','BILLING ADDRESS','BILLING STATE','BILLING COUNTRY','BILLING CITY','BILLING PINCODE','DATETIME');
              fputcsv($f, $fields, $delimiter); 
  
              $count = 1;
  
              foreach($data as $row) {
                 
                  $datetime = date('j M Y g:i A', strtotime($row['created_at']));
                  $lineData = array(
                      $count,
                      $row['product_name'] ?? '',
                      $row['qty'] ?? '',
                      $row['order_no'] ?? '',
                      $row['user']['name'] ?? '',
                      $row['email'] ?? '',
                      $row['mobile'] ?? '',
                      $row['billing_address'] ?? '',
                      $row['billing_state'] ?? '',
                      $row['billing_country'] ?? '',
                      $row['billing_city'] ?? '',
                      $row['billing_pin'] ?? '',
                      $datetime
                  );
  
                  fputcsv($f, $lineData, $delimiter);
  
                  $count++;
              }
  
              // Move back to beginning of file
              fseek($f, 0);
  
              // Set headers to download file rather than displayed
              header('Content-Type: text/csv');
              header('Content-Disposition: attachment; filename="' . $filename . '";');
  
              //output all remaining data on a file pointer
              fpassthru($f);
          }
      }
}