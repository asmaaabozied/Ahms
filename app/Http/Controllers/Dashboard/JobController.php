<?php

namespace App\Http\Controllers\Dashboard;

use App\Catogeryjob;
use App\Image;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobController extends Controller
{


    public function index(Request $request)
    {
       //abort_unless(\Gate::allows('read_jobs'), 403);

        $jobs = Job::when($request->search, function ($q) use ($request) {

            return $q->where('name', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.jobs.index', compact('jobs'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_jobs'), 403);
       $users= User::where('name','!=','Super Admin')->pluck('name','id');
        $catogeries=Catogeryjob::get()->pluck('name','id');

        return view('dashboard.jobs.create',compact('users','catogeries'));

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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string',
            'phone' => 'required|string',
            'images' => 'required',
//            'job'  => 'required|string',
            'user_id'=>'required',
            'description' =>'required|string'
        ]);

        $jobs=Job::create($request->except(['_token','_method']));


        if($request->file('images')) {

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
                $image = new Image();
                $image->image = $img;
                $image->imageable_id = $jobs->id;
                $image->imageable_type ='App\Job';
                $image->save();

            }
        }




        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.jobs.index');

    }//end of store

    public function edit(Job $job)
    {
        $users= User::where('name','!=','Super Admin')->pluck('name','id');
        $catogeries=Catogeryjob::get()->pluck('name','id');
        return view('dashboard.jobs.edit', compact('job','users','catogeries'));

    }//end of edit

    public function update(Request $request, Job $job)
    {

        $job->update($request->all());



        if($request->file('images')) {


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
                $image = new Image();
                $image->image = $img;
                $image->imageable_id = $job->id;
                $image->imageable_type ='App\Job';
                $image->save();

            }
        }


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.jobs.index');

    }//end of update

    public function destroy(Job $job)
    {
      //  abort_unless(\Gate::allows('job_delete'), 403);
        Image::where('imageable_id',$job->id)->delete();

        $job->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.jobs.index');

    }//end of destroy


    public function change_status($id){

        $info= Job::find($id);

        if($info->status==1){
            $info->status=0;
            $info->save();
            session()->flash('success', __('site.updated_successfully'));
            return back();
        }else{
            return back();

        }


    }

}//end of controller
