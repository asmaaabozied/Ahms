<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Sqits\UserStamps\Concerns\HasUserStamps;

class Catogery extends Model
{
      use Translatable;
      use HasUserStamps;
      use SoftDeletes;

       protected $guarded = [];
    public $translatedAttributes = ['name','description'];


    protected $appends = ['icon_path'];

    public $with=['subCat'];

    public function subCat(){

        return $this->hasMany(Catogery::class,'parent_id')->select('id' , 'type','parent_id');
    }


    protected $hidden = [
        'translations'
    ];


    public function getIconPathAttribute()
    {
//        return (!empty(optional($this->images()->first())->image))?asset('public/uploads/' . optional($this->images()->first())->image):'';
        return asset('uploads/'. $this->icons);

    }//end of get image path

//    public function getIconsAttribute()
//    {
//        return asset('public/uploads' . $this->icons);
//
//    }//end of get image path



}//end of model
