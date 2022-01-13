<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConditionTranslation extends Model
{

    public $timestamps = false;
    public $translatedAttributes = ['title','description'];
}
