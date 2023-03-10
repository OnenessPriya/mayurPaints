<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required | string | email | exists:admins',
            'password' => 'required | string'
        ]);

        $adminCreds = $request->only('email', 'password');

        if ( Auth::guard('admin')->attempt($adminCreds) ) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login')->withInputs($request->all())->with('failure', 'Invalid credentials. Try again');
        }
    }

    public function home(Request $request)
    {
        $data = (object)[];
        $data->salesperson=User::where('type','2')->count();
        $data->painter=User::where('type','3')->count();
        $data->product=Product::count();
        return view('admin.home', compact('data'));
    }

}
