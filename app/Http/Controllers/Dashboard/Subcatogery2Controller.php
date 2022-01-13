<?php

namespace App\Http\Controllers\Dashboard;

use App\Catogery;
use App\CatogeryTranslation;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;


class Subcatogery2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {


        $subcatogery=Catogery::where('type','sub1')->get()->pluck('name','id');

        $categories = Catogery::where('type','sub2')->when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.catogerieslawer.sub2.index', compact('categories','subcatogery'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $catogeries=Catogery::where('type','sub1')->get()->pluck('name','id');

//        $lastcatogeries=Catogery::where('type','sub4')->get()->pluck('name','id');

        return view('dashboard.catogerieslawer.sub2.create',compact('catogeries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required']];

        }//end of for each



        $request->validate($rules);

      $catogery= Catogery::create($request->all() + ['type'=>'sub2']);


            session()->flash('success', __('site.added_successfully'));



            return redirect()->route('dashboard.subcatogerieslawer2.index');



    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $category=Catogery::find($id);

//        $lastcatogeries=Catogery::where('type','sub4')->get()->pluck('name','id');

        $catogeries=Catogery::where('type','sub1')->get()->pluck('name','id');

        return view('dashboard.catogerieslawer.sub2.edit',compact('category','catogeries'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $category=Catogery::find($id);
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required']];

        }//end of for each

        $request->validate($rules);


        $category->update($request->all());


        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.subcatogerieslawer2.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
       Catogery::find($id)->delete();
       return back();
    }
}
