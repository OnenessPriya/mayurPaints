<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    // DO NOT REMOVE
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout successfull');
    }
}
