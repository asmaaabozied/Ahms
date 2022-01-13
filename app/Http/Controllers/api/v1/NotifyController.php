<?php

namespace App\Http\Controllers\api\v1;

use App\Catogeryjob;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\NotificationResource;
use App\Image;
use App\Notification;
use App\Setting;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Modules\Geography\Entities\Geography;
use Validator;
use Carbon\Carbon;
use Lang;
use LaravelLocalization;
use App\User;
use DB;

use Modules\UserManagement\Entities\UserMetas;

use App\PasswordReset;
use function MongoDB\BSON\toJSON;


class NotifyController extends Controller
{



    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }


    public function shownotifications()
    {


      $user_id= Auth::id();


      $notifications=Notification::where('type','consulations')->where('user_id',$user_id)->with('type')->get();

////'created_at'=>$this->created_at->diffForHumans(Carbon::now()),
//        $notificationss= NotificationResource::collection($notifications);
        //     $notifications->created_at=$notifications->created_at->diffForHumans(Carbon::now());

        return response()->json(['status'=>200,'notifications'=>$notifications]);

//
//        $user_id= auth('api')->user()->id;
//
//        $consulation= Consultation::where('user_id',$user_id)->get();
//
////       $consulation=Consultation::select('id','details','status','created_at')->where('user_id',$user_id)->with('Typeconsultation')->get();
//
////        $consulations= ConsulationResource::collection($consulation);
//
//        return response()->json(['status'=>200,'consulations'=>$consulation]);

    }


}
