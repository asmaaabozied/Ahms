<?php

namespace Modules\News\Http\Controllers;

use App\Lawercase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Modules\News\Entities\NewsCategory;
use Modules\News\Entities\NewsSubCategory;
use Modules\News\Http\Requests\NewsRequest;

class NewssController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $catogery_ids=NewsCategory::where('type','news')->get()->pluck('id');
        foreach ($catogery_ids as $catogery_id){

            $new_subcategory = NewsSubCategory::where('news_category_id',$catogery_id)->when($request->search, function ($q) use ($request) {

                return $q->whereTranslationLike('title', '%' . $request->search . '%');

            })->latest()->paginate(25);

        }





        return view('news::categories.news.index',compact('new_subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $catogery_ids=NewsCategory::where('type','news')->get()->pluck('id');


        return view('news::categories.news.create',compact('catogery_ids'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
//           'image'=>'required',

        ];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.title' => ['required', Rule::unique('news_subcategory_translations', 'title')]];
            $rules += [$locale . '.content' => ['required', Rule::unique('news_subcategory_translations', 'content')]];

        }//end of for each

        $request->validate($rules);

        $newsubcatogery= NewsSubCategory::create($request->except(['_token','_method']));

        if($request->hasFile('main_image')) {
            $thumbnail = $request->file('main_image');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $newsubcatogery->main_image = $filename;
            $newsubcatogery->save();
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.newss_subcategories.index');
    }

    /**
     * Show the specified resource.
     * @param NewsCategory $news_category
     * @return Response
     */
    public function show(NewsCategory $news_category)
    {

        $new_subcategory = NewsSubCategory::where('news_category_id',$news_category->id)->latest()->paginate(25);
        return view('news::subcategories.index',compact('new_subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param NewsCategory $news_category
     * @return Response
     */
    public function edit($id)
    {
      $news_subcategory=NewsSubCategory::find($id);
        $catogery_ids=NewsCategory::where('type','news')->get()->pluck('id');

        return view('news::categories.news.edit',compact('news_subcategory','catogery_ids'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param NewsCategory $news_category
     * @return Response
     */
    public function update(Request $request ,$id)
    {
        $news=NewsSubCategory::find($id);

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.title' => ['required', Rule::unique('news_subcategory_translations', 'title')->ignore($news->id, 'news_sub_category_id')]];
            $rules += [$locale . '.content' => ['required', Rule::unique('news_subcategory_translations', 'content')->ignore($news->id, 'news_sub_category_id')]];


        }//end of for each

        $request->validate($rules);

        $news->update($request->all());



        if($request->hasFile('main_image')) {
            $thumbnail = $request->file('main_image');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $news->main_image = $filename;
            $news->save();
        }

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.newss_subcategories.index');

    }

    /**
     * Remove the specified resource from storage.
     * @param NewsCategory $news_category
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $news_category=NewsSubCategory::find($id);
        $news_category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.newss_subcategories.index');

    }
}
