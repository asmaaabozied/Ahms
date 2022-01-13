<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SponserTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name','description'];
}
