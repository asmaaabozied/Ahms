<?php

namespace App\Http\Controllers\api\v1;

use App\Cases;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\LawercaseResource;
use App\Http\Resources\TypecaseResource;
use App\Image;
use App\Inquiry;
use App\Job;
use App\Lawer;
use App\Lawercase;
use App\Type;
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


class LawercaseController extends Controller
{



    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }

    public function listofcases(){

          $user_id=auth('api')->user()->id;
//         $username=auth('api')->user()->name;
//         $image=Image::where('imageable_type','App\User')->where('imageable_id',$user_id)->select('image')->get();
//        $user= ImageResource::collection($image);


//        'id'     =>auth('api')->user()->id,
//            'username'=>auth('api')->user()->name,
//            'image'   => asset('public/uploads/'. $this->image),
//             'id'     =>auth('api')->user()->id,
//            'username'=>auth('api')->user()->name,
//            'image'   => asset('public/uploads/'. $this->image),
        $user=User::where('id',$user_id)->select('id','name','image')->first();
        $cases =Lawercase::where('user_id',$user_id)->get();
        $lawercases= LawercaseResource::collection($cases);

        return response()->json(['status'=>200,'user'=>$user,'cases'=>$lawercases]);

    }

    public function detailscases(Request $request){

//     return response()->download(public_path('asmaa.gif'),'asmaa');


        $cases=Lawercase::where('id',$request->lawercase_id)->get();

        $lawercases= LawercaseResource::collection($cases);


        $typecases=Type::where('lawercase_id',$request->lawercase_id)->get();

        $types= TypecaseResource::collection($typecases);


        return response()->json(['status'=>200,

            'case'=>$lawercases,
            'typescases'=>$types

        ]);

    }


    public function create_inquiry(Request $request ){

       $user_id=Auth::id();

        $rule = [
            'lawercase_id' => 'required|integer',
            'description' => 'required|string|min:12',


        ];
        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator = validator()->make($request->all(), $rule, $customMessages);

        if ($validator->fails()) {

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())], 422);

        }


       $inquiry=Inquiry::create([

           'user_id'=>$user_id,
           'lawercase_id'=>$request->lawercase_id,
           'description' => $request->description,

       ]);


        return response()->json(['status' => 200, 'message' => __('site.messages.opertaion_success'), 'Inquiry' => $inquiry
        ]);



    }



}
