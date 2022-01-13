<?php

namespace App\Http\Controllers\Dashboard;

use App\Catogery;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;


class CatogeryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

//        $lastcatogeries=Catogery::where('type','sub4')->get()->pluck('name','id');


        $categories = Catogery::where('type','sub0')->latest()->paginate(25);

        return view('dashboard.catogerieslawer.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

//        $lastcatogeries=Catogery::where('type','sub4')->get()->pluck('name','id');

        return view('dashboard.catogerieslawer.create');
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

      $catogery= Catogery::create($request->except(['_token','_method'])+ ['type'=>'sub0']);

        if($request->hasFile('icons')) {
            $thumbnail = $request->file('icons');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $catogery->icons = $filename;
            $catogery->save();
        }


//dd($request->except(['_token','_method','icons']));

            session()->flash('success', __('site.added_successfully'));



            return redirect()->route('dashboard.catogerieslawer.index');



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

        return view('dashboard.catogerieslawer.edit',compact('category'));
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

        if($request->hasFile('icons')) {
            $thumbnail = $request->file('icons');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $category->icons = $filename;
            $category->save();
        }


        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.catogerieslawer.index');
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
