<?php

namespace App\Http\Controllers\Dashboard;


use App\Catogery;
use App\Catogeryjob;
use Intervention\Image\Facades\Image;

use App\Lawercase;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CatogeryjobController extends Controller
{
    public function index(Request $request)
    {

       //abort_unless(\Gate::allows('read_categories'), 403);

        $jobs =Catogeryjob::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.jobs.catogeries.index', compact('jobs'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_categories'), 403);

        return view('dashboard.jobs.catogeries.create');

    }//end of create

    public function store(Request $request)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('catogeryjob_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('catogeryjob_translations', 'description')]];

        }//end of for each

        $request->validate($rules);

       $catogery= Catogeryjob::create($request->except(['_token','_method']));


            session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.catogeryjobs.index');

    }//end of store

    public function edit($id)
    {
          $catogery=Catogeryjob::find($id);

        return view('dashboard.jobs.catogeries.edit',compact('catogery'));

    }//end of edit

    public function update(Request $request, Catogeryjob $catogery)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('catogeryjob_translations', 'name')->ignore($catogery->id, 'catogeryjob_id ')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('catogeryjob_translations', 'description')->ignore($catogery->id, 'catogeryjob_id ')]];

        }//end of for each

        $request->validate($rules);

        $catogery->update($request->all());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.catogeryjobs.index');

    }//end of update

    public function destroy($id )
    {

      //  abort_unless(\Gate::allows('category_delete'), 403);
     $catogery=Catogeryjob::find($id);
        $catogery->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.catogeryjobs.index');

    }//end of destroy



    public function change_status($id){

        $info= Catogeryjob::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();


    }//end of change



}//end of controller
