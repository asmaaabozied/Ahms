<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\News\Entities\NewsCategory;
use Modules\News\Entities\NewsSubCategory;
use Modules\News\Http\Requests\NewsRequest;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = NewsCategory::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('title', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('news::categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('news::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {
        NewsCategory::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.news_categories.index');
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
    public function edit(NewsCategory $news_category)
    {
        return view('news::categories.edit',compact('news_category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param NewsCategory $news_category
     * @return Response
     */
    public function update(NewsRequest $request, NewsCategory $news_category)
    {
        $news_category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.news_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param NewsCategory $news_category
     * @return Response
     * @throws \Exception
     */
    public function destroy(NewsCategory $news_category)
    {
        $news_category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.news_categories.index');
    }
}
