<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complain;
use App\Models\Product;
class ComplaintController extends Controller
{
   /**
     * This method is for show complaint list
     *
     */
    public function index(Request $request)
    {
        $term = $request->term ? $request->term : '';

        $query = Complain::query();

        $query->when($term, function($query) use ($term) {
            $query->where('name', 'LIKE', '%' . $term . '%');
        });

        $data = $query->latest('id')->paginate(25);
        $product= Product::orderby('name')->get();
        return view('admin.complaint.index', compact('data', 'request','product'));
    }

    /**
     * This method is for show complaint id wise
     *
     */
    public function show(Request $request,$id)
    {
        $data =Complain::where('id',$id)->first();
        return view('admin.complaint.detail', compact('data', 'request'));
    }
}
