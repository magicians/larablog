<?php

namespace App\Traits;


use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Queries\DynamicQuery;

trait DynamicQueryTrait
{
    /**
     * @param BaseRepository $repository
     * @param $requestData
     * @return mixed
     */
    protected function applyDynamicQueryCriteria(BaseRepository &$repository, array $requestData)
    {
        return $repository->applyCriteria(new DynamicQuery($requestData));
    }

}