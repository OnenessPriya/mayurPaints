<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Contracts\AboutContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;

class AboutManagementController extends BaseController
{
    protected $AboutRepository;

    /**
     * StateManagementController constructor.
     * @param StateRepository $AboutRepository
     */

    public function __construct(AboutContract $AboutRepository)
    {
        $this->AboutRepository = $AboutRepository;
    }

    /**
     * List all the states
     */
    public function index()
    {
        $about = $this->AboutRepository->listaboutus();

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
        $about = $this->AboutRepository->findaboutById($id);

        $this->setPageTitle('State', 'Edit About us : '.$about->pretty_name);
        return view('admin.about.edit', compact('about'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'pretty_name'      =>  'required|string|min:1',
            'content'      =>  'required|string|min:1',
            'content1'      =>  'required|string|min:1',
            'content2'      =>  'required|string|min:1',
            'image'      =>  'required|mimes:jpg,jpeg,png|max:1000',
            'banner_image'      => 'required|mimes:jpg,jpeg,png|max:1000',

        ]);

        $params = $request->except('_token');

        $about = $this->AboutRepository->updateabout($params);

        if (!$about) {
            return $this->responseRedirectBack('Error occurred while updating Abouts.', 'error', true, true);
        }
        return $this->responseRedirectBack('About has been updated successfully' ,'success',false, false);
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
    public function details($id)
    {
        $target = $this->AboutRepository->detailsabout($id);
        $about = $target[0];

        $this->setPageTitle('About-Us', 'About Details : '.$about->name);
        return view('admin.about.details', compact('about'));
    }


    public function csvStore(Request $request)
    {
        if (!empty($request->file)) {
            // if ($request->input('submit') != null ) {
            $file = $request->file('file');
            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");
            // 50MB in Bytes
            $maxFileSize = 50097152;
            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {
                // Check file size
                if ($fileSize <= $maxFileSize) {
                    // File upload location
                    $location = 'admin/uploads/csv';
                    // Upload file
                    $file->move($location, $filename);
                    // Import CSV to Database
                    $filepath = public_path($location . "/" . $filename);
                    // Reading file
                    $file = fopen($filepath, "r");
                    $importData_arr = array();
                    $i = 0;
                    while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $num = count($filedata);
                        // Skip first row
                        if ($i == 0) {
                            $i++;
                            continue;
                        }
                        for ($c = 0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata[$c];
                        }
                        $i++;
                    }
                    fclose($file);

                    // echo '<pre>';print_r($importData_arr);exit();

                    // Insert into database
                    foreach ($importData_arr as $importData) {
                        $storeData = 0;
                        if(isset($importData[5]) == "Carry In") $storeData = 1;

                        $insertData = array(
                            "name" => isset($importData[0]) ? $importData[0] : null,
                            "slug" => isset($importData[0]) ? $importData[0] : null,

                        );
                        // echo '<pre>';print_r($insertData);exit();
                        State::insertData($insertData);
                    }
                    Session::flash('message', 'Import Successful.');
                } else {
                    Session::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            Session::flash('message', 'No file found.');
        }
        return redirect()->route('admin.state.index');
    }
    // csv upload
}
