<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;

class AboutManagementController extends BaseController
{
    
    public function index()
    {
        $about = Setting::all();

        $this->setPageTitle('Abouts', 'About Us');
        return view('admin.about.index', compact('about'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Abouts', 'Create abouts');
        return view('admin.about.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pretty_name'      =>  'required|string|min:1',
            'content'      =>  'required|string|min:1',
            'image'      => 'required|mimes:jpg,jpeg,png|max:1000',
            'banner_image'      =>  'required|mimes:jpg,jpeg,png|max:1000',

        ]);

        $params = $request->except('_token');

        $about = $this->AboutRepository->createabout($params);

        if (!$about) {
            return $this->responseRedirectBack('Error occurred while creating abouts.', 'error', true, true);
        }
        return $this->responseRedirect('admin.about.index', 'About has been created successfully' ,'success',false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $about = Setting::findOrfail($id);

        $this->setPageTitle('State', 'Edit About us : '.$about->pretty_name);
        return view('admin.about.edit', compact('about'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'content'      =>  'required|string|min:1',

        ]);
            $about= Setting::findOrFail($id);
            $about->pretty_name = $request->pretty_name;
            $about->content = $request->content ?? '';
            $about->created_at = date('Y-m-d g:i:s');
            $about->updated_at = date('Y-m-d g:i:s');
            $about->save();

        if (!$about) {
            return redirect()->route('admin.about.view')->withInput($request->all())->with('success', 'Something happened');
        }
        return redirect()->route('admin.about.index')->with('success', 'about us updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $about = $this->AboutRepository->deleteabout($id);

        if (!$about) {
            return $this->responseRedirectBack('Error occurred while deleting Abouts.', 'error', true, true);
        }
        return $this->responseRedirect('admin.about.index', 'Abouts has been deleted successfully' ,'success',false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request){

        $params = $request->except('_token');

        $about = $this->AboutRepository->updateaboutStatus($params);

        if ($about) {
            return response()->json(array('message'=>'About status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $target = Setting::where('id',$id)->get();
        $about = $target[0];

        $this->setPageTitle('About-Us', 'About Details : '.$about->pretty_name);
        return view('admin.about.details', compact('about'));
    }

}
