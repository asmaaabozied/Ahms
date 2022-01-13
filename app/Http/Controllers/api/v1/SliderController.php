<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Validator;

use Lang;
use LaravelLocalization;
use App\User;
use DB;
use Modules\UserManagement\Entities\UserMetas;
use App\PasswordReset;
use Mail;


class SliderController extends Controller
{


    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }


    public function slider(Request $request){

   $slider=Slider::get();

   if($slider){

       return response()->json(['status' => 1, 'message' => 'success','data'=>$slider]);
   }




    }



}