<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Traits\ApiResourceControllerTrait;
use App\Repositories\Eloquent\PostRepository;

class PostController extends Controller
{
    
    use ApiResourceControllerTrait;


    /**
     * PurchaseController constructor.
     * @param ClientRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }
}
