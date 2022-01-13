<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $fillable = ['user_id','name','phone','email','job','description','catogeryjob_id'];


   protected $appends = ['image_path'];

    public function images(){

        return $this->morphMany(Image::class,'imageable');

    }

    public function catogeryjob(){

        return $this->belongsTo(Catogeryjob::class, 'catogeryjob_id');
    }//end of cases

    public function getImagePathAttribute()
    {
        return (!empty(optional($this->images()->first())->image))?asset('uploads/' . optional($this->images()->first())->image):'';
//        return asset('public/uploads/'. $this->image);

    }//end of get image path

}
