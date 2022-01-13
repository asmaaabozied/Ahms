<?php

namespace Modules\News\Http\Controllers;

use App\Libraries\Fcm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;
use Modules\News\Entities\NewsCategory;
use Modules\News\Entities\NewsSubCategory;
use Modules\News\Http\Requests\NewsListRequest;
use Modules\News\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\File;
class SubNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $new_subcategory = NewsSubCategory::
//        where('news_category_id',$request->cat_id) ->

           when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('title', '%' . $request->search . '%');

        })->latest()->paginate(25);
        view()->share('new_subcategory', $new_subcategory);
        view()->share('news_category_id', $request->cat_id);
//        return back();

//        return $new_subcategory;

        return view('news::subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create($cat_id)
    {
        $category=NewsCategory::find($cat_id);

        return view('news::subcategories.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(NewsListRequest $request)
    {
//        Fcm::sendToOne("kljaslkdjalksd",['title'=>"ajksdlka",'body'=>"jlasdajsdkla"]);
        $attributes=$request->all();


        if ($request->hasFile('main_image')) {

            $path=public_path(news_images);
            if (!file_exists($path)) {File::makeDirectory($path, 0777, true, true);}
            $attributes['main_image']->store(news_images ,'public');
            $attributes['main_image']=    $attributes['main_image']->hashName();
        }


//        if($request->hasFile('main_image')) {
//            $thumbnail = $request->file('main_image');
////            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
//            $filename = $thumbnail->hashName();
//            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
//            $attributes->main_image = $filename;
//            $attributes->save();
//        }


        if ($request->hasFile('images_slider')) {
            $path=public_path(news_images);
            if (!file_exists($path)) {File::makeDirectory($path, 0777, true, true);}

            $image_array= [];
            foreach ($attributes['images_slider'] as $value) {
                $value->store(news_images,'public');

                $image_array[]= $value->hashName();
            }
            $attributes['images_slider']=json_encode($image_array);


        }
      NewsSubCategory::create($attributes);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.news_categories.show',$attributes['news_category_id'] );
    }


    /**
     * Show the form for editing the specified resource.
     * @param NewsSubCategory $news_subcategory
     * @return Response
     */
    public function edit(NewsSubCategory $news_subcategory)
    { $category=NewsCategory::find($news_subcategory->news_category_id);
        return view('news::subcategories.edit',compact('news_subcategory','category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param NewsSubCategory $news_subcategory
     * @return Response
     */
    public function update(Request $request, NewsSubCategory $news_subcategory)
    {
        $attributes=$request->all();
        if ($request->hasFile('main_image')) {

            $path=public_path(news_images);
            if (!file_exists($path)) {File::makeDirectory($path, 0777, true, true);}
            $attributes['main_image']->store(news_images ,'public');
            $attributes['main_image']=    $attributes['main_image']->hashName();
        }
        if ($request->hasFile('images_slider')) {
            $path=public_path(news_images);
            if (!file_exists($path)) {File::makeDirectory($path, 0777, true, true);}

            $image_array= [];
            foreach ($attributes['images_slider'] as $value) {
                $value->store(news_images,'public');

                $image_array[]= $value->hashName();
            }
            $attributes['images_slider']=json_encode($image_array);


        }
        $news_subcategory->update($attributes);
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.news_categories.show',$attributes['news_category_id'] );
    }

    /**
     * Remove the specified resource from storage.
     * @param NewsCategory $news_category
     * @return Response
     * @throws \Exception
     */
    public function destroy(NewsSubCategory $news_subcategory)
    {
        $news_subcategory->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.news_categories.show',$news_subcategory->news_category_id );
    }
}
