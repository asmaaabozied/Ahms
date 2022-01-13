<?php

namespace App\Http\Controllers\Dashboard;

use App\Sponser;
use Intervention\Image\Facades\Image;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Hash;

class SponserController extends Controller
{
    public function index(Request $request)
    {

       //abort_unless(\Gate::allows('read_categories'), 403);

        $sponsers =Sponser::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.sponsers.index', compact('sponsers'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_categories'), 403);

        return view('dashboard.sponsers.create');

    }//end of create

    public function store(Request $request)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('sponser_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('sponser_translations', 'description')]];

        }//end of for each

        $request->validate($rules);

       $sponser= Sponser::create($request->except(['_token','_method']));

        if($request->hasFile('image')) {
            $thumbnail = $request->file('image');
//            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $filename = $thumbnail->hashName();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $sponser->image = $filename;
            $sponser->save();
        }

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.sponsers.index');

    }//end of store

    public function edit($id)
    {
        $sponser=Sponser::find($id);

        return view('dashboard.sponsers.edit',compact('sponser'));

    }//end of edit

    public function update(Request $request, $id)
    {

        $sponser=Sponser::find($id);

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('sponser_translations', 'name')->ignore($sponser->id, 'sponser_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('sponser_translations', 'description')->ignore($sponser->id, 'sponser_id')]];


        }//end of for each

        $request->validate($rules);

        $sponser->update($request->all());

        if($request->hasFile('image')) {
            $thumbnail = $request->file('image');
//            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $filename = $thumbnail->hashName();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $sponser->image = $filename;
            $sponser->save();
        }


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.sponsers.index');

    }//end of update

    public function destroy($id )
    {

      //  abort_unless(\Gate::allows('category_delete'), 403);
     $sponser=Sponser::find($id);
        $sponser->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.sponsers.index');

    }//end of destroy



    public function change_status($id){

        $info= Sponser::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();


    }//end of change



}//end of controller
