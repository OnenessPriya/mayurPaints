<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\PainterInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\User;

class PainterController extends Controller
{
    private CategoryInterface $categoryRepository;

    public function __construct(PainterInterface $PainterRepository)
    {
        $this->PainterRepository = $PainterRepository;
    }
    /**
     * This method is for show category list
     *
     */
    public function index(Request $request)
    {
        if (!empty($request->term)) {

            $data = $this->PainterRepository->getSearchPainter($request->term);

        } else {
            $data = $this->PainterRepository->getPainter();
           
        }
        return view('admin.user.painter.index', compact('data','request'));
    }
    /**
     * This method is for show category details
     * @param  $id
     *
     */
    public function show(Request $request, $id)
    {
        $data = $this->PainterRepository->getPainterById($id);
        return view('admin.user.painter.detail', compact('data'));
    }
    
    /**
     * This method is for update painter status
     * @param  $id
     *
     */
    public function status(Request $request, $id)
    {
        $categoryStat = $this->PainterRepository->toggleStatus($id);

        if ($categoryStat) {
            return redirect()->route('admin.user.painter.index');
        } else {
            return redirect()->route('admin.user.painter.index')->withInput($request->all());
        }
    }
    /**
     * This method is for update painter status
     * @param  $id
     *
     */
    public function verification(Request $request, $id)
    {
        $data = $this->PainterRepository->toggleApprove($id);

        if ($data) {
            return redirect()->route('admin.user.painter.index');
        } else {
            return redirect()->route('admin.user.painter.index')->withInput($request->all());
        }
    }
    /**
     * This method is for category delete
     * @param  $id
     *
     */
    public function destroy(Request $request, $id)
    {
        $this->PainterRepository->deletePainter($id);

        return redirect()->route('admin.user.painter.index');
    }

    public function exportCSV(Request $request)
    {
        if (!empty($request->term)) {

            $data = $this->PainterRepository->getSearchPainter($request->term);

        } else {
            $data = $this->PainterRepository->getPainter();
           
        }

        if ($data) {
            $delimiter = ",";
            $filename = "painter-".date('Y-m-d').".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('SR','Name','Mobile','Whatsapp No','Email','Address','City','State','Pincode','Status', 'Datetime');
            fputcsv($f, $fields, $delimiter);

            $count = 1;

            foreach($data as $row) {
                $datetime = date('j F, Y h:i:s', strtotime($row['created_at']));
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
