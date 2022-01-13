<?php

namespace App\Http\Controllers\Dashboard;

use App\Videoconsultation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Hash;


class VideoconsultationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $consultations =Videoconsultation::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');


        })->latest()->paginate(Paginate_number);


        return view('dashboard.videos.index',compact('consultations'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        return view('dashboard.videos.create');
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

            $rules += [$locale . '.name' => ['required', Rule::unique('videoconsultation_translations', 'name')]];

        }//end of for each

        $request->validate($rules);

        $video= Videoconsultation::create($request->except(['_token','_method']));

//        if($request->hasFile('image')) {
//            $thumbnail = $request->file('image');
////            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
//            $filename = $thumbnail->hashName();
//            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/'.$filename));
//            $video->image = $filename;
//            $video->save();
//        }


        if($request->hasFile('image')) {
            $thumbnail = $request->file('image');
//            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $filename = $thumbnail->hashName();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $video->image = $filename;
            $video->save();
        }


        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.videoconsultations.index');


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
    public function edit(Videoconsultation $consultation ,$id)
    {

        $consultation=Videoconsultation::find($id);
//        view()->share('consultation', $consultation);
            return view('dashboard.videos.edit',compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Consultation $consultation
     * @return Response
     */
    public function update(Request $request,$id)
    {

        $consultation=Videoconsultation::find($id);

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('videoconsultation_translations', 'name')->ignore($consultation->id, 'videoconsultation_id')]];

        }//end of for each

//        $request->validate($rules);

        $consultation->find($id)->update($request->all());


        if($request->hasFile('image')) {
            $thumbnail = $request->file('image');
//            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $filename = $thumbnail->hashName();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $consultation->image = $filename;
            $consultation->save();
        }


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.videoconsultations.index');

    }

    /**
     * Remove the specified resource from storage.
     * @param Consultation $consultation
     * @return Response
     * @throws \Exception
     */
    public function destroy(Videoconsultation $consultation ,$id)
    {
        $consultation->find($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.videoconsultations.index');
    }
    public function statusConsultations(Request $request,$id)
    {
        $info= Videoconsultation::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();

    }

}
