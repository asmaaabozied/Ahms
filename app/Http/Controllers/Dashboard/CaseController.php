<?php

namespace App\Http\Controllers\Dashboard;
use App\Lawer;
use App\Type;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

use App\Lawercase;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        //abort_unless(\Gate::allows('read_categories'), 403);

        $cases =Lawercase::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%')
                  ->orWhereTranslationLike('number', 'like', '%' . $request->search . '%');

        })->latest()->paginate(25);

        return view('dashboard.cases.index', compact('cases'));

    }//end of index

    public function create()
    {
      // abort_unless(\Gate::allows('create_categories'), 403);

        $users= User::where('name','!=','Super Admin')->pluck('name','id');

        return view('dashboard.cases.create',compact('users'));

    }//end of create

    public function store(Request $request)
    {

        $rules = [
//            'image'=>'required',
//            'number'=>'required',
//            'user_id'=>'required',
        ];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('lawercase_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('lawercase_translations', 'description')]];

        }//end of for each

        $request->validate($rules);

       $lawser= Lawercase::create($request->except(['_token','_method']));

        if($request->hasFile('icons')) {
            $thumbnail = $request->file('icons');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(300, 300)->save(public_path('/uploads/' . $filename));
            $lawser->icons = $filename;
            $lawser->save();
        }


        $title=$lawser->name;

        $content=$lawser->description;

        $user_id=$lawser->user->id;

        $notification=$lawser->user->notifications()->create([
            'title' =>$title,
            'content' =>$content,
            'type'=>'cases',

        ]);

        $user_id=$lawser->user->id;


        $user=User::where('id',$user_id)->get()->pluck('firebase_token');


        $createdat=$notification->created_at->diffForHumans(Carbon::now());
//        $tokens = $case->user->firebase_token;


//        $arrtoken = [$tokens];
        if(count($user))
        {
            $title = $title;
            $content = $content;
            $data =[
                'created_at' => $createdat,
                'user_name' => $lawser->user->name,
            ];
            $send = notifyByFirebase($title , $content , $user,$data);
            info("firebase result: " . $send);
        }


            session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.cases.index');

    }//end of store

    public function edit(Lawercase $case)
    {
        $users= User::where('name','!=','Super Admin')->pluck('name','id');

        return view('dashboard.cases.edit', compact('case','users'));

    }//end of edit

    public function update(Request $request, Lawercase $case)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('lawercase_translations', 'name')->ignore($case->id, 'lawercase_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('lawercase_translations', 'description')->ignore($case->id, 'lawercase_id')]];


        }//end of for each

        $request->validate($rules);

        $case->update($request->all());




        if($request->hasFile('icons')) {
            $thumbnail = $request->file('icons');
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(200, 200)->save(public_path('/uploads/' . $filename));
            $case->icons = $filename;
            $case->save();
        }

        $title=$case->name;

        $content=$case->description;

        $user_id=$case->user->id;

        $notification=$case->user->notifications()->create([
            'title' =>$title,
            'content' =>$content,
            'type'=>'cases',

        ]);

        $user_id=$case->user->id;


        $user=User::where('id',$user_id)->get()->pluck('firebase_token');


        $createdat=$notification->created_at->diffForHumans(Carbon::now());
//        $tokens = $case->user->firebase_token;


//        $arrtoken = [$tokens];
        if(count($user))
        {
            $title = $title;
            $content = $content;
            $data =[
                'created_at' => $createdat,
                'user_name' => $case->user->name,
            ];
            $send = notifyByFirebase($title , $content , $user,$data);
            info("firebase result: " . $send);
        }


        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.cases.index');

    }//end of update

    public function destroy(Lawercase $case)
    {
      //  abort_unless(\Gate::allows('category_delete'), 403);

        $case->delete();
        session()->flash('success', __('site.deleted_successfully'));

        return back();
//        return redirect()->route('dashboard.cases.index');

    }//end of destroy



    public function change_status($id){

        $info= Lawercase::find($id);
        $status=( $info->status == 0)?1:0;
        $info->status=$status;
        $info->save();
        session()->flash('success', __('site.updated_successfully'));
        return back();


    }//end of change

    public function detailscase($id){

       $user_id=Lawercase::find($id)->user_id;
       $user=User::find($user_id);
       $types=Type::where('lawercase_id',$id)->get();


        return view('dashboard.cases.detail', compact('types','user'));





    }

}//end of controller
