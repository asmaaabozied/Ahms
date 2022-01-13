<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawercaseTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name','description','number'];

}//end of model
