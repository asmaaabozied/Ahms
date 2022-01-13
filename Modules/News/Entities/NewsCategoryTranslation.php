<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;

class NewsCategoryTranslation extends Model
{
    protected $table = 'news_category_translations';
    public $timestamps = false;
    protected $fillable =['title','news_category_id'];

}
