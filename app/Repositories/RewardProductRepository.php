<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\RewardProductInterface;
use App\Models\RewardProduct;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RewardProductRepository implements RewardProductInterface
{
    use UploadAble;

    public function listAll()
    {
        return RewardProduct::paginate(25);
    }

	public function getSearchProducts($keyword)
    {
        $pro=RewardProduct::when($keyword!='', function($query) use ($keyword){
            $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
           
        ->latest('id','desc')->paginate(25);
        return $pro;
    }


    public function listById($id)
    {
        return RewardProduct::where('id',$id)->get();
    }

    public function listBySlug($slug)
    {
        return RewardProduct::where('slug', $slug)->with('category', 'subCategory', 'collection', 'colorSize')->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $collectedData = collect($data);
            $newEntry = new RewardProduct;
            $newEntry->name = $collectedData['name'];
            $newEntry->short_desc = $collectedData['short_desc'];
            $newEntry->desc = $collectedData['desc'];
            $newEntry->points = $collectedData['points'];
            // slug generate
            $slug = \Str::slug($collectedData['name'], '-');
            $slugExistCount = RewardProduct::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $newEntry->slug = $slug;

            // main image handling
            $upload_path = "public/uploads/rewardproduct/";
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
            $upload_path = "public/uploads/rewardproduct/";
            $updatedEntry = RewardProduct::findOrFail($id);
            // dd($updatedEntry);
            $collectedData = collect($newDetails);
            $updatedEntry->name = $collectedData['name'];
            $updatedEntry->short_desc = $collectedData['short_desc'];
            $updatedEntry->desc = $collectedData['desc'];
            $updatedEntry->price = $collectedData['points'];

            // slug generate
            $slug = \Str::slug($collectedData['name'], '-');
            $slugExistCount = RewardProduct::where('slug', $slug)->count();
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
        $updatedEntry = RewardProduct::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function delete($id)
    {
        RewardProduct::destroy($id);
    }

}
