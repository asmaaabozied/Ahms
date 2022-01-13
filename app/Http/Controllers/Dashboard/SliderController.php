<?php

namespace App\Http\Controllers\Dashboard;

use App\Cases;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{
    public function index(Request $request)
    {


       //abort_unless(\Gate::allows('read_categories'), 403);

        $sliders = Slider::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('image', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.sliders.index', compact('sliders'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_categories'), 403);

        return view('dashboard.sliders.create');

    }//end of create

    public function store(Request $request)
    {

        $rules = [];
        $request->validate($rules);

        Cases::create($request->except(['_token','_method']));
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.cases.index');

    }//end of store

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));

    }//end of edit

    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')]];

        }//end of for each

        $request->validate($rules);

        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of update

    public function destroy(Category $category)
    {
      //  abort_unless(\Gate::allows('category_delete'), 403);

        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of destroy

}//end of controller
