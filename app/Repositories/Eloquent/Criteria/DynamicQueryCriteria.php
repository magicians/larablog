<?php namespace App\Repositories\Eloquent\Queries;

use Illuminate\Database\Eloquent\Builder;
use Williamoliveira\ArrayQueryBuilder\ArrayBuilder;
use Williamoliveira\Repository\Contracts\Criteria;

class DynamicQueryCriteria implements Criteria
{

    /**
     * @var array
     */
    protected $criteriaData;


    public function __construct(array $criteriaData)
    {
        $this->criteriaData = $criteriaData;
    }


    /**
     * Apply criteria in query repository
     *
     * @param $query
     * @return mixed
     */
    public function apply(Builder &$query)
    {
        return (new ArrayBuilder())->apply($query, $this->criteriaData);
    }

}