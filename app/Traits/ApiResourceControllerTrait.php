<?php

namespace App\Traits;

use App\Services\ControllerHelpers;
use App\Traits\ApiControllerHelpers;
use App\Traits\DynamicQueryTrait;
use Illuminate\Http\Request;

trait ApiResourceControllerTrait
{
    use DynamicQueryTrait, ApiControllerHelpers, ControllerHelpers;

    /**
     * @var \App\Repositories\Contracts\BaseRepository
     */
    protected $repository;

    /**
     * Returns a collection of models filtered, paginated
     * and sorted by the RequestCriteria
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->applyDynamicQueryCriteria($this->repository, $request->all());

        $paginate = $request->get('paginate') !== 'false';
        $perPage = $request->get('pagesize');

        $result = $this->repository->getMany(null, $paginate, $perPage);

        return $this->respondJson($result);
    }

    /**
     * Returns a single model given it's id
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function show($id, Request $request)
    {
        if ($request->all()) {
            $this->applyDynamicQueryCriteria($this->repository, $request->all());
        }

        $result = $this->repository->getById($id);

        return $this->respondJson($result);
    }

    /**
     * Persist a new model
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validateStore($request);

        $result = $this->repository->create($request->all());

        return $this->respondJson($result);
    }

    /**
     * Update a model
     *
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $this->validateUpdate($request);

        $result = $this->repository->updateById($id, $request->all());

        return $this->respondJson($result);
    }


    /**
     * Deletes a model
     *
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        if (strpos($id, ',')) {
            $id = explode(',', $id);
        }

        $result = $this->repository->destroyById($id);

        return $this->respondJson($result);
    }

}
