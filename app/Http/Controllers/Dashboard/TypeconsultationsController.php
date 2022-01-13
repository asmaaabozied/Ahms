<?php

namespace App\Http\Controllers\Dashboard;

use App\Typeconsultation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;


class TypeconsultationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $consultations =Typeconsultation::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');


        })->latest()->paginate(Paginate_number);


        return view('dashboard.types.index',compact('consultations'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('dashboard.types.create');
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

            $rules += [$locale . '.name' => ['required', Rule::unique('typeconsultation_translations', 'name')]];

        }//end of for each

        $request->validate($rules);

        $types= Typeconsultation::create($request->except(['_token','_method']));

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.typeconsultations.index');


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
     * @param Consultation $consultation
     * @return Response
     */
    public function edit(Typeconsultation $consultation ,$id)
    {

        $consultation=Typeconsultation::find($id);
//        view()->share('consultation', $consultation);
        return view('dashboard.types.edit',compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Consultation $consultation
     * @return Response
     */
    public function update(Request $request, Typeconsultation $consultation,$id)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('typeconsultation_translations', 'name')->ignore($consultation->id, 'typeconsultation_id')]];

        }//end of for each

        $request->validate($rules);

        $consultation->find($id)->update($request->all());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.typeconsultations.index');

    }

    /**
     * Remove the specified resource from storage.
     * @param Consultation $consultation
     * @return Response
     * @throws \Exception
     */
    public function destroy(Typeconsultation $consultation ,$id)
    {
        $consultation->find($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.typeconsultations.index');
    }
    public function statusConsultations(Request $request,$id)
    {
        $info= Typeconsultation::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();

    }

}
