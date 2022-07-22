<?php

namespace Marvel\Database\Repositories;

use Exception;
use Marvel\Database\Models\GrapeVersion;
use Marvel\Exceptions\MarvelException;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Criteria\RequestCriteria;


class GrapeVersionRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'version'        => 'like',
        'parent',
        'slug',
    ];


    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
        }
    }


    /**
     * Configure the Model
     **/
    public function model()
    {
        return GrapeVersion::class;
    }

    /**
     *  return parent grape versions with children
     *
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function getGrapeVersions($request)
    {
        try {
            $parent = $request->parent;
            $limit = $request->limit ?   $request->limit : 15;

            if ($parent === 'null') {
                return static::where('parent_id', null)->with(['children', 'parent'])->paginate($limit);
            }
            return static::with(['parent', 'children'])->paginate($limit);
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }

    /**
     *  return parent grape versions
     *
     * @return LengthAwarePaginator|JsonResponse|Collection
     */
    public function getParents()
    {
        try {
            return static::where('parent_id', 0)->paginate(10);
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }


    /**
     *  return grape version children
     *
     * @param  integer $id
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function showGrapeVersion($id)
    {
        try {
            return static::with('children')->where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }


    /**
     * stores new grape version
     *
     * @return object|JsonResponse
     */
    public function storeGrapeVersion($request)
    {
        try {
            return static::create($request->all());
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }

    /**
     * updates  grape version
     *
     * @param  mixed $request
     * @param  integer $id
     * @return object|JsonResponse
     */
    public function updateGrapeVersion($request, $id)
    {
        try {
            $grapeVersion = static::find($id);
            $grapeVersion->update($request->all());
            return $grapeVersion;
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }


    /**
     * deleteGrapeVersion
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function deleteGrapeVersion($id)
    {
        try {
            static::find($id)->delete();
            return "Grape version deleted successfully";
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }
}
