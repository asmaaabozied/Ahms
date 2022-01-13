<?php

namespace App\Http\Controllers\Dashboard;

use App\Catogery;
use App\CatogeryTranslation;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;


class Subcatogery4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        $categories = Catogery::where('type','sub4')->latest()->paginate(25);

        return view('dashboard.catogerieslawer.sub4.index', compact('categories'));
    }

//    function str_random($length = 4)
//    {
//        return Str::random($length);
//    }
//
//    function str_slug($title, $separator = '-', $language = 'en')
//    {
//        return Str::slug($title, $separator, $language);
//    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        $catogeries=Catogery::where('type','!=','sub4')->get()->pluck('name','id');



        return view('dashboard.catogerieslawer.sub4.create',compact('catogeries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */

    function str_random($length = 4)
    {
        return Str::random($length);
    }

    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }

    public function store(Request $request)
    {
//        'file'=>'mimes:pdf',

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('catogery_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('catogery_translations', 'description')]];


        }//end of for each

        $request->validate($rules);
      $catogery= Catogery::create($request->all() + ['type'=>'sub4']);
//        if($request->file('file')) {
//            $images = $request->file('file');
//            $img = "";
//            $img = $this->str_random(4) . $images->getClientOriginalName();
//            $originname = time() . '.' . $images->getClientOriginalName();
//            $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
//            $extention = pathinfo($originname, PATHINFO_EXTENSION);
//            $img = $filename . '.' . $extention;
//
//            $destintion = 'uploads';
//            $images->move($destintion, $img);
//            $catogery->file = $img;
//            $catogery->save();
//
//            session()->flash('success', __('site.added_successfully'));
//            return redirect()->route('dashboard.typecases.index');
//        }




        if($request->file('file')) {

            $images = $request->file('file');

            $img = "";
            $img = $this->str_random(4) . $images->getClientOriginalName();
            $originname = time() . '.' . $images->getClientOriginalName();
            $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
            $extention = pathinfo($originname, PATHINFO_EXTENSION);
            $img = $filename . '.' . $extention;

            $destintion = 'uploads';
            $images->move($destintion, $img);
            $catogery->file = $img;
            $catogery->save();
        }
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.subcatogerieslawer4.index');





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

        $catogeries=Catogery::where('type','!=','sub4')->get()->pluck('name','id');



        return view('dashboard.catogerieslawer.sub4.edit',compact('category','catogeries'));
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

            $rules += [$locale . '.name' => ['required', Rule::unique('catogery_translations', 'name')->ignore($category->id, 'catogery_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('catogery_translations', 'name')->ignore($category->id, 'catogery_id')]];


        }//end of for each

        $request->validate($rules);

        $category->update($request->all());
//        if($request->hasFile('file')) {
//            $thumbnail = $request->file('file');
//            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
//            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
//            $category->file = $filename;
//            $category->save();
//        }

        if($request->file('file')) {

            $images = $request->file('file');

            $img = "";
            $img = $this->str_random(4) . $images->getClientOriginalName();
            $originname = time() . '.' . $images->getClientOriginalName();
            $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
            $extention = pathinfo($originname, PATHINFO_EXTENSION);
            $img = $filename . '.' . $extention;

            $destintion = 'uploads';
            $images->move($destintion, $img);
            $category->file = $img;
            $category->save();
        }
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.subcatogerieslawer4.index');
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
