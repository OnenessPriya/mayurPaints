<?php

namespace App\Repositories;

use App\Interfaces\PainterInterface;
use App\User;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Auth;
class PainterRepository implements PainterInterface
{
    use UploadAble;

    /**
     * This method is to fetch list of all Painter
     */
    public function getPainter()
    {
        return User::where('type','=',1)->orderBy('id','desc')->paginate(30);
    }

    /**
     * This method is to get painter details by id
     * @param str $Id
     */
    public function getPainterById($Id)
    {
        return User::findOrFail($Id);
    }


    /**
     * This method is to delete category
     * @param str $Id
     */
    public function deletePainter($Id)
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

     /**
     * This method is to toggle category status
     * @param str $categoryId
     */
    public function toggleApprove($id){
        $data = User::findOrFail($id);

        $isApprove = ( $data->is_approve == 1 ) ? 0 : 1;
        $data->is_approve = $isApprove;
        $data->save();

        return $data;
    }

    public function getSearchPainter(string $term)
    {
        return User::where('type',1)->where([['name', 'LIKE', '%' . $term . '%']])
        ->paginate(30);
    }
	
	
}
