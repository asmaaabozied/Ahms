<?php

namespace Modules\News\Entities;

use App\Image;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Entities\Scopes\ActiveScope;
use Sqits\UserStamps\Concerns\HasUserStamps;

class NewsSubCategory extends Model
{
    use Translatable;


    protected $table = 'news_subcategories';
//    protected $guarded = [];
    protected $fillable = ['active','main_image','images_slider','video_link','source_url','news_category_id'];
    public $translatedAttributes =['title','content'];

    protected $appends = ['image_path'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope());

    }

    public function images(){

        return $this->morphMany(Image::class,'imageable');

    }


    public function getImagePathAttribute()
    {
        return asset('uploads/'. $this->main_image);

    }//end of get image path

}
