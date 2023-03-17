<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\BannerInterface;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    private BannerInterface $BannerRepository;

    public function __construct(BannerInterface $BannerRepository)
    {
        $this->BannerRepository = $BannerRepository;
    }
    /**
     * This method is for show brochure list
     *
     */
    public function index(Request $request)
    {
        $term = $request->term ? $request->term : '';

        $query = Banner::query();

        $query->when($term, function($query) use ($term) {
            $query->where('title', 'LIKE', '%' . $term . '%');
        });

        $data = $query->latest('id')->paginate(25);
        return view('admin.banner.index', compact('data', 'request'));
    }
	
	public function create(Request $request)
    {
        return view('admin.banner.create');
    }
    /**
     * This method is for create brochure
     *
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "title" => "required|string|max:255",
            "image" => "required|mimes:jpg,jpeg,png,svg,gif|max:10000000",
        ]);

        $newEntry = new Banner;
        $newEntry->title = $request->title;
        $updateEntry->is_current = $request->is_current;
        
        $upload_path = "public/uploads/schemes/";

        // image
        $image = $request->image;
        $imageName = mt_rand().time().".".$image->getClientOriginalExtension();
        $image->move($upload_path, $imageName);
        $newEntry->image = $upload_path.$imageName;

        $newEntry->save();

        if ($newEntry) {
            return redirect()->route('admin.banner.index')->with('success', 'Banner added successfully');
        } else {
            return redirect()->route('admin.banner.create')->withInput($request->all());
        }
    }
    /**
     * This method is for show brochure details
     * @param  $id
     *
     */
    public function show(Request $request, $id)
    {
        $data = $this->BannerRepository->listById($id);
        return view('admin.banner.detail', compact('data'));
    }
	 /**
     * This method is for brochure edit
     *
     *
     */
	 public function edit(Request $request, $id)
    {
        $data = $this->BannerRepository->listById($id);
        return view('admin.banner.edit', compact('data'));
    }
    /**
     * This method is for brochure update
     *
     *
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            "title" => "required|string|max:255",
            "image" => "nullable|mimes:jpg,jpeg,png,svg,gif|max:10000000",
        ]);

        $updateEntry = Banner::findOrFail($id);
        $updateEntry->title = $request->title;
        $updateEntry->is_current = $request->is_current;
       
 
        $upload_path = "public/uploads/schemes/";

        // image
        if (!empty($request->image)) {
            $image = $request->image;
            $imageName = mt_rand().time().".".$image->getClientOriginalExtension();
            $image->move($upload_path, $imageName);
            $updateEntry->image = $upload_path.$imageName;
        }
        $updateEntry->save();

        if ($updateEntry) {
            return redirect()->route('admin.banner.index')->with('success', 'Banner updated successfully');
        } else {
            return redirect()->route('admin.banner.edit', $id)->withInput($request->all());
        }
    }
    /**
     * This method is for update brochure status
     * @param  $id
     *
     */
    public function status(Request $request, $id)
    {
        $storeData = $this->BannerRepository->toggle($id);

        if ($storeData) {
            return redirect()->route('admin.banner.index');
        } else {
            return redirect()->route('admin.banner.create')->withInput($request->all());
        }
    }
    /**
     * This method is for brochure delete
     * @param  $id
     *
     */
    public function destroy(Request $request, $id)
    {
        $this->BannerRepository->delete($id);

        return redirect()->route('admin.banner.index');
    }


}
