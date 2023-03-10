<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Activity;
use App\User;

class ActivityController extends Controller
{
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        //$data = $this->userRepository->useractivitylog();
        // $users = $this->userRepository->listAll();
        // $date = (isset($request->year_from) && $request->year_from!='')?$request->year_from:'';
        // $time = (isset($request->year_to) && $request->year_to!='')?$request->year_to:'';
        // $userId = (isset($request->user_id) && $request->user_id!='')?$request->user_id:'';
        // $userType = (isset($request->user_type) && $request->user_type!='')?$request->user_type:'';
        // $data = $this->userRepository->getActivityByFilter($date,$time,$userId,$userType);

        // $target = Activity::
        // when($userId!='', function($query) use ($userId){
        //     $query->where('user_id', '=', $userId);
        // })
        // ->latest('id','desc')->paginate(25);

        if (isset($request->date_from) || isset($request->date_to) || isset($request->user_id) || isset($request->user_type)) {
            $date_from = $request->date_from ? $request->date_from : '';
            $date_to = $request->date_to ? $request->date_to : '';
            $user_type = $request->user_type ? $request->user_type : '';
            $user_id = $request->user_id ? $request->user_id : '';

            $query = Activity::query();

            $query->when($date_from, function($query) use ($date_from) {
                $query->where('date', '>=', $date_from);
            });
            $query->when($date_to, function($query) use ($date_to) {
                $query->where('date', '<=', $date_to);
            });
            $query->when($user_type, function($query) use ($user_type) {
                $query->where('user_type', $user_type);
            });
            $query->when($user_id, function($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });

            $data = $query->latest('id')->paginate(25);
        } else {
            $data = Activity::latest('id')->paginate(25);
        }

        return view('admin.useractivity.index', compact('data', 'request'));
    }

    public function show(Request $request, $id)
    {
        $data = $this->useractivitylistById->listById($id);
        return view('admin.useractivity.detail', compact('data'));
    }

    public function exportCSV()
    {
        // return Excel::download(new OrderExport, 'Secondary-sales-'.date('Y-m-d').'.csv');

        $data = Activity::latest('id')
        ->get()
        ->toArray();

        if (count($data) > 0) {
            $delimiter = ",";
            $filename = "onn-user-activity-".date('Y-m-d').".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('SR', 'USER', 'TYPE', 'COMMENT', 'LOCATION', 'DATETIME');
            fputcsv($f, $fields, $delimiter);

            $count = 1;

            foreach($data as $row) {
                $datetime = date('j F, Y h:i A', strtotime($row['created_at']));

                // $store = Store::select('store_name')->where('id', $row['store_id'])->first();
                $user = User::select('name', 'mobile', 'state', 'city', 'pin')->where('id', $row['user_id'])->first();

                // dd($store->store_name, $user->name, $user->mobile);

                $lineData = array(
                    $count,
                    $user->name ?? '',
                    $row['type'],
                    $row['comment'],
                    $row['location'],
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
