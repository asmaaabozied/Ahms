<?php

namespace App;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sqits\UserStamps\Concerns\HasUserStamps;

class Videoconsultation extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;
    protected $fillable = ['image'];
    public $translatedAttributes = ['name'];

    public function consulations()
    {
        return $this->hasMany(Consultation::class, 'videoconslution_id');

    }//end of consulations
}
