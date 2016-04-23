<?php namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository as PostRepositoryContract;

class PostRepository extends BaseRepository implements PostRepositoryContract
{

    protected $modelClass = Post::class;

}