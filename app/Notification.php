<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use Sqits\UserStamps\Concerns\HasUserStamps;

class Notification extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;

    protected $guarded = [];
    public $translatedAttributes = ['title'];


    protected $hidden = [
       'created_by','updated_by','deleted_at','deleted_by','translations'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }//end of user


    public function type()
    {
        return $this->belongsTo(Typeconsultation::class, 'typeconslution_id')->where('status',1)->select('id');

    }//end of user
}
