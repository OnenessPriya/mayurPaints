<?php

namespace App\Http\Controllers\Admin;

use App\Models\RetailerProduct;
use App\Models\ProductSpecification;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class RetailerProductController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->keyword)){
            $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
            $data = RetailerProduct::where('title',$keyword)->orderby('id','desc')->paginate(25);
        }else{
            $data = RetailerProduct::orderby('id','desc')->paginate(25);
        }  
        return view('admin.reward.product.index', compact('data','request'));
    }

    public function create(Request $request)
    {
        return view('admin.reward.product.create');
    }

    public function store(Request $request)
    {
         //dd($request->all());

        $request->validate([
            "title" => "required|string|max:255",
            "short_desc" => "required",
            "desc" => "required",
            "image" => "required",
        ]);
        $storeData=new RetailerProduct();
        $storeData->title=$request->title;
        $storeData->short_desc=$request->short_desc;
        $storeData->desc=$request->desc;
        $storeData->amount=$request->amount;
        $storeData->position =$storeData->position+1;
        // slug generate
        $slug = \Str::slug($request['title'], '-');
        $slugExistCount = RetailerProduct::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $storeData->slug = $slug;
        if (isset($request['image'])) {
            $upload_path = "public/uploads/retailer/product/";
            $image = $collectedData['image'];
            $imageName = time() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $storeData->image = $upload_path . $uploadedImage;
        }
        $storeData->save();
        if (!empty($request['name']) && !empty($request['description'])) {
            $multipleColorData = [];

            foreach ($request['name'] as $nameKey => $nameValue) {
                $multipleColorData[] = [
                    'product_id' => $storeData->id,
                    'name' => $nameValue,
                ];
            }

            foreach ($request['description'] as $descriptionKey => $descriptionValue) {
                $multipleColorData[$descriptionKey]['description'] = $descriptionValue;
            }

            // dd($multipleColorData);

            ProductSpecification::insert($multipleColorData);
        }
        if ($storeData) {
            return redirect()->route('admin.reward.retailer.product.index');
        } else {
            return redirect()->route('admin.reward.retailer.product.create')->withInput($request->all());
        }
    }

    public function show(Request $request, $id)
    {
        $data = RetailerProduct::where('id',$id)->first();
        return view('admin.reward.product.detail', compact('data'));
    }


    public function edit(Request $request, $id)
    {
        $data = RetailerProduct::where('id',$id)->first();
        return view('admin.reward.product.edit', compact('id', 'data'));
    }

    public function update(Request $request,$id)
    {
         //dd($request->all());

        $request->validate([
            "title" => "required|string|max:255",
            "short_desc" => "required",
            "desc" => "required",
            "image" => "nullable",
        ]);

        $storeData=RetailerProduct::findOrFail($id);
        $storeData->title=$request->title;
        $storeData->short_desc=$request->short_desc;
        $storeData->desc=$request->desc;
        $storeData->amount=$request->amount;
        $storeData->position =$storeData->position+1;
        // slug generate
        if ($request->title!=$storeData->title) {
            $slug = \Str::slug($request['title'], '-');
            $slugExistCount = RetailerProduct::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $storeData->slug = $slug;
        }
        if (isset($request['image'])) {
            $upload_path = "public/uploads/retailer/product/";
            $image = $request['image'];
            $imageName = time() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $storeData->image = $upload_path . $uploadedImage;
        }
        $storeData->save();
        if (!empty($request['name']) && !empty($request['description'])) {
            $multipleColorData = [];

            foreach ($request['name'] as $nameKey => $nameValue) {
                $multipleColorData[] = [
                    'product_id' => $storeData->id,
                    'name' => $nameValue,
                ];
            }

            foreach ($request['description'] as $descriptionKey => $descriptionValue) {
                $multipleColorData[$descriptionKey]['description'] = $descriptionValue;
            }

             //dd($multipleColorData);

            ProductSpecification::insert($multipleColorData);
        }
        if ($storeData) {
            return redirect()->back()->with('success', 'Product updated successfully');
        } else {
            return redirect()->route('admin.reward.retailer.product.update', $request->product_id)->withInput($request->all());
        }
    }

    public function status(Request $request, $id)
    {
        $storeData = RetailerProduct::findOrFail($id);

        $status = ($storeData->status == 1) ? 0 : 1;
        $storeData->status = $status;
        $storeData->save();
        if ($storeData) {
            return redirect()->route('admin.reward.retailer.product.index');
        } else {
            return redirect()->route('admin.reward.retailer.product.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id)
    {
        $data=RetailerProduct::destroy($id);

        return redirect()->route('admin.reward.retailer.product.index');
    }


    //export csv for product 
    public function exportCSV(Request $request)
    {
        if(isset($request->keyword)){
            $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
            $data = RetailerProduct::where('title',$keyword)->where('status',1)->orderby('id','desc')->paginate(25);
        }else{
            $data = RetailerProduct::where('status',1)->orderby('id','desc')->paginate(25);
        }  

        if (count($data) > 0) {
            $delimiter = ",";
            $filename = "onn-primary-order-report-".date('Y-m-d').".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Set column headers 
            $fields = array('SR','PRODUCT NAME', 'SHORT DESCRIPTION', 'DESCRIPTION','POINTS','STATUS', 
            'DATETIME');
            fputcsv($f, $fields, $delimiter); 

            $count = 1;

            foreach($data as $row) {
               
                $datetime = date('j M Y g:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['title'] ?? '',
                    $row['short_desc'] ?? '',
                    $row['desc'] ?? '',
                    $row['amount'] ?? '',
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
