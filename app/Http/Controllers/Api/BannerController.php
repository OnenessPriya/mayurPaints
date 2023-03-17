<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Setting;
class BannerController extends Controller
{
    /**
     * This method is for show banner list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $banner = Banner::where('is_current',1)->get();

        return response()->json(['error'=>false, 'resp'=>'Banner data fetched successfully','data'=>$banner]);
    }

     /**
     * This method is for show about us list
     * @return \Illuminate\Http\JsonResponse
     */
    public function about(Request $request)
    {
        $about = Setting::all();

        return response()->json(['error'=>false, 'resp'=>'About us data fetched successfully','data'=>$about]);
    }


}
