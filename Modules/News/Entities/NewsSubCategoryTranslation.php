<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;

class NewsSubCategoryTranslation extends Model
{
    protected $table = 'news_subcategory_translations';
    public $timestamps = false;
    protected $fillable =['title','content','news_sub_category_id'];

}
