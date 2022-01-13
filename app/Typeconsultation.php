<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sqits\UserStamps\Concerns\HasUserStamps;

class Typeconsultation extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;
    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $hidden = [
        'created_by','updated_by','updated_at','deleted_at','deleted_by'
    ];

    public function consulations()
    {
        return $this->hasMany(Consultation::class, 'typeconslution_id');

    }//end of consulations

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'typeconslution_id');

    }//end of notifications

}
