<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Geography\Entities\Geography;
use Validator;
use Carbon\Carbon;
use Lang;

use LaravelLocalization;
use App\User;
use DB;
use Mail;
use Modules\UserManagement\Entities\UserMetas;

use App\PasswordReset;


class AuthController extends Controller
{


    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }


    function responseJson($status,$message,$data=null){

      $response=[

       'status'=>$status,

        'message'=>$message,

       'data'=>$data


   ];

    return response()->json($response);


}

     public function updateprofile(Request $request){

         $rule=[
             'email'    => 'max:254|email|required',
             'name'    => 'required|string',
             'phone' =>'required|min:9',
//             'address'=>'required|string',
//             'city_id'=>'required|integer',
             'image'=>'required',
//            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[!-\/:-@\[-`{-~]/',

         ];
         $customMessages = [
             'required' => __('validation.attributes.required'),
         ];

         $validator=validator()->make($request->all(),$rule,$customMessages);

         if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
             return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);

         }

         $user = User::findorfail(Auth::id());




        $user->image=asset('uploads/'.$request->image);
         $user->name = isset($request->name)?$request->name:$user->name;
         $user->email = isset($request->email)?$request->email:$user->email;
         $user->phone = isset($request->phone)?$request->phone:$user->phone;
//         $user->city_id = isset($request->city_id)?$request->city_id:'';
         $user->address = isset($request->address)?$request->address:$user->address;
//         $user->password = bcrypt($request->password);
         $user->remember_token = Str::random(60);



           $token =  $user->createToken('MyApp')->accessToken;

        $user->token=$token;
//         $user->city_name=isset($user->City->name) ?$user->City->name :'';
//         $countries = Geography::whereNull('parent_id')->get()->pluck('name','id');
//         $user->country_name=isset($user->City->name) ? $countries[$user->City->parent_id]:'';
         $user->save();


         if ($request->image) {
//             $pathInArr = explode('/', $request->image);
             \App\Image::updateOrCreate([
                 'imageable_type'=>'App/User',
//                 'image' =>$request->image
             ], [
                 'imageable_id' => $user->id,
                 'imageable_type'=>'App\User',
                 'image' =>$request->image,



             ]);
         }



         return $this->responseJson(200,__('site.messages.opertaion_success'),$user);



     }
     public function showprofile(){

        $user_id=Auth::id();
        $user=User::where('id',$user_id)->select('id','name','email','phone','address','created_at','updated_at','image')
            ->first();

//        return $user;

//         $detailuser= UserResource::collection($user);

//         $image= \App\Image::where('imageable_type','App\User')->where('imageable_id',$user_id)->select('image')->get();
//         $newImages = collect($image)->map(function ($imag) use($user)  {
//             return [
//                 'image' => asset('public/uploads/' . $imag['image']),
//                 'user'=>$user
//             ];
//         });
         return response()->json(['status'=>200,'user'=> $user]);


     }

     public function logout(){

         $user=Auth::user()->revoke();

         return $this->responseJson(200,__('site.messages.success'),$user);


     }


