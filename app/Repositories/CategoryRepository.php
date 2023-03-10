<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Models\UserNoorderReason;
use Auth;
use App\Models\Activity;
use App\Models\Store;
class CategoryRepository implements CategoryInterface
{
    use UploadAble;

    /**
     * This method is to fetch list of all categories
     */
    public function getAllCategories()
    {
        return Category::orderBy('position')->get();
        // return Category::orderBy('position', 'asc')->paginate(5);
    }

    /**
     * This method is to fetch list of all categories in admin section
     */
    public function getCategories($cat= 25)
    {

        return Category::orderBy('id', 'desc')->paginate($cat);
        //return Category::orderBy('position', 'asc')->paginate(5);
    }

    public function getAllSizes()
    {
        return Size::latest('id', 'desc')->get();
    }

    public function getAllColors()
    {
        return Color::latest('id', 'desc')->get();
    }

    /**
     * This method is to get category details by id
     * @param str $categoryId
     */
    public function getCategoryById($categoryId)
    {
        return Category::findOrFail($categoryId);
    }

    /**
     * This method is to get category details by slug
     * @param str $slug
     */
    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->with('ProductDetails')->first();
    }

    /**
     * This method is to delete category
     * @param str $categoryId
     */
    public function deleteCategory($categoryId)
    {
        Category::destroy($categoryId);
    }

    /**
     * This method is to create category
     * @param arr $categoryDetails
     */
    public function createCategory(array $categoryDetails)
    {
        $upload_path = "uploads/category/";
        $collection = collect($categoryDetails);
        $category = new Category;
        $category->name = $collection['name'];
        $category->description = $collection['description'];

        // generate slug
        $slug = Str::slug($collection['name'], '-');
        $slugExistCount = Category::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $category->slug = $slug;

        // icon image
        $image = $collection['image'];
        $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
        $image->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $category->image = $upload_path.$uploadedImage;

        $category->save();

        return $category;
    }

    /**
     * This method is to update category details
     * @param str $categoryId
     * @param arr $newDetails
     */
    public function updateCategory($categoryId, array $newDetails)
    {
        $upload_path = "uploads/category/";
        $category = Category::findOrFail($categoryId);
        $collection = collect($newDetails);

        $category->name = $collection['name'];
        $category->description = $collection['description'];

        // generate slug
        $slug = Str::slug($collection['name'], '-');
        $slugExistCount = Category::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $category->slug = $slug;

        if (isset($newDetails['icon_path'])) {
            // dd('here');
            $image = $collection['icon_path'];
            $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $category->icon_path = $upload_path.$uploadedImage;
        }

        if (isset($newDetails['image_path'])) {
            // dd('here');
            $image = $collection['image_path'];
            $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $category->image_path = $upload_path.$uploadedImage;
        }

        if (isset($newDetails['banner_image'])) {
            // dd('here');
            $bannerImage = $collection['banner_image'];
            $bannerImageName = time().".".mt_rand().".".$bannerImage->getClientOriginalName();
            $bannerImage->move($upload_path, $bannerImageName);
            $uploadedImage = $bannerImageName;
            $category->banner_image = $upload_path.$uploadedImage;
        }
        // dd('outside');

        $category->save();

        return $category;
    }

    /**
     * This method is to toggle category status
     * @param str $categoryId
     */
    public function toggleStatus($id){
        $category = Category::findOrFail($id);

        $status = ( $category->status == 1 ) ? 0 : 1;
        $category->status = $status;
        $category->save();

        return $category;
    }

    public function getSearchCategory(string $term)
    {
        return Category::where([['name', 'LIKE', '%' . $term . '%']])
        ->paginate(5);
    }
	
	  public function noorder(array $params)
    {
        try {

            $collection = collect($params);

            $reason = new UserNoorderReason;
            $reason->store_id = $collection['store_id'];
            $reason->user_id = Auth::guard('web')->user()->id;
            $reason->comment = $collection['comment'];
            $reason->description = $collection['description'];
            $reason->location = $collection['location'];
            $reason->lat = $collection['lat'];
            $reason->lng = $collection['lng'];
            $reason->date = date('Y-m-d');
            $reason->time = date('H:i:s');
            $reason->save();
			
			$activity = new Activity;
			$ip = $_SERVER['REMOTE_ADDR'];
			$activity->user_id = Auth::guard('web')->user()->id;
			$activity->user_type = Auth::guard('web')->user()->user_type;
			$activity->date = date('Y-m-d');
			$activity->time = date('H:i:s');
			$activity->type = 'No Order Placed';
			$store_name = Store::where('id',$reason->store_id)->first();
			$activity->comment = 'Order not placed at '.$store_name->store_name.  ' due to '.$reason->comment;
			$activity->location = $ip;
			$activity->lat = $request->lat ?? '';
			$activity->lng = $request->lng ?? '';
			$activity->save();

            return $reason;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
