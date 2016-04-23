<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    
    protected $fillable = ['title','description','content','author_id','category_id'];


    public function image()
    {
        return $this->morphOne(Image::class, 'attachable');
    }
}
