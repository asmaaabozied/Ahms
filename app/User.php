<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;
use Modules\Geography\Entities\Geography;
use Sqits\UserStamps\Concerns\HasUserStamps;
use App\Notifications\MailResetPasswordToken;
// use Modules\



class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, Notifiable;
    use HasUserStamps;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone','password', 'type','status','verification_code','address','city_id','code','firebase_token'
    ];

    protected $appends = ['image_path'];

    public $with=['city'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    protected $hidden = [
        'password', 'remember_token','verification_code' ,'phone_verified_at','created_by','updated_by','updated_at','deleted_at','deleted_by','email_verified_at'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime','email_verified_at' => 'phone_verified_at',
    ];

//    public function sendPasswordResetNotification($token)
//    {
//       $resetToken=PasswordReset::where('email',$this->email)->first()->token;
//
//        $this->notify(new ResetPasswordNotification($resetToken));
//    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function getImagePathAttribute()
    {
        return (!empty(optional($this->images()->first())->image))?asset('uploads/' . optional($this->images()->first())->image):'';
//        return asset('public/uploads/'. $this->image);

    }//end of get image path

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');

    }//end of roles

    public function lawercases()
    {
        return $this->hasMany(Lawercase::class, 'user_id');

    }//end of cases

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'user_id');

    }//end of cases

    public function consulations()
    {
        return $this->hasMany(Consultation::class, 'user_id');

    }//end of consulations

    public function userMetas()
    {
        return $this->belongsToMany(UserMetas::class, 'user_id');

    }//end of userMetas


    public function City()
    {
        return $this->belongsTo(Geography::class, 'city_id')->where('parent_id','!=','null');

    }//end of userMetas


    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');

    }//end of notifications

}//end of model
