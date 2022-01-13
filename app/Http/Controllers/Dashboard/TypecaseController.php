<?php

namespace App\Http\Controllers\Dashboard;

use App\Cases;

use App\Lawercase;
use App\Type;
use App\Typecases;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class TypecaseController extends Controller
{
    public function index(Request $request)
    {

       //abort_unless(\Gate::allows('read_categories'), 403);

        $cases = Type::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.typecases.index', compact('cases'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_categories'), 403);

        $cases=Lawercase::get()->pluck('name','id');

        return view('dashboard.typecases.create',compact('cases'));

    }//end of create
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


//        dd($request->file('images'));

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('type_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('type_translations', 'description')]];

        }//end of for each

        $request->validate($rules);

      $type= Type::create($request->except(['_token','_method','images']));



        //      //  if ($request->file) {

        if($request->hasFile('images')) {
            $imagess = $request->file('images');

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
                $image = new \App\Image();
                $image->image = $img;
                $image->imageable_id = $type->id;
                $image->imageable_type ='App\Type';
                $image->save();

            }
        }



        session()->flash('success', __('site.added_successfully'));
                  return redirect()->route('dashboard.typecases.index');

    }//end of store

    public function edit(Type $type , $id)
    {
           // error here ?
          $type=Type::find($id);
          $cases=Lawercase::get()->pluck('name','id');

//     $cases= \App\Lawercase::where('deleted_at','null')->pluck('name','id');

        return view('dashboard.typecases.edit', compact('type','cases'));

    }//end of edit

    public function update(Request $request, $id )
    {
        $type=Type::find($id);

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('type_translations', 'name')->ignore($type->id, 'type_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('type_translations', 'description')->ignore($type->id, 'type_id')]];
        }//end of for each

        $request->validate($rules);

        $type->update($request->except(['_token','_method','images']));



        if($request->hasFile('images')) {
            $imagess = $request->file('images');

            \App\Image::where('imageable_id',$type->id)->where('imageable_type','App\Type')->delete();

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
                $image = new \App\Image();
                $image->image = $img;
                $image->imageable_id = $type->id;
                $image->imageable_type ='App\Type';
                $image->save();

            }
        }



        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.typecases.index');

    }//end of update

    public function destroy($id)
    {
      //  abort_unless(\Gate::allows('type_delete'), 403);
        $type=Type::find($id);

        $type->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.typecases.index');

    }//end of destroy

    public function change_status($id){

        $info= Type::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();


    }


}//end of controller
