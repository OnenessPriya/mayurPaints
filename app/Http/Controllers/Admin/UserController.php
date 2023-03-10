<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\UserInterface;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Models\RetailerListOfOcc;
use App\Models\Area;
use App\Models\Store;
use App\Models\Distributor;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\StoreInterface;

class UserController extends Controller
{
     private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * This method is for show user list
     *
     */
    public function index(Request $request)
    {
        if (!empty($request->term)) {

            $data = $this->userRepository->getSearchUser($request->term);

        } else {
            $data = $this->userRepository->listAll();
           
        }

        return view('admin.user.sales.index', compact('data','request'));
    }

    /**
     * This method is for create user list
     *
     */
    public function create(Request $request)
    {
        return view('admin.user.sales.create');
    }
    /**
     * This method is for create user
     *
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            "name" => "required|string",
            "email" => "nullable|string|max:255",
            "mobile" => "required|integer|digits:10|unique:users",
            "whatsapp_no" => "required|integer|digits:10",
        ]);

        $params = $request->except('_token');
        $storeData = $this->userRepository->create($params);

        if ($storeData) {
            return redirect()->route('admin.user.sales-person.index');
        } else {
            return redirect()->route('admin.user.sales-person.index')->withInput($request->all());
        }
    }

    /**
     * This method is for show user details
     * @param  $id
     *
     */
    public function show(Request $request, $id)
    {
        $data = User::findOrFail($id);
        return view('admin.user.sales.detail', compact('data', 'id', 'request'));
        

    }


    public function edit(Request $request,$id)
    {
        $data=User::findOrfail($id);
        return view('admin.user.sales.edit', compact('data'));
    }
    /**
     * This method is for user update
     *
     *
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
           
        ]);
        $params = $request->except('_token');
        $updateEntry = $this->userRepository->update($id,$params);

        if ($updateEntry) {
            return redirect()->route('admin.user.sales-person.edit', $id)->with('success', 'User detail updated successfully');
        } else {
            return redirect()->route('admin.user.sales-person.edit', $id)->with('failure', 'Something happened')->withInput($request->all());
        }
    }
    /**
     * This method is for update user status
     * @param  $id
     *
     */
    public function status(Request $request, $id)
    {
        $storeData = $this->userRepository->toggle($id);

        if ($storeData) {
            return redirect()->back();
        } else {
            return redirect()->route('admin.user.sales-person.index')->withInput($request->all());
        }
    }
    
    /**
     * This method is for user delete
     * @param  $id
     *
     */
    public function destroy(Request $request, $id)
    {
        $this->userRepository->delete($id);

        return redirect()->route('admin.user.sales-person.index');
    }

	public function exportCSV(Request $request)
    {
        if (!empty($request->term)) {

            $data = $this->userRepository->getSearchUser($request->term);

        } else {
            $data = $this->userRepository->listAll();
           
        }

        if ($data) {
            $delimiter = ",";
            $filename = "sales-person-".date('Y-m-d').".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('SR','Name','Mobile','Whatsapp No','Email','Address','City','State','Pincode','Status', 'Datetime');
            fputcsv($f, $fields, $delimiter);

            $count = 1;

            foreach($data as $row) {
                $datetime = date('j F, Y h:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['name'],
                    $row['mobile'],
                    $row['whatsapp_no'],
                    $row['email'],
                    $row['address'],
                    $row['city'],
                    $row['state'],
                    $row['pin'],
                    ($row->status == 1) ? 'Active' : 'Inactive',
                    $datetime
                );

                fputcsv($f, $lineData, $delimiter);

                $count++;
            }

            // Move back to beginning of file
            fseek($f, 0);

            // Set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer
            fpassthru($f);
        }
    }
}
