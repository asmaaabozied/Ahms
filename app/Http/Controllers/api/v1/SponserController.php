<?php

namespace App\Http\Controllers\api\v1;


use App\Http\Controllers\Controller;


use App\Http\Resources\SponserResource;
use App\Sponser;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Validator;
use Carbon\Carbon;
use Lang;
use LaravelLocalization;
use App\User;
use DB;
use Modules\UserManagement\Entities\UserMetas;

use App\PasswordReset;
use function MongoDB\BSON\toJSON;


class SponserController extends Controller
{



    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }


    public function listofsponsers()
    {
        $sponsers=Sponser::get();

        $listsponsers=SponserResource::collection($sponsers);

        return response()->json(['status'=>'200','sponsers'=>$listsponsers]);

    }


}
