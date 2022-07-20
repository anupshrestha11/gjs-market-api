<?php

namespace Marvel\Database\Repositories;

use Exception;
use Marvel\Database\Models\GrapeVersion;
use Marvel\Exceptions\MarvelException;

class GrapeVersionRepository extends BaseRepository
{
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
            if ($parent === 'null') {
                return $this->model()::where('parent_id', null)->with(['children', 'parent'])->paginate(10);
            }
            return $this->model()::with(['parent', 'children'])->paginate(10);
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
            return $this->model()::where('parent_id', 0)->paginate(10);
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
            return $this->model()::with('children')->where('id', $id)->firstOrFail();
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
            return $this->model()::create($request->all());
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
            $grapeVersion = $this->model()::find($id);
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
            $this->model()::find($id)->delete();
            return "Grape version deleted successfully";
        } catch (Exception $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG);
        }
    }
}
