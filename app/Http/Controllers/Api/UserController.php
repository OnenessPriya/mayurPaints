<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Hash;
class UserController extends Controller
{
    //  create painter aadhar document API
	public function CreateAadhar(Request $request) {
		$validator = Validator::make($request->all(), [
            'aadhar' => 'required|mimes:jpg,jpeg,png,svg,gif,pdf'
        ]);
        if (!$validator->fails()) {
				$imageName = mt_rand().'.'.$request->aadhar->extension();
				$uploadPath = 'public/uploads/user/document';
				$request->aadhar->move($uploadPath, $imageName);
				$total_path = $uploadPath.'/'.$imageName;
			    $resp =  $total_path;
			return response()->json(['error' => false, 'message' => 'Document added', 'data' => $resp]);
		} else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
		
	}
     //  create painter image API
	public function CreateImage(Request $request) {
		$validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png,svg,gif,pdf'
        ]);
        if (!$validator->fails()) {
				$imageName = mt_rand().'.'.$request->image->extension();
				$uploadPath = 'public/uploads/user/document';
				$request->image->move($uploadPath, $imageName);
				$total_path = $uploadPath.'/'.$imageName;
			    $resp =  $total_path;
			return response()->json(['error' => false, 'message' => 'Document added', 'data' => $resp]);
		} else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
		
	}
    // for painter registration
    public function painterRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'mobile' => ['required', 'integer','digits:10','unique:users'],
            'whatsapp_no' => ['required', 'integer', 'min:10'],
            'pin' => ['required', 'integer','digits:6'],
            'state' => ['required', 'string','max:255'],
            'address' => ['required', 'string','max:255'],
            'city' => ['required', 'string','max:255'],
            'password' => ['required'],
            'aadhar' => ['required'],
        ]);

        if (!$validator->fails()) {
            $user= new User;
            $user->name = $request->name;
            $user->mobile = $request->mobile ?? '';
            $user->email = $request->email ?? '';
            $user->whatsapp_no = $request->whatsapp_no ?? '';
            $user->pin = $request->pin ?? '';
            $user->state = $request->state ?? '';
            $user->address = $request->address ?? '';
            $user->city = $request->city ?? '';
            $user->type = 1;
            $user->password = bcrypt($request['password']);
            $user->created_at = date('Y-m-d g:i:s');
            $user->updated_at = date('Y-m-d g:i:s');
            if (isset($request['aadhar'])) {
                $user->aadhar = $request->aadhar;
            }
            $user->save();
            return response()->json(['error' => false, 'message' => 'Registration Successful','data'=>$user]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }

    // for customer registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:1'],
            'mobile' => ['required', 'integer','digits:10','unique:users'],
            'whatsapp_no' => ['required', 'integer', 'min:10'],
            'address' => ['required', 'string','max:255'],
        ]);

        if (!$validator->fails()) {
            $user= new User;
            $user->name = $request->name;
            $user->mobile = $request->mobile ?? '';
            $user->email = $request->email ?? '';
            $user->whatsapp_no = $request->whatsapp_no ?? '';
            $user->address = $request->address ?? '';
            $user->type = 3;
            $user->status = 1;
            $user->password = bcrypt($request['password']);
            $user->created_at = date('Y-m-d g:i:s');
            $user->updated_at = date('Y-m-d g:i:s');
            $user->save();
            return response()->json(['error' => false, 'message' => 'Registration Successful','data'=>$user]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }
    //google login
     public function googleLogin(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => ['required', 'string', 'min:1'],
         ]);
 
         if (!$validator->fails()) {
             $user= new User;
             $user->name = $request->name;
             $user->mobile = $request->mobile ?? '';
             $user->type = 3;
             $user->created_at = date('Y-m-d g:i:s');
             $user->updated_at = date('Y-m-d g:i:s');
             $user->save();
             return response()->json(['error' => false, 'message' => 'Login Successful','data'=>$user]);
         } else {
             return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
         }
     }

     
    //for login
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'integer','digits:10'],
			'password' => ['required'],
        ]);
        if (!$validator->fails()) {
            $mobile = $request->mobile;
			$password = $request->password;
            $userCheck = User::where('mobile', $mobile)->first();
            if ($userCheck) {
                 if (Hash::check($password, $userCheck->password)) {
                     return response()->json(['error' => false, 'resp' => 'Login successful', 'data' => $userCheck]);
                 } else {
                     return response()->json(['error' => true, 'resp' => 'You have entered wrong login credential. Please try with the correct one.', 'data' => $userCheck->password]);
                 }
            } else {
                return response()->json(['error' => true, 'resp' => 'You have entered wrong login credential. Please try with the correct one.']);
            }
        }
     else {
        return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }

     /**
     * This method is for show painter profile details
     * @param  $id
     *
     */
    public function myprofile($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json(['error'=>false, 'resp'=>'User data fetched successfully','data'=>$user]);

    }

    /**
     * This method is to update user profile details
     * @param  $id
     */
    public function updateProfile(Request $request,$id)
    {
        $updatedEntry = User::findOrFail($id);
        if ($request['name']) {
        $updatedEntry->name = $request->name;
        }
        if ($request['mobile']) {
        $updatedEntry->mobile = $request->mobile;
        }
        if ($request['email']) {
            $updatedEntry->email = $request->email;
            }
        if ($request['whatsapp_no']) {
        $updatedEntry->whatsapp_no = $request->whatsapp_no;
        }
        if ($request['pin']) {
        $updatedEntry->pin = $request->pin;
        }
        if ($request['state']) {
        $updatedEntry->state = $request->state;
        }
        if ($request['address']) {
            $updatedEntry->address = $request->address;
            }
        if ($request['city']) {
        $updatedEntry->city = $request->city;
        }
        if ($request['state']) {
        $updatedEntry->state = $request->state;
        }
        if ($request['image']) {
            $updatedEntry->image = $request->image;
        }
        if ($request['aadhar']) {
            $updatedEntry->aadhar = $request->aadhar;
        }
        $updatedEntry->save();
        if($updatedEntry){
            return response()->json(['error' => false, 'message' => 'Updated Successfully','data'=>$updatedEntry]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }
    //for change password
    public function changePassword(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
             'mobile'  => 'required',
             //'old_password'  => 'required',
            'new_password' => 'required'
        ]);
        if (!$validator->fails()) {
            $check_mobile = User::where('mobile',$request->mobile)->first();
            if (!$check_mobile) {
                return response()->json(['error' => true, 'message' =>'Mobile is not correct']);
            }
        //     $check_old_pass = User::where('mobile',$request->mobile)->where('password',$request->old_password)->first();
        //     //dd($check_old_pass);
        // if (!$check_old_pass) {
        //     return response()->json(['error' => true, 'message' =>'Old Password is not correct']);
        // }

        $new_pass = Hash::make($request->new_password);

        $updatedEntry = User::where('mobile', $request->mobile)->update(['password' => $new_pass]);

            return response()->json(['error' => false, 'message' => 'Update Successful','data'=>$updatedEntry]);
        } else {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }
    }

    /**
     * This method is to get user wallet balance
    *
    */
    public function walletBalance(Request $request,$id)
    {
        $data = User::where('id',$id)->first();
        if($data){
            return response()->json(['error'=>false, 'resp'=>'wallet balance data fetched successfully','data'=>$data->total_points]);
        } else {
            return response()->json(['error' => true, 'message' => 'No user found']);
        }
  
    }


}
