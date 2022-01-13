<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{

    protected $table = 'Inquiries';
    public $timestamps = true;
    protected $fillable = array('description', 'lawercase_id', 'user_id');


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }//end of userMetas

    public function lawercase()
    {
        return $this->belongsTo(Lawercase::class, 'lawercase_id');

    }//end of userMetas

}
