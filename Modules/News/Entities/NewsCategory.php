<?php

namespace Modules\News\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Entities\Scopes\ActiveScope;
use Sqits\UserStamps\Concerns\HasUserStamps;

class NewsCategory extends Model
{
    use Translatable;


    protected $table = 'news_categories';
    protected $guarded = [];
    protected $fillable = ['active','type'];
    public $translatedAttributes =['title'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope());

    }


    protected $with =['newsSubCategory'];

    public function newsSubCategory()
    {
        return $this->hasMany(NewsSubCategory::class, 'news_category_id');
    }



}
