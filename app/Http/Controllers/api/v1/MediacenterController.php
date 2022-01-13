<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\newResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VideomediaResource;
use App\Image;
use App\Mediacenter;
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


class MediacenterController extends Controller
{



    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }

    public function mediacenter_news(Request $request){
        $rule=[
            'type' =>'required',
        ];

        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator=validator()->make($request->all(),$rule,$customMessages);

        if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);

        }

       $newmedia=Mediacenter::where('type',$request->type)->get();

        $newsmedia= UserResource::collection($newmedia);

        return response()->json(['status' => 1,'message' =>__('site.messages.opertaion_success'),'data'=> $newsmedia ]);
    }

    public function mediacenter_article(Request $request){
        $rule=[
            'type' =>'required',
        ];
        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator=validator()->make($request->all(),$rule,$customMessages);

        if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);

        }
        $newmedia=Mediacenter::where('type',$request->type)->get();

        $newsmedia= UserResource::collection($newmedia);

        return response()->json(['status' => 1,'message' =>__('site.messages.opertaion_success'),'data'=> $newsmedia ]);

    }


    public function mediacenter_video(Request $request){
        $rule=[
            'type' =>'required',
        ];
        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator=validator()->make($request->all(),$rule,$customMessages);

        if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);

        }
        $newmedia=Mediacenter::where('type',$request->type)->get();

        $newsmedia= VideomediaResource::collection($newmedia);

        return response()->json(['status' => 1,'message' =>__('site.messages.opertaion_success'),'data'=> $newsmedia ]);

    }

    public function details_mediacenter(Request $request){

        $newmedia=Mediacenter::where('id',$request->id)->get();

        $newsmedia= newResource::collection($newmedia);

        return response()->json(['status' => 1,'message' =>__('site.messages.opertaion_success'),'data'=> $newsmedia ]);

    }


}
