<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * This method is for show category list
     *
     */
    public function index(Request $request)
    {
        if (!empty($request->term)) {

            $data = $this->categoryRepository->getSearchCategory($request->term);

        } else {
            $data = $this->categoryRepository->getCategories();
           
        }
        return view('admin.category.index', compact('data','request'));
    }
	 public function create(Request $request)
     {
        
        return view('admin.category.create');
    }
    /**
     * This method is for create category
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "image" => "required|mimes:jpg,jpeg,png,svg,gif|max:10000000"
        ]);

        // generate slug
        $slug = Str::slug($request->name, '-');
        $slugExistCount = Category::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);

        // $params = $request->only(['name', 'description', 'image_path', 'slug']);
        $params = $request->except('_token');

        $categoryStore = $this->categoryRepository->createCategory($params);

        if ($categoryStore) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
    }
	/**
     * This method is for edit category details
     * @param  $id
     *
     */
	public function edit(Request $request, $id)
    {
        $data = $this->categoryRepository->getCategoryById($id);
        return view('admin.category.edit', compact('data'));
    }
    /**
     * This method is for show category details
     * @param  $id
     *
     */
    public function show(Request $request, $id)
    {
        $data = $this->categoryRepository->getCategoryById($id);
        return view('admin.category.detail', compact('data'));
    }
    /**
     * This method is for category update
     * @param  $id
     *
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "icon_path" => "nullable|mimes:jpg,jpeg,png,svg,gif|max:10000000"
        ]);

        // generate slug
        $slug = Str::slug($request->name, '-');
        $slugExistCount = Category::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);

        // send slug
        request()->merge(['slug' => $slug]);

        $params = $request->except('_token');

        $categoryStore = $this->categoryRepository->updateCategory($id, $params);

        if ($categoryStore) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
    }
    /**
     * This method is for update category status
     * @param  $id
     *
     */
    public function status(Request $request, $id)
    {
        $categoryStat = $this->categoryRepository->toggleStatus($id);

        if ($categoryStat) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
    }
    /**
     * This method is for category delete
     * @param  $id
     *
     */
    public function destroy(Request $request, $id)
    {
        $this->categoryRepository->deleteCategory($id);

        return redirect()->route('admin.category.index');
    }

    public function exportCSV(request $request)
    {
        if (!empty($request->term)) {

            $data = $this->categoryRepository->getSearchCategory($request->term);

        } else {
            $data = $this->categoryRepository->getCategories();
           
        }

        if (count($data) > 0) {
            $delimiter = ",";
            $filename = "category-".date('Y-m-d').".csv";

            // Create a file pointer
            $f = fopen('php://memory', 'w');

            // Set column headers
            $fields = array('SR','Name','Description','Status', 'Datetime');
            fputcsv($f, $fields, $delimiter);

            $count = 1;

            foreach($data as $row) {
                $datetime = date('j F, Y h:i A', strtotime($row['created_at']));
                $lineData = array(
                    $count,
                    $row['name'],
                    $row['description'],
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
