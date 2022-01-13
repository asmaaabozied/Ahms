<?php

namespace App;

use App\User;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sqits\UserStamps\Concerns\HasUserStamps;

class Consultation extends Model
{
    use Translatable;
    use HasUserStamps;
    use SoftDeletes;
    protected $guarded = [];
    public $translatedAttributes = ['name','description','price'];


    public $with=['Typeconsultation'];

    protected $hidden = [
      'created_by','updated_by','updated_at','deleted_at','deleted_by','payment_type'
    ];
    protected $appends = ['image_path'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','name','phone','email');

    }
    public function Typeconsultation()
    {
        return $this->belongsTo(Typeconsultation::class, 'typeconslution_id');

    }
    public function videoconsultation()
    {
        return $this->belongsTo(Videoconsultation::class, 'videoconslution_id');

    }
    public function images(){

        return $this->morphMany(Image::class,'imageable');

    }

    public function getImagePathAttribute()
    {
        return (!empty(optional($this->images()->first())->image))?asset('uploads/' . optional($this->images()->first())->image):'';
//        return asset('public/uploads/'. $this->image);

    }//end of get image path





//    public function subCat(){
//
//        return $this->hasMany(Catogery::class,'parent_id')->select('id' , 'type','parent_id');
//    }
}
