<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RetailerUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class RetailerUserController extends Controller
{
    /**
     * This method is for show user list
     *
     */
    public function index(Request $request)
    {
        $keyword = (isset($request->keyword) && $request->keyword!='')?$request->keyword:'';
        $user_type = (isset($request->user_type) && $request->user_type!='')?$request->user_type:'';
        $data = RetailerUser::paginate(25);
        return view('admin.reward.user.index', compact('data'));
    }
    /**
     * This method is for show user details
     * @param  $id
     *
     */
    public function show(Request $request, $id)
    {
        $data = RetailerUser::findOrFail($id);
        return view('admin.reward.user.detail', compact('data'));
    }
     /**
     * This method is for update user status
     * @param  $id
     *
     */
    public function status(Request $request, $id)
    {
        $storeData = RetailerUser::findOrFail($id);

        $status = ($storeData->status == 1) ? 0 : 1;
        $storeData->status = $status;
        $storeData->save();

        if ($storeData) {
            return redirect()->back()->with('success','Status Updated');
            // return redirect()->route('admin.user.list');
        } else {
            return redirect()->route('admin.reward.retailer.user.index')->withInput($request->all());
        }
    }
}
