<?php

namespace App\Http\Controllers\Dashboard;


use App\Condition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ConditionController extends Controller
{
    public function index(Request $request)
    {


       //abort_unless(\Gate::allows('read_categories'), 403);

        $condition =Condition::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('title', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.conditions.index', compact('condition'));

    }//end of index

    public function create()
    {


    }//end of create

    public function store(Request $request)
    {


    }//end of store

    public function edit($id)
    {
        $condition=Condition::find($id);


        return view('dashboard.conditions.edit', compact('condition'));

    }//end of edit

    public function update(Request $request, Condition $condition)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.title' => ['required', Rule::unique('condition_translations', 'title')->ignore($condition->id, 'condition_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('condition_translations', 'description')->ignore($condition->id, 'condition_id')]];


        }//end of for each

        $request->validate($rules);

        $condition->update($request->all());


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.conditions.index');

    }//end of update




}//end of controller
