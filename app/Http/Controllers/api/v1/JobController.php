<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Image;
use App\Job;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
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


class JobController extends Controller
{


    public function __construct()
    {
        $local = (!empty(Request()->route())) ? (Request()->route()->parameters()['locale']) : 'en';
        LaravelLocalization::setLocale($local);
    }

    function str_random($length = 4)
    {
        return Str::random($length);
    }

    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }

    public function uploadimages(Request $request)
    {
        $rule = [
            'type' => 'required|string',
            'images' => 'required'
        ];

        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator = validator()->make($request->all(), $rule, $customMessages);

        if ($validator->fails()) {

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())], 422);

        }


//         $image=Image::create([ 'imageable_type'=>'App\User' ]);

            if ($request->file('images')) {

                $imagess = $request->file('images');
                $imagesArr = [];
                foreach ($imagess as $images) {
                    $img = "";
                    $img = $this->str_random(4) . $images->getClientOriginalName();
                    $originname = time() . '.' . $images->getClientOriginalName();
                    $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
                    $filename = $images->hashName();
                    $extention = pathinfo($originname, PATHINFO_EXTENSION);
                    $img = $filename;

                    $destintion = 'uploads';
                    $images->move($destintion, $img);



//                    App\User
                    $imagesArr[] = [
                        'image' => $img,
                    'imageable_type' =>'App/'. $request->type
                    ];


                Image::insert($imagesArr);

        }
//       $image=Image::create([ 'imageable_type'=>$request->type ]);



//            $newImages = collect($imagesArr)->map(function ($image) use ($request){
//                return [
//                    'image' => asset('public/uploads/' . $image['image']),
//                    'type' => $request->type
//                ];
//            });

          return response()->json(['status' => 200, 'images' => $imagesArr]);


        }
    }

    public function createjobs(Request $request)
    {

        $rule = [
//            'email' => 'required',
           'email'    => 'max:254|email|required',
            'phone' => 'required|min:9',
            'name' => 'required',
            'catogeryjob_id' => 'required|integer',
            'description' => 'required|string',
//            'user_id'=>'required',
            'images' => 'required'
        ];

        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator = validator()->make($request->all(), $rule, $customMessages);

        if ($validator->fails()) {

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())], 422);

        }

        if (isset(auth('api')->user()->id) and !empty(auth('api')->user()->id)) {
            $jobs = Job::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'catogeryjob_id' => $request->catogeryjob_id,
                'description' => $request->description,
                'user_id' => auth('api')->user()->id,
            ]);

        } else {
            $jobs = Job::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'job' => $request->job,
                'description' => $request->description,
            ]);
        }
        foreach ($request->images as $image) {
//            $pathInArr = explode('/', $image);
            Image::updateOrCreate([
                'imageable_type'=>'App/Job',
//                'image' => end($pathInArr)
                   'image'=>$image
            ], [
                'imageable_id' => $jobs->id,
                'imageable_type'=>'App\Job',

            ]);
        }


//      //  if ($request->file) {
//              if($request->file('images')){
//
//            $imagess = $request->file('images');
//
//            foreach ($imagess as $images) {
//                $img = "";
//                $img = $this->str_random(4) . $images->getClientOriginalName();
//                $originname = time() . '.' . $images->getClientOriginalName();
//                $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
//                $extention = pathinfo($originname, PATHINFO_EXTENSION);
//                $img = $filename . '.' . $extention;
//
//
//                $destintion = 'uploads';
//                $images->move($destintion, $img);
//                $image = new Image();
//                $image->image = $img;
//                $image->imageable_id = $jobs->id;
//                $image->imageable_type=0;
//                $image->save();
//
//            }

        return response()->json(['status' => 200, 'message' => __('site.messages.opertaion_success'), 'job' => $jobs
        ]);


    }
}
