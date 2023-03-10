<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\RewardProductInterface;
use App\Models\RewardProduct;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RewardProductController extends Controller
{
      // private RewardProductInterface $RewardproductRepository;

      public function __construct(RewardProductInterface $RewardproductRepository)
      {
          $this->RewardproductRepository = $RewardproductRepository;
      }
  
      public function index(Request $request)
      {
            $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
            $data = $this->RewardproductRepository->getSearchProducts($keyword);
             
          return view('admin.reward.product.index', compact('data','request'));
      }
  
      public function create(Request $request)
      {
          return view('admin.reward.product.create', compact('request'));
      }
  
      public function store(Request $request)
      {
           //dd($request->all());
  
          $request->validate([
              "name" => "required",
              "short_desc" => "nullable",
              "desc" => "nullable",
              "points" => "required",
              "image" => "required",
          ]);
          //dd('hi');
          $params = $request->except('_token');
          $storeData = $this->RewardproductRepository->create($params);
  
          if ($storeData) {
              return redirect()->route('admin.reward.product.index');
          } else {
              return redirect()->route('admin.reward.product.create')->withInput($request->all());
          }
      }
  
      public function show(Request $request, $id)
      {
          $item = $this->RewardproductRepository->listById($id);
          $data=$item[0];
          return view('admin.reward.product.detail', compact('data'));
      }
  
      public function edit(Request $request, $id)
      {
          $item = $this->RewardproductRepository->listById($id);
          $data = $item[0];

          return view('admin.reward.product.edit', compact('id', 'data'));
      }
  
      public function update(Request $request)
      {
          // dd($request->all());
  
          $request->validate([
              "name" => "required|string",
              "short_desc" => "nullable",
              "desc" => "nullable",
              "points" => "nullable",
              "image" => "nullable",
          ]);
  
          $params = $request->except('_token');
          $storeData = $this->RewardproductRepository->update($request->id,$params);
  
          if ($storeData) {
              return redirect()->back()->with('success', 'Product updated successfully');
          } else {
              return redirect()->route('admin.reward.product.update', $request->id)->withInput($request->all());
          }
      }
  
      public function status(Request $request, $id)
      {
          $storeData = $this->RewardproductRepository->toggle($id);
  
          if ($storeData) {
              return redirect()->route('admin.reward.product.index');
          } else {
              return redirect()->route('admin.reward.product.create')->withInput($request->all());
          }
      }
  
  
      public function destroy(Request $request, $id)
      {
          $this->RewardproductRepository->delete($id);
  
          return redirect()->route('admin.reward.product.index');
      }
  
     
      public function exportCSV(Request $request)
      {
          $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
          $data = $this->RewardproductRepository->getSearchProducts($keyword);
          if ($data) {
              $delimiter = ",";
              $filename = "product-".date('Y-m-d').".csv";
  
              // Create a file pointer
              $f = fopen('php://memory', 'w');
  
              // Set column headers
              $fields = array('SR','Name','Short Description','Description','Points','Status', 'Datetime');
              fputcsv($f, $fields, $delimiter);
  
              $count = 1;
  
              foreach($data as $row) {
                  $datetime = date('j F, Y h:i A', strtotime($row['created_at']));
                  $lineData = array(
                      $count,
                      $row['name'],
                      strip_tags($row['short_desc']),
                      strip_tags($row['desc']),
                      $row['points'],
                      ($row->status == 1) ? 'Active' : 'Inactive',
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
