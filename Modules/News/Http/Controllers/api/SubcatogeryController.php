<?php

namespace Modules\News\Http\Controllers\api;

use App\Http\Resources\NewResource;
use App\Http\Resources\VideomediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\News\Entities\NewsCategory;
use Modules\News\Entities\NewsSubCategory;
use Modules\News\Http\Requests\NewsRequest;

use Lang;
use LaravelLocalization;

class SubcatogeryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */

    public function __construct()
    {
        $local=(!empty(Request()->route()))?(Request()->route()->parameters()['locale']): 'en';
        LaravelLocalization::setLocale($local);
    }


    public function listofnews(Request $request){

        $catogery=NewsCategory::where('type',$request->type)->select('id')->first();

       $subcatogery=NewsSubCategory::where('news_category_id', $catogery->id)->get();

       if($request->type=='video'){

           $catogeries= VideomediaResource::collection($subcatogery);

           return response()->json(['status'=>200,'media'=> $catogeries]);


       }elseif($request->type=='news'){

           $catogeries= NewResource::collection($subcatogery);

           return response()->json(['status'=>200,'news'=> $catogeries]);


       }elseif($request->type=='articles'){


           $catogeries= NewResource::collection($subcatogery);

           return response()->json(['status'=>200,'articles'=> $catogeries]);

       }








    }


    public function detailsnews(Request $request){



        $detailssub=NewsSubCategory::where('id',$request->subcategoery_id)->get();

        $catogeries= NewResource::collection($detailssub);

        return response()->json(['status'=>200,'detailsnew'=> $catogeries]);




    }







}