//    public function resetpassword(Request $request){
//
//        $rule=[
//            'email'    => 'max:254|email|required',
//        ];
//
//        $customMessages = [
//            'required' => __('validation.attributes.required'),
//        ];
//
//        $validator=validator()->make($request->all(),$rule,$customMessages);
//
//        if($validator->fails()){
//
////            return responseJson(1,$validator->errors()->first(),$validator->errors());
//            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);
//
//        }
//
//        $user = User::where('email',$request->email)->first();
//        if ($user){
//            $code = rand(111111,999999);
//            $update = $user->update(['code' => $code]);
//            if ($update)
//            {
//                // send email
//              //  Mail::send('emails.reset', ['code' => $code], function ($mail) use($user) {
//                 //   $mail->from('asmaaabozied907@gmail.com', 'تغير كلمه المرور');
//
//                   // $mail->to($user->email, $user->name)->subject('إعادة تعيين كلمة المرور');
//             //   });
//
//                return $this->responseJson(1,__('site.messages.checkemail'));
//            }else{
//                return $this->responseJson(0,_('site.messages.error'));
//            }
//        }else{
//            return $this->responseJson(0,__('site.messages.invalidemail'));
//        }
//
//
//    }

    public function changepassword(Request $request){

        $rule=[
            'token'    => 'required',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[!-\/:-@\[-`{-~]/',
            'c_password'=>'required_with:password|same:password',
        ];

        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator=validator()->make($request->all(),$rule,$customMessages);

        if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);
        }
        $passwordReset = PasswordReset::where('token',$request->token)->first();
         if($passwordReset){
       $user=User::where('email', $passwordReset->email)->first();
          if(!$user){
        return response()->json(['status' => 422,'message' => __('site.messages.user_emailInvalid')],422);
               }
             $user->password = bcrypt($request->password);
             $user->save();
             $passwordReset->delete();
             return response()->json(['status' => 200,'message' => __('site.messages.resetpassword')]);

         }else{
          return response()->json(['status' => 422,'message' => __('site.messages.user_tokenInvalid')],422);

          }


    }



    public function register(Request $request){

        $rule=[
            'email'    => 'max:254|unique:users|email|required',
            'name'    => 'required|string',
            'phone' =>'required|min:9|unique:users',
//            'address'=>'required|string',
//            'city_id'=>'required|integer',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[!-\/:-@\[-`{-~]/',
            'c_password'=>'required_with:password|same:password',
           'firebase_token'=>'required',

        ];
        $customMessages = [
            'required' => __('validation.attributes.required'),
        ];

        $validator=validator()->make($request->all(),$rule,$customMessages);

        if($validator->fails()){

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
            return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())],422);

        }

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
//            'city_id'=>isset($request->city_id) ? $request->city_id : 'null' ,
            'password'=>bcrypt($request->password),
           'firebase_token'=>$request->firebase_token,
            'remember_token'=>Str::random(60)
        ]);

       $image= \App\Image::create([
//            'imageable_id'=>$user->id,
            'imageable_type'=>'App/User',
            'image'=>'default.png'

            ]);

        $user->image=asset('uploads/'.$image->image);



        $user->save();

        $token =  $user->createToken('MyApp')->accessToken;


        $user->token=$token;
//        $user->city_name=isset($user->City->name) ?$user->City->name :'';
        $countries = Geography::whereNull('parent_id')->get()->pluck('name','id');
//        $user->country_name=isset($user->City->name) ? $countries[$user->City->parent_id]:'';
//        $user->country_id=isset($user->City->name) ? $countries[$user->City->id]:'';

//        $user->image=asset('public/uploads/'.$image->image);

        return $this->responseJson(200,__('site.messages.opertaion_success'),


           ['user'=>$user


        ]

            );
    }

   public function login(Request $request)
   {

       $rule = [
           'email' => 'email|required',
           'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[!-\/:-@\[-`{-~]/',
       ];

       $customMessages = [
           'required' => __('validation.attributes.required'),
       ];

       $validator = validator()->make($request->all(), $rule, $customMessages);

       if ($validator->fails()) {

//            return responseJson(1,$validator->errors()->first(),$validator->errors());
           return response()->json(['status' => 422, 'message' => validationErrorsToString($validator->errors())], 422);

       }

       $password = $request->password;
       $email = $request->email;

       if (Auth::attempt(['email' => $email, 'password' => $password])) {
           $user = Auth::user();
          $user->firebase_token=$request->firebase_token;


           $token = $user->createToken('MyApp')->accessToken;
           $user->city_name=isset($user->City->name) ?$user->City->name :'';
           $countries = Geography::whereNull('parent_id')->get()->pluck('name','id');
           $user->country_name=isset($user->City->name) ? $countries[$user->City->parent_id]:'';

           $user->token=$token;
           return $this->responseJson(200, __('site.messages.opertaion_success'), ['user' => $user]
           );


       }else{
           return response()->json(['status' => 422, 'message' =>__('site.messages.user_loginInvalid')],422);

       }

   }







}
