<?php
namespace App\Repositories;

use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use App\Contracts\AboutContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class AboutRepository
 *
 * @package \App\Repositories
 */
class AboutRepository extends BaseRepository implements AboutContract
{
    use UploadAble;

    /**
     * AboutRepository constructor.
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function listaboutus(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->model->where('key', 'about_us')->get();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findaboutById(int $id)
    {
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }


    /**
     * @param array $params
     * @return mixed
     */
    public function updateabout(array $params)
    {
        $about = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');

        $about->pretty_name = $collection['pretty_name'];
        $about->content = $collection['content'];
        $about->content1 = $collection['content1'];
        $about->content2 = $collection['content2'];
        $image = $collection['image'];
        $imageName = time().".".$image->getClientOriginalName();
        $image->move("Aboutus/",$imageName);
        $uploadedImage = $imageName;
        $about->image = $uploadedImage;

        $banner_image = $collection['banner_image'];
        $imageName = time().".".$banner_image->getClientOriginalName();
        $banner_image->move("AboutusBanner/",$imageName);
        $uploadedImage = $imageName;
        $about->banner_image = $uploadedImage;
        $about->save();

        return $about;
    }

    /**
     * @param $id
     * @return bool|mixed
     */
    public function deleteabout($id)
    {
        $about = $this->findOneOrFail($id);
        $about->delete();
        return $about;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function updateaboutStatus(array $params){
        $about = $this->findOneOrFail($params['id']);
        $collection = collect($params)->except('_token');
        $about->status = $collection['check_status'];
        $about->save();

        return $about;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detailsabout($id)
    {
        $about = Setting::where('id',$id)->get();

        return $about;
    }
}
