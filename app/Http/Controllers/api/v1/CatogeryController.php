<?php

namespace App\Http\Controllers\api\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\ParentcatogeryResource;
use App\Http\Resources\SubcatogeryResource;
use Illuminate\Http\Response;

use App\Http\Resources\CatogeryResource;
use App\Catogery;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use Lang;
use LaravelLocalization;
use App\User;
use DB;


class CatogeryController extends Controller
{



    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }
//    public function listofcatogery(Request $request){
//
//        $data=$request->json()->all();
//        if(isset($data['name']) and !empty($data['name'])){
////            DB::enableQueryLog(); // Enable query log
//            $catogery=Catogery::where('parent_id',null)->whereTranslationLike('name',"%".$data['name']."%")
////            ->whereTranslationLike('name', 'LIKE', "%{$request->name}%")
//                ->get();

// Your Eloquent query executed by using get()

    //dd(DB::getQueryLog()); // Show results of log



    public function listofcatogery(Request $request){



        if(isset($request->name) and !empty($request->name)){

            $catogery=Catogery::where('parent_id',null)->whereTranslationLike('name',"%".$request->name."%") ->get();

        }else{
//            subcatogeries
//            $catogeries=Catogery::where('parent_id',null)->get();
//
//    if(isset($catogeries->parent_id)==null){
//    return " parent";
//
//    }else{
//
//    return " no parent";
//    }




            $catogery=Catogery::select('id' , 'type','parent_id','icons')->where('type','sub0')->get();


        }
       // $catogeries= CatogeryResource::collection($catogery);

        return response()->json(['status'=>200,'categories'=>$catogery]);
    }



     public function subcatogery(Request $request){

//         $catogery=Catogery::select('id' , 'type','parent_id')->where('parent_id',$request->id)->get();

//         $catogery=Catogery::where('parent_id',$request->id)->where('type','sub1')->get();

//        $cat=Catogery::where('id',$request->id)->get();
//
//         $parent= ParentcatogeryResource::collection($cat);
//
//
//         $catogeries= SubcatogeryResource::collection($catogery);

         $catogery=Catogery::where('parent_id',$request->id)->get();

         //  return $catogery;


         $parent= ParentcatogeryResource::collection($catogery);

//
//         $catogeries= SubcatogeryResource::collection($catogery);

         return response()->json(['status'=>200,'subcategories'=>$parent]);



              }

     public function differentiationprinciples(Request $request){

         $catogery=Catogery::where('parent_id',$request->id)->where('type','sub2')->get();

         $catogeries= SubcatogeryResource::collection($catogery);

         return response()->json(['status'=>200,'subcategories'=>$catogeries]);


            }

      public function commercial(Request $request){

          $catogery=Catogery::where('parent_id',$request->id)->where('type','sub3')->get();

          $catogeries= SubcatogeryResource::collection($catogery);

          $cat=Catogery::where('id',$request->id)->get();

          $parent= ParentcatogeryResource::collection($cat);

          return response()->json(['status'=>'200','parent'=>$parent,'subcategories'=>$catogeries]);


              }
      public function principleofgeneral(Request $request){

          $catogery=Catogery::where('parent_id',$request->id)->where('type','sub4')->get();

           $catogeries= SubcatogeryResource::collection($catogery);

           $cat=Catogery::where('id',$request->id)->get();

             $parent= ParentcatogeryResource::collection($cat);

             return response()->json(['status'=>'200','parent'=>$parent,'subcategories'=>$catogeries]);

              }



}
