<?php

namespace Modules\ContactUsMassages\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUsMassage extends Model
{


    use SoftDeletes;
    protected $table = 'contact_us_massages';
    protected $guarded = [];
    protected $fillable = ['user_type','massage_type','from_id','from_email','from_name','to_id','to_email','to_name','massages'];




}
