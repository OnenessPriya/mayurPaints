<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleFaq;
use App\Models\ArtcileFaqCategory;
use App\Models\ArtcileFaqSubCategory;
use App\Models\ArticleWidget;
use App\Models\ArticleFeature;
use App\Models\ActivityLogCsv;
use App\Models\User;
use App\Contracts\BlogFaqContract;
use App\Contracts\DirectoryCategoryContract;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Auth;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlogExport;
use DB;
use Illuminate\Support\Facades\Session as FacadesSession;
class BlogFaqController extends BaseController
{
    protected $BlogRepository;

    /**
     * BlogController constructor.
     * @param BlogFaqRepository $BlogRepository
     */

    public function __construct(BlogFaqContract $BlogFaqRepository)
    {
        $this->BlogFaqRepository = $BlogFaqRepository;

    }

    /**
     * List all the states
     */
    public function index(Request $request,$id)
    {

        if (!empty($request->term)) {
            // dd($request->term);
            $blogs = $this->BlogFaqRepository->getSearchBlog($request->term);

            // dd($categories);
        } else {
            $blogs =  ArticleFaq::where('blog_id',$id)->paginate(25);
        }
        // dd($categories);
        $blogcat = $this->BlogFaqRepository->getBlogcategories();
        //$blogcat = $this->directoryCategoryRepository->listdirectoryCategories('title', 'asc');
        $blogsubcat = $this->BlogFaqRepository->getBlogsubcategories();
        $this->setPageTitle('Article Faq', 'List of all Article Faq');
        return view('admin.articlefaq.faq.index', compact('blogs','blogcat', 'blogsubcat','request'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->setPageTitle('Article Faq', 'Create Article Faq');
         $blogcat = $this->BlogFaqRepository->getBlogcategories();
        //$blogcat = $this->directoryCategoryRepository->listdirectoryCategories('title', 'asc');
        $blogsubcat = $this->BlogFaqRepository->getBlogsubcategories();



        return view('admin.articlefaq.faq.create', compact('blogcat', 'blogsubcat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'question' => 'required|string|min:1',
          //  'category_id' => 'required|integer|min:1',
           // 'pincode' => 'required|integer|min:1',
           // 'suburb_id' => 'required|integer|min:1',
            'answer' => 'required|string|min:1',
           //'meta_title' => 'required|string',
           // 'meta_key' => 'required|string',
          //  'meta_description' => 'required|string',
          //  'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
           // 'banner_image' => 'required|mimes:jpg,jpeg,png|max:10000000',
           // 'image2' => 'required|mimes:jpg,jpeg,png|max:10000000',
        ]);

        $blog = $this->BlogFaqRepository->createBlog($request->except('_token'));

        if (!$blog) {
            return $this->responseRedirectBack('Error occurred while creating Article Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Article Faq has been created successfully', 'success', false, false);
        // return $this->responseRedirect('admin.blog.index', 'Article Faq has been created successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetblog = $this->BlogFaqRepository->findBlogById($id);
        $blogcat = $this->BlogFaqRepository->getBlogcategories();
        $blogsubcat = $this->BlogFaqRepository->getBlogsubcategories();
        $this->setPageTitle('Article Faq', 'Edit Article Faq : ' . $targetblog->title);
        return view('admin.articlefaq.faq.edit', compact('targetblog', 'blogcat', 'blogsubcat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'question' => 'required|string|min:1',
           // 'category_id' => 'required|integer|min:1',
            'answer' => 'required|string|min:1',
            //'pincode' => 'required|integer|min:1',
           // 'suburb_id' => 'required|integer|min:1',
           // 'content' => 'required|string|min:1',
           // 'meta_title' => 'required|string',
           // 'meta_key' => 'required|string',
           // 'meta_description' => 'required|string',
           // 'image' => 'required|mimes:jpg,jpeg,png|max:10000000',
           // 'banner_image' => 'required|mimes:jpg,jpeg,png|max:10000000',
           // 'image2' => 'required|mimes:jpg,jpeg,png|max:10000000',
        ]);
        // $slug = Str::slug($request->name, '-');
        // $slugExistCount = Blog::where('slug', $slug)->count();
        // if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
        $params = $request->except('_token');

        $targetblog = $this->BlogFaqRepository->updateBlog($params);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while updating Article Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Article Faq has been updated successfully', 'success', false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $targetblog = $this->BlogFaqRepository->deleteBlog($id);

        if (!$targetblog) {
            return $this->responseRedirectBack('Error occurred while deleting Article Faq.', 'error', true, true);
        }
        return $this->responseRedirectBack('Article Faq has been deleted successfully', 'success', false, false);
        // return $this->responseRedirect('admin.blog.index', 'Article Faq has been deleted successfully', 'success', false, false);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateStatus(Request $request)
    {

        $params = $request->except('_token');

        $targetblog = $this->BlogFaqRepository->updateBlogStatus($params);

        if ($targetblog) {
            return response()->json(array('message' => 'Article Faq status has been successfully updated'));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $targetblog = $this->BlogFaqRepository->detailsBlog($id);
        $blog = $targetblog[0];

        $this->setPageTitle('Article Faq', 'Article faq Details : ' . $blog->title);
        return view('admin.articlefaq.faq.details', compact('blog'));
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

                        $commaSeperatedCats = '';

                            $catExistCheck = BlogCategory::where('title', $importData[2])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new BlogCategory();
                                $dirCat->title = $importData[2];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedCats .= $insertDirCatId . ',';
                            }

                        $count = 0;
                        $commaSeperatedSubCats = '';
                         $count = $total = 0;
                        $successArr = $failureArr = [];

                            $catExistCheck = SubCategory::where('title', $importData[3])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new SubCategory();
                                $dirCat->title = $importData[3];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedSubCats .= $insertDirCatId . ',';
                            }

 			     $commaSeperatedSublevelCats = '';

                            $catExistCheck = SubCategoryLevel::where('title', $importData[4])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedSublevelCats .= $insertDirCatId . ',';
                            } else {
                                $dirCat = new SubCategoryLevel();
                                $dirCat->title = $importData[4];
                                $dirCat->slug = null;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedSublevelCats .= $insertDirCatId . ',';
                            }

                        if (!empty($importData[9])) {
                            // dd($importData[0]);
                            $titleArr = explode(',', $importData[9]);

                            // echo '<pre>';print_r($titleArr);exit();

                            foreach ($titleArr as $titleKey => $titleValue) {
                                // slug generate
                                $slug = Str::slug($titleValue, '-');
                                $slugExistCount = DB::table('blogs')->where('title', $titleValue)->count();
                                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);

                                $insertData = array(
                                    "title" => $titleValue,
                                    "content" => isset($importData[7]) ? $importData[7] : null,
                                    "meta_title" => isset($importData[8]) ? $importData[8] : null,
                                    "meta_key" => isset($importData[6]) ? $importData[6] : null,
                                    "blog_category_id" => isset($commaSeperatedCats) ? $commaSeperatedCats : null,
                                    "blog_sub_category_id" => isset($commaSeperatedSubCats) ? $commaSeperatedSubCats : null,
                                    "blog_tertiary_category_id" => isset($commaSeperatedSublevelCats) ? $commaSeperatedSublevelCats : null,
                                    "slug" => $slug,
                                    "meta_description" => isset($importData[8]) ? $importData[8] : null,

                                );

                                $resp =Blog::insertData($insertData, $count,$successArr,$failureArr);
                                $count = $resp['count'];
                                $successArr = $resp['successArr'];
                                $failureArr = $resp['failureArr'];
                                $total++;
                            }
                        }
                    }
                    //Session::flash('message', 'Import Successful.');
                        $store = new ActivityLogCsv;
                        $store->user_id =  Auth::guard('admin')->user()->id;
                        $store->csv_file_location = $location . "/" . $filename;
                        $store->total_rows = $total;
                        $store->success_count = $count;
                        $store->success_array = (count($resp['successArr']) > 0) ? json_encode($resp['successArr']) : '';
                        $store->failure_count = $total - $count;
                        $store->failure_array = (count($resp['failureArr']) > 0) ? json_encode($resp['failureArr']) : '';
                        $store->csv_type = 'article';
                        $store->save();
                    if($count==0){
                            FacadesSession::flash('csv', 'Already Uploaded. ');
                        }
                        else{
                             FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                        }
                } else {
                    FacadesSession::flash('message', 'File too large. File must be less than 50MB.');
                }
            } else {
                FacadesSession::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
            }
        } else {
            FacadesSession::flash('message', 'No file found.');
        }
        return redirect()->route('admin.blog.index');
    }
    // csv upload

    public function export()
    {
        return Excel::download(new BlogExport, 'blog.xlsx');
    }
}

