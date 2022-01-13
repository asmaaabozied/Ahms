<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model
{


    public $timestamps = false;
    protected $fillable = ['name','description'];
}
