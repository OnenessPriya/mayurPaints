<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\User;
use App\Models\Distributor;
use App\Models\Order;
use App\Activity;
use App\StoreVisit;
use App\UserAttendance;
use App\StartEndDay;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    /**
     * This method is for show user list
     *
     */
    public function listAll()
    {
        return User::where('type',2)->orderby('id','desc')->paginate(30);
    }
    /**
     * This method is for show user details
     * @param  $id
     *
     */
    public function listById($id)
    {
        // return User::where('id', $id)->get();
        return User::find($id);
    }
    /**
     * This method is for create user
     *
     */
    public function create(array $data)
    {
        $collectedData = collect($data);
        $newEntry = new User;
		$newEntry->name = $collectedData['name'];
        $newEntry->email = $collectedData['email'];
        $newEntry->mobile = $collectedData['mobile'];
        $newEntry->whatsapp_no = $collectedData['whatsapp_no'];
        $newEntry->address = $collectedData['address'];
        $newEntry->state = $collectedData['state'];
        $newEntry->city = $collectedData['city'];
        $newEntry->pin = $collectedData['pin'];
        $newEntry->type = 2;
        $newEntry->password = Hash::make($collectedData['password']);
        if($newEntry->image){
        $upload_path = "public/uploads/user/";
        $image = $collectedData['image'];
        $imageName = time() . "." . $image->getClientOriginalName();
        $image->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $newEntry->image = $upload_path . $uploadedImage;
		}
        if (isset($newEntry['aadhar'])) {
            $upload_path = "public/uploads/user/";
            $image = $collectedData['aadhar'];
            $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $updatedEntry->aadhar = $upload_path . $uploadedImage;
        }
        $newEntry->save();

        return $newEntry;
    }
    /**
     * This method is for user update
     *
     *
     */
    public function update($id, $newDetails)
    {
        $upload_path = "public/uploads/user/";
        $updatedEntry = User::findOrFail($id);
        $collectedData = collect($newDetails);
        $updatedEntry->name = $collectedData['name'];
        $updatedEntry->mobile = $collectedData['mobile'];
        $updatedEntry->email = $collectedData['email'];
        $updatedEntry->whatsapp_no = $collectedData['whatsapp_no'];
        $updatedEntry->address = $collectedData['address'];
        $updatedEntry->state = $collectedData['state'];
        $updatedEntry->city = $collectedData['city'];
        $updatedEntry->pin = $collectedData['pin'];
        if (isset($newDetails['aadhar'])) {
            // dd('here');
            $image = $collectedData['aadhar'];
            $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $updatedEntry->aadhar = $upload_path . $uploadedImage;
        }
        if (isset($newDetails['image'])) {
            // dd('here');
            $image = $collectedData['image'];
            $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $updatedEntry->image = $upload_path . $uploadedImage;
        }
        $updatedEntry->save();

        return $updatedEntry;
    }
    /**
     * This method is for update user status
     * @param  $id
     *
     */
    public function toggle($id)
    {
        $updatedEntry = User::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }
    
    /**
     * This method is for user delete
     * @param  $id
     *
     */
    public function delete($id)
    {
        User::destroy($id);
    }

    public function getSearchUser(string $term)
    {
        return User::where('type',2)->where([['name', 'LIKE', '%' . $term . '%']])
        ->paginate(30);
    }
	
}
