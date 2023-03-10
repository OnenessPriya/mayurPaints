<?php

namespace App\Repositories;

use App\Interfaces\CustomerInterface;
use App\User;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Auth;
class CustomerRepository implements CustomerInterface
{
    use UploadAble;

    /**
     * This method is to fetch list of all Customer
     */
    public function getCustomer()
    {
        return User::where('type','=',3)->orderBy('id','desc')->paginate(30);
    }

    /**
     * This method is to get Customer details by id
     * @param str $Id
     */
    public function getCustomerById($Id)
    {
        return User::findOrFail($Id);
    }


    /**
     * This method is to delete category
     * @param str $Id
     */
    public function deleteCustomer($Id)
    {
        User::destroy($Id);
    }
    /**
     * This method is to toggle category status
     * @param str $categoryId
     */
    public function toggleStatus($id){
        $data = User::findOrFail($id);

        $status = ( $data->status == 1 ) ? 0 : 1;
        $data->status = $status;
        $data->save();

        return $data;
    }

    public function getSearchCustomer(string $term)
    {
        return User::where('type',3)->where([['name', 'LIKE', '%' . $term . '%']])
        ->paginate(30);
    }
	
	
}
