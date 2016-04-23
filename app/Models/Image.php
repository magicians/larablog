<?php

namespace App\Models;

use Intervention\Image\Image as InterventionImage;
use Williamoliveira\Attachable\Models\AttachableImage;

/**
 * App\Models\Image
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $file_name
 * @property string $file_extension
 * @property integer $file_size
 * @property string $mime_type
 * @property boolean $use_intervention_image
 * @property integer $attachable_id
 * @property string $attachable_type
 * @property-read mixed $url
 * @property-read mixed $url_thumbnail
 * @property-write mixed $file
 * @property-write mixed $filename
 * @property-read mixed $path
 * @property-read mixed $basename
 * @property string $model
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attachable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereFileExtension($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereMimeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereUseInterventionImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereModel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereAttachableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Image whereAttachableType($value)
 * @mixin \Eloquent
 */
class Image extends AttachableImage
{
    public $imagesPath = 'images/{id}/{filename}--{template}.{extension}';

    public $disk = 'local_public';

    protected $defaultTemplate = 'thumbnail';

    protected $appends = ['url', 'url_thumbnail'];

    protected $visible = ['url', 'url_thumbnail'];

    public function getUrlAttribute()
    {
        return $this->url('normal');
    }

    public function getUrlThumbnailAttribute()
    {
        return $this->url('thumbnail');
    }

    public function imageTemplates()
    {
        return [
            'original' => function (InterventionImage $image){
                return $image;
            },
            'normal' => function (InterventionImage $image){
                return $image->resize(800, 600);
            },
            'thumbnail' => function (InterventionImage $image){
                return $image->fit(100, 100);
            }
        ];
    }
}
