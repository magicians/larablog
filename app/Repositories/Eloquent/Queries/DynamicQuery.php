<?php namespace App\Repositories\Eloquent\Queries;

use App\Repositories\Contracts\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Williamoliveira\ArrayQueryBuilder\ArrayBuilder;

class DynamicQuery implements Criteria
{

    /**
     * @var array
     */
    protected $criteria;


    public function __construct(array $criteria)
    {
        $this->criteria = $criteria;
    }


    /**
     * Apply criteria in query repository
     *
     * @param $query
     * @return mixed
     */
    public function apply(Builder &$query)
    {
        return (new ArrayBuilder())->apply($query, $this->criteria);
    }

}