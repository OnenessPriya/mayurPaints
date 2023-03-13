<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
		   
            $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
            $category = (!empty($request->cat_id) && $request->cat_id!='')?$request->cat_id:'';
            $data = $this->productRepository->getSearchProducts($keyword,$category);
            $category =Category::where('status', 1)->get();
		   
        return view('admin.product.index', compact('data','category','request'));
    }

    public function create(Request $request)
    {
        $category = $this->productRepository->categoryList();
        return view('admin.product.create', compact('category','request'));
    }

    public function store(Request $request)
    {
         //dd($request->all());

        $request->validate([
            "cat_id" => "required|integer",
            "name" => "required|string|max:255",
            "short_desc" => "required",
            "desc" => "nullable",
            "price" => "nullable",
            "image" => "required",
            "size" => "required",
        ]);

        $params = $request->except('_token');
        $storeData = $this->productRepository->create($params);

        if ($storeData) {
            return redirect()->route('admin.product.index');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
    }

    public function show(Request $request, $id)
    {
        $item = $this->productRepository->listById($id);
        $data=$item[0];
        return view('admin.product.detail', compact('data'));
    }

    public function edit(Request $request, $id)
    {
        $categories = $this->productRepository->categoryList();
        $item = $this->productRepository->listById($id);
        $data = $item[0];

        return view('admin.product.edit', compact('id', 'data', 'categories'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "cat_id" => "required|integer",
            "name" => "required|string|max:255",
            "short_desc" => "required",
            "desc" => "required",
            "price" => "required",
            "image" => "nullable",
        ]);

        $params = $request->except('_token');
        $storeData = $this->productRepository->update($request->product_id, $params);

        if ($storeData) {
            return redirect()->back()->with('success', 'Product updated successfully');
        } else {
            return redirect()->route('admin.product.update', $request->product_id)->withInput($request->all());
        }
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->productRepository->toggle($id);

        if ($storeData) {
            return redirect()->route('admin.product.index');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
    }


    public function destroy(Request $request, $id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.product.index');
    }

    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bulk_action' => 'required',
            'delete_check' => 'required|array',
        ], [
            'delete_check.*' => 'Please select at least one item'
        ]);

        if (!$validator->fails()) {
            if ($request['bulk_action'] == 'delete') {
                foreach ($request->delete_check as $index => $delete_id) {
                    Product::where('id', $delete_id)->delete();
                }

                return redirect()->route('admin.product.index')->with('success', 'Selected items deleted');
            } else {
                return redirect()->route('admin.product.index')->with('failure', 'Please select an action')->withInput($request->all());
            }
        } else {
            return redirect()->route('admin.product.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }
    }

    public function exportCSV(Request $request)
    {
        $keyword = (!empty($request->keyword) && $request->keyword!='')?$request->keyword:'';
        $category = (!empty($request->cat_id) && $request->cat_id!='')?$request->cat_id:'';
        $data = $this->productRepository->getSearchProducts($keyword,$category);
        if ($data) {
            $delimiter = ",";
            $filename = "product-".date('Y-m-d').".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('SR','Name','Category','Short Description','Description','Price','Apply On','Apply By','Coverage','Size','Self Life','Status', 'Datetime');
            fputcsv($f, $fields, $delimiter);

            $count = 1;

            foreach($data as $row) {
                $datetime = date('j F, Y h:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['name'],
                    $row->category->name,
                    $row['short_desc'],
                    $row['desc'],
                    $row['price'],
                    $row['apply_on'],
                    $row['apply_by'],
                    $row['coverage'],
                    $row['size'],
                    $row['self_life'],
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
