<?php

namespace App\Http\Controllers\API;

use App\Repositories\Contracts\PostRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Traits\ApiResourceControllerTrait;

class PostController extends Controller
{
    
    use ApiResourceControllerTrait;


    /**
     * PurchaseController constructor.
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }
}
