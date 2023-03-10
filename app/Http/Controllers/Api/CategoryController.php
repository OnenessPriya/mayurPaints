<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * This method is for show category list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $categories = Category::where('status',1)->get();

        return response()->json(['error'=>false, 'resp'=>'Category data fetched successfully','data'=>$categories]);
    }

    /**
     * This method is for show category details
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request,$id)
    {
        $categories = Category::where('id',$id)->first();

        return response()->json(['error'=>false, 'resp'=>'Category data fetched successfully','data'=>$categories]);
    }
   
    /**
     * This method is to get product details by CategoryId
     *
     */
    public function productList($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        if(!function_exists('in_array_r')) {
            function in_array_r($needle, $haystack, $strict = false) {
                foreach ($haystack as $item) {
                    if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) return true;
                }
                return false;
            }
        }

        if(count($category->ProductDetails) > 0) {
             $customProduct = [];
            foreach($category->ProductDetails as $categoryProductKey => $categoryProductValue){
             if($categoryProductValue->status == 0) {continue;} {
                $customProduct[] = [
                    'id' => $categoryProductValue->id,
                    'product_name' => $categoryProductValue->name,
					'category_id' =>$categoryProductValue->cat_id,
                    'category_name' =>$categoryProductValue->category->name,
                    'image' => asset($categoryProductValue->image),
                    'status'=>$categoryProductValue->status,
                ];

            }
        }

        return response()->json([
            'error' => false,
            'resp' => 'Category wise Product data fetched successfully',
            'product'=>$customProduct
        ]);
        } else {
            return response()->json(['error' => true, 'resp' => 'No products found under this Category']);
        }
    }

}
