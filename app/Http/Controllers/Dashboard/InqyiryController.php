<?php

namespace App\Http\Controllers\Dashboard;



use App\Contact;
use App\Inquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InqyiryController extends Controller
{


    public function index(Request $request)
    {

       //abort_unless(\Gate::allows('read_jobs'), 403);

        $contacts = Inquiry::when($request->search, function ($q) use ($request) {

            return $q->where('description', '%' . $request->search . '%');

        })->latest()->paginate(25);

//        Contact::where('read_at', 0)->update(['read_at'=>1]);

        return view('dashboard.inquires.index', compact('contacts'));

    }//end of index

    public function change_status($id){


        $info= Contact::find($id);

        if($info->status==1){
            $info->status=0;
            $info->save();
            session()->flash('success', __('site.updated_successfully'));
            return back();
                 }else{
            return back();
           }

    }

    public function create()
    {
      // abort_unless(\Gate::allows('create_jobs'), 403);


    }//end of create



    public function store(Request $request)
    {




    }//end of store

    public function edit()
    {


    }//end of edit



    public function destroy($id)
    {

      //  abort_unless(\Gate::allows('job_delete'), 403);

         $contact=Inquiry::find($id);

        $contact->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.inquiress.index');

    }//end of destroy




}//end of controller
