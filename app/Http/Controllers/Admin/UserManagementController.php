<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Contracts\UserContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Session;

class UserManagementController extends BaseController
{

    protected $UserRepository;

    /**
     * UserManagementController constructor.
     * @param UserRepository $UserRepository
     */

    public function __construct(UserContract $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * List all the users
     */
    public function index(Request $request)
    {
        $data =  User::paginate(5);
        if (!empty($request->term)) {
            // dd($request->term);
             $users = $this->UserRepository->getSearchUser($request->term);

            // dd($categories);
         } else {
    	$users = $this->UserRepository->listUsers();
         }
    	$this->setPageTitle('Users', 'List of all users');
    	return view('admin.users.index',compact('users','data'));
    }

    /**
     * Update user with approve or block status
     * @param Request $request
     */
    public function updateUser(Request $request)
    {
        $response = $this->UserRepository->blockUser($request->user_id,$request->is_block);

        if($response){
            return response()->json(array('message'=>'Successfully updated'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $user = $this->UserRepository->updateUserStatus($params);

        if ($user) {
            return response()->json(array('message'=>'User status successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->UserRepository->deleteUser($id);

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while deleting user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'User deleted successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $users = $this->UserRepository->getUserDetails($id);
        $user = $users[0];

        $this->setPageTitle('User', 'User Details : '.$user->title);
        return view('admin.users.details', compact('user'));
    }
}
