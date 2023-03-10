<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Size;
use App\Models\Sale;
use App\Models\ProductColor;
use App\Models\ProductColorSize;
use App\Models\Wishlist;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    use UploadAble;

    public function listAll()
    {
        return Product::paginate(25);
    }

    public function categoryList()
    {
        return Category::all();
    }
   
	public function getSearchProducts($keyword,$category)
    {
        $pro=Product::when($keyword!='', function($query) use ($keyword){
            $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
           
        ->when($category!='', function($query) use ($category){
            $query->where('cat_id', '=' , $category);
        })
        ->latest('id','desc')->paginate(25);
        return $pro;
    }


    public function listById($id)
    {
        return Product::where('id',$id)->with('category')->get();
    }

    public function listBySlug($slug)
    {
        return Product::where('slug', $slug)->with('category', 'subCategory', 'collection', 'colorSize')->first();
    }

    public function relatedProducts($id)
    {
        $product = Product::findOrFail($id);
        $cat_id = $product->cat_id;
        return Product::where('cat_id', $cat_id)->where('id', '!=', $id)->with('category', 'subCategory', 'collection', 'colorSize')->get();
    }
    /**
     * This method is to get product details by category id
     * @param str $categoryId
     */
    public function getProductByCategoryId($categoryId){

        return Product::where('cat_id', $categoryId)->where('status', '1')->with('colorSize','category')->orderBy('position_collection','asc')->get();
    }


    /**
     * This method is to get product details by collection id
     * @param str $collectionId
     */
    public function getProductByCollectionId($collectionId){
        return Product::where('collection_id', $collectionId)->with('collection')->orderBy('position')->get();
    }
    /**
     * This method is to get product details by category id
     * @param str $categoryId
     */
    public function productlistByuse($only_for)
    {

        return Product::where('only_for', $only_for)->get();
    }
    

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $collectedData = collect($data);
            $newEntry = new Product;
            $newEntry->cat_id = $collectedData['cat_id'];
            $newEntry->name = $collectedData['name'];
            $newEntry->short_desc = $collectedData['short_desc'];
            $newEntry->desc = $collectedData['desc'];
            $newEntry->price = $collectedData['price'];
            $newEntry->apply_on = $collectedData['apply_on'];
            $newEntry->apply_by = $collectedData['apply_by'];
            $newEntry->coverage = $collectedData['coverage'];
            $newEntry->size = $collectedData['size'];
            $newEntry->self_life = $collectedData['self_life'];
           // $newEntry->position = $count+1;
            // slug generate
            $slug = \Str::slug($collectedData['name'], '-');
            $slugExistCount = Product::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $newEntry->slug = $slug;

            // main image handling
            $upload_path = "public/uploads/product/";
            $image = $collectedData['image'];
            $imageName = time() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $newEntry->image = $upload_path . $uploadedImage;
            $newEntry->save();

            DB::commit();
            return $newEntry;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
        }
    }

     public function update($id, array $newDetails)
    {
        // dd($newDetails);

        DB::beginTransaction();

        try {
            $upload_path = "public/uploads/product/";
            $updatedEntry = Product::findOrFail($id);
            // dd($updatedEntry);
            $collectedData = collect($newDetails);
            if (!empty($collectedData['cat_id'])) $updatedEntry->cat_id = $collectedData['cat_id'];
            $updatedEntry->name = $collectedData['name'];
            $updatedEntry->short_desc = $collectedData['short_desc'];
            $updatedEntry->desc = $collectedData['desc'];
            $updatedEntry->price = $collectedData['price'];
            $updatedEntry->apply_on = $collectedData['apply_on'];
            $updatedEntry->apply_by = $collectedData['apply_by'];
            $updatedEntry->coverage = $collectedData['coverage'];
            $updatedEntry->size = $collectedData['size'];
            $updatedEntry->self_life = $collectedData['self_life'];

            // slug generate
            $slug = \Str::slug($collectedData['name'], '-');
            $slugExistCount = Product::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

            $updatedEntry->slug = $slug;

            if (isset($newDetails['image'])) {
                // delete old image
                if (Storage::exists($updatedEntry->image)) unlink($updatedEntry->image);

                $image = $collectedData['image'];
                $imageName = time() . "." . $image->getClientOriginalName();
                $image->move($upload_path, $imageName);
                $uploadedImage = $imageName;
                $updatedEntry->image = $upload_path . $uploadedImage;
            }

            $updatedEntry->save();
            DB::commit();
            return $updatedEntry;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
    }
    public function toggle($id)
    {
        $updatedEntry = Product::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function delete($id)
    {
        Product::destroy($id);
    }

    public function deleteSingleImage($id)
    {
        ProductImage::destroy($id);
    }


}
