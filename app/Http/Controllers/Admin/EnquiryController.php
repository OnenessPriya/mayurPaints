<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquery;
use App\Models\Product;
class EnquiryController extends Controller
{
    /**
     * This method is for show enquiry list
     *
     */
    public function index(Request $request)
    {
        $term = $request->term ? $request->term : '';

        $query = Enquery::query();

        $query->when($term, function($query) use ($term) {
            $query->where('product_id', 'LIKE', '%' . $term . '%');
        });

        $data = $query->latest('id')->paginate(25);
        $product= Product::orderby('name')->get();
        return view('admin.enquiry.index', compact('data', 'request','product'));
    }

    /**
     * This method is for show enquiry id wise
     *
     */
    public function show(Request $request,$id)
    {
        $data =Enquery::where('id',$id)->first();
        return view('admin.enquiry.detail', compact('data', 'request'));
    }
}
