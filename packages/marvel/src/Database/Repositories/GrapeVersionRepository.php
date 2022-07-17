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
     *  return parent grape versions with childs
     *
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function getGrapeVersions()
    {
        try {
            return $this->model()::where('parent_id', 0)->with('childs')->paginate(10);
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
     *  return grape version childs
     *
     * @param  integer $id
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function getGrapeVersionChilds($id)
    {
        try {
            return $this->model()::find($id)->childs()->paginate(10);
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
