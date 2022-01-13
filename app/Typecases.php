<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sqits\UserStamps\Concerns\HasUserStamps;

class Typecases extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;

//    protected $table="typecases";

    protected $fillable = ['lawercase_id'];
    public $translatedAttributes = ['name','description'];
}
