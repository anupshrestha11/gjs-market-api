<?php

namespace Marvel\Http\Controllers;

use Marvel\Database\Repositories\GrapeVersionRepository;
use Marvel\Http\Requests\GrapeVersionRequest;
use Marvel\Http\Requests\GrapeVersionUpdateRequest;

class GrapeVersionController extends CoreController
{

    private $repository;

    /**
     * __construct
     *
     * @param  object $grapeVersionRepository
     * @return void
     */
    public function __construct(GrapeVersionRepository $grapeVersionRepository)
    {
        $this->repository = $grapeVersionRepository;
    }

    /**
     * return parent grape versions
     *
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function index()
    {
        return $this->repository->getParents();
    }

    /**
     * return grape version childs
     *
     * @param  integer $id
     * @return LengthAwarePaginator|JsonResponse|Collection|mixed
     */
    public function show($id)
    {
        return $this->repository->getGrapeVersionChilds($id);
    }


    /**
     * return created grape version
     *
     * @param  mixed $request
     * @return object|JsonResponse
     */
    public function store(GrapeVersionRequest $request)
    {
        return $this->repository->storeGrapeVersion($request);
    }


    /**
     * return updated grape version
     *
     * @param  mixed $request
     * @param  integer $id
     * @return object|JsonResponse
     */
    public function update(GrapeVersionUpdateRequest $request , $id)
    {
        return $this->repository->updateGrapeVersion($request , $id);
    }


    /**
     * destroy
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->repository->deleteGrapeVersion($id);
    }
}
