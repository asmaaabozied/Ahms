<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Sqits\UserStamps\Concerns\HasUserStamps;


class Type extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;


    protected $guarded = [];
    public $translatedAttributes = ['name','description'];

//    public function lawercase(){
//
//        $this->belongsTo('','lawercase_id');
//    }

    public function lawercase(){

        return $this->belongsTo(Lawercase::class, 'lawercase_id');
    }//end of cases



    public function images(){

        return $this->morphMany(Image::class,'imageable');

    }




}
