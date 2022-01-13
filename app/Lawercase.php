<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Sqits\UserStamps\Concerns\HasUserStamps;

class Lawercase extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;


    protected $guarded = [];
    public $translatedAttributes = ['name', 'description', 'number'];


    public function types(){

        return $this->hasMany(Type::class, 'lawercase_id');
    }//end of types

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }//end of user


    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'user_id');

    }//end of inquiries


    public function images(){

        return $this->morphMany(Image::class,'imageable');

    }//end of images

}
