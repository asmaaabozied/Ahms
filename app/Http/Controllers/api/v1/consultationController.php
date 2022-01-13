<?php

namespace App\Http\Controllers\api\v1;

use App\Consultation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsulationResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\ListconsulationResource;
use App\Http\Resources\TypeconsulationResource;
use App\Http\Resources\VideoconsulationResource;
use App\Image;
use App\Job;
use App\Mail\MailConsulation;
use App\Mail\MailMessage;
use App\Typeconsultation;
use App\Videoconsultation;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Carbon\Carbon;
use Lang;
use LaravelLocalization;
use App\User;
use DB;
use Hash;

use Modules\UserManagement\Entities\UserMetas;

use App\PasswordReset;
use Illuminate\Support\Str;


class consultationController extends Controller
{
    public function __construct()
    {
        $local = (!empty(Request()->route())) ? (Request()->route()->parameters()['locale']) : 'en';
        LaravelLocalization::setLocale($local);
    }
    public function Requestconsultation(Request $request){

        $rule = [
            'typeconslution_id' => 'required|integer',
//            'videoconslution_id' => 'required|nullable|integer',
            'details' => 'required|string|min:12',

//            'images'=>'required',
        ];
        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator = validator()->make($request->all(), $rule, $customMessages);

        if ($validator->fails()) {

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())], 422);

        }

        $consulation=Consultation::create([
            'typeconslution_id' =>$request->typeconslution_id,
            'videoconslution_id' =>isset($request->videoconslution_id) ?$request->videoconslution_id :'email',
            'details' =>$request->details,
            'user_id'=>auth('api')->user()->id

        ]);


        foreach ($request->images as $image) {
            Image::updateOrCreate([
                'imageable_type'=>'App/Consultation',
                'image'=>$image
            ], [
                'imageable_id' => $consulation->id,
                'imageable_type'=>'App\Consultation',
            ]);
        }


        $data='يوجد طلب استشاره جديد برجاء الاطلاع عليه';
        Mail::to('asmaaabozied907@gmail.com')->send( new MailConsulation($data));



     return response()->json(['status' => 200, 'message' => __('site.messages.opertaion_success'), 'Consultation' => $consulation]);


    }

    public function detailconsulting(){

       $user_id= auth('api')->user()->id;

        $consulation= Consultation::where('user_id',$user_id)->get();

//       $consulation=Consultation::select('id','details','status','created_at')->where('user_id',$user_id)->with('Typeconsultation')->get();

//        $consulations= ConsulationResource::collection($consulation);

        return response()->json(['status'=>200,'consulations'=>$consulation]);

    }

    public function videoconsultations(){


        $videoconsultations=Videoconsultation::where('status',1)->get();

        $videoconsulations= VideoconsulationResource::collection($videoconsultations);

        return response()->json(['status'=>200,'Onlineconsulting'=>$videoconsulations]);

    }

    public function typeconsultations(){

    $types=Typeconsultation::where('status',1)->get();

    $typeconsulations=TypeconsulationResource::collection($types);

    return response()->json(['status'=>200,'typesconsulations'=>$typeconsulations]);

    }


    public function listofconsultations(){


        $consulations=Consultation::where('status','finished')->get();

        $listconsulations=ListconsulationResource::collection($consulations);

        return response()->json(['status'=>200,'Consulations'=>$listconsulations]);
    }







}
