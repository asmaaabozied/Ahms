<?php

namespace App\Http\Controllers\Dashboard;
use App\Mail\MailMessage;
use Carbon\Carbon;
use App\Consultation;
use App\Lawercase;
use App\Type;
use App\Typeconsultation;
use App\User;
//use App\Image;
use App\Videoconsultation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ConsultationRequest extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $consultations =Consultation::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%')
               ->orWhere('details', '%' . $request->search . '%')
                ->orWhere('status', '%' . $request->search . '%');

        })->latest()->paginate(Paginate_number);


        return view('dashboard.consultations.index',compact('consultations'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $users= User::where('name','!=','Super Admin')->pluck('name','id');

        $types=Typeconsultation::get()->pluck('name','id');

        $videos=Videoconsultation::get()->pluck('name','id');

        return view('dashboard.consultations.create',compact('users','types','videos'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */


//    function str_random($length = 4)
//    {
//        return Str::random($length);
//    }
//
//    function str_slug($title, $separator = '-', $language = 'en')
//    {
//        return Str::slug($title, $separator, $language);
//    }


    public function store(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('consultation_translations', 'name')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('consultation_translations', 'description')]];
            $rules += [$locale . '.price' => ['required', Rule::unique('consultation_translations', 'price')]];

        }//end of for each

        $request->validate($rules);

        $consulation= Consultation::create($request->except(['_token','_method']));


        $title=$consulation->Typeconsultation->name;

        $content=$consulation->details;

        $user=$consulation->user->notifications;

        $notification=$consulation->user->notifications()->create([
            'title' =>$title,
            'content' =>$content,
            'type'=>'consulations',
            'typeconslution_id'=>$consulation->Typeconsultation->id,

        ]);

        $user_id=$consulation->user->id;

        $user=User::where('id',$user_id)->get()->pluck('firebase_token');


        $createdat=$notification->created_at->diffForHumans(Carbon::now());
        $tokens = $consulation->user->firebase_token;


//        $arrtoken = [$tokens];
        if(count($user))
        {
            $title = $title;
            $content = $content;
            $data =[
                'created_at' => $createdat,
                'user_name' => $consulation->user->name,
            ];
            $send = notifyByFirebase($title , $content , $user,$data);
            info("firebase result: " . $send);
        }

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.consultations.index');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $consulations=Consultation::find($id);

       $images=\App\Image::where('imageable_type','App\Consultation')->where('imageable_id',$id)->get();

        return view('dashboard.consultations.show',compact('consulations','images'));



    }

    public function downloadFile($id){

        $file = \App\Image::find($id);
        $pathToFile = public_path() . '/uploads/' . $file->image;
        return response()->download($pathToFile, $file->image);

    }

    /**
     * Show the form for editing the specified resource.
     * @param Consultation $consultation
     * @return Response
     */
    public function edit(Consultation $consultation)
    {
        $email=$consultation->user->email;


        $data=$consultation;


    Mail::to($email)->send( new MailMessage($data));

        session()->flash('success', __('site.email_successfully'));

        return redirect()->route('dashboard.consultations.index');

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Consultation $consultation
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $consultation=Consultation::find($id);

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('consultation_translations', 'name')->ignore($consultation->id, 'consultation_id')]];
            $rules += [$locale . '.description' => ['required', Rule::unique('consultation_translations', 'description')->ignore($consultation->id, 'consultation_id')]];
            $rules += [$locale . '.price' => ['required', Rule::unique('consultation_translations', 'price')->ignore($consultation->id, 'consultation_id')]];



        }//end of for each

        $request->validate($rules);


           $attributes=$request->all();


        $consultation->update($attributes);


        $title=$consultation->Typeconsultation->name;

       $content=$consultation->details;

        $user=$consultation->user->notifications;

       $notification=$consultation->user->notifications()->create([
                       'title' =>$title,
                      'content' =>$content,
                      'type'=>'consulations',
            'typeconslution_id'=>$consultation->Typeconsultation->id,

       ]);

       $user_id=$consultation->user->id;

       $user=User::where('id',$user_id)->get()->pluck('firebase_token');


        $createdat=$notification->created_at->diffForHumans(Carbon::now());
       $tokens = $consultation->user->firebase_token;


//        $arrtoken = [$tokens];
        if(count($user))
        {
            $title = $title;
            $content = $content;
            $data =[
                'created_at' => $createdat,
                'user_name' => $consultation->user->name,
            ];
            $send = notifyByFirebase($title , $content , $user,$data);
            info("firebase result: " . $send);
        }

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.consultations.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param Consultation $consultation
     * @return Response
     * @throws \Exception
     */
    public function destroy( $id)
    {
        Consultation::find($id)->delete();
        session()->flash('success', __('site.deleted_successfully'));

        return back();
//        return redirect()->route('dashboard.consultations.index');
    }
    public function statusConsultations(Request $request)
    {
        $info = Consultation::find($request->id);


        if ($info->status == "finished") {
            $info->status = "waiting";
        } elseif ($info->status == "waiting") {
            $info->status = "reply";

            $typeconslution_id = $info->Typeconsultation->id;
            $title = $info->Typeconsultation->name;

            $content=$info->details;

            $contents="تم قبول طلبك و سيقوم أحد مستشارينا بالتواصل معك في أقرب وقت";


            $user=$info->user->notifications;

            $notification=$info->user->notifications()->create([
                'title' =>$title,
                'content' =>$content,
                'type'=>'consulations',
                'typeconslution_id'=>$typeconslution_id

            ]);

            $user_id=$info->user->id;

            $user=User::where('id',$user_id)->get()->pluck('firebase_token');


            $createdat=$notification->created_at->diffForHumans(Carbon::now());

            $tokens = $info->user->firebase_token;


//        $arrtoken = [$tokens];
            if(count($user))
            {
                $title = $title;
                $contents = $contents;
                $data =[
                    'created_at' => $createdat,
                    'user_name' => $info->user->name,
                ];
                $send = notifyByFirebase($title , $contents , $user,$data);
                info("firebase result: " . $send);
            }


        }



        elseif ($info->status == "reply") {
            $info->status = "finished";

}


            //  $info->save();
            session()->flash('success', __('site.updated_successfully'));
            return back();


    }

    public function detailsuser($id){

        $user_id=Consultation::find($id)->user_id;
        $user=User::find($user_id);

        return view('dashboard.consultations.detail', compact('user'));


    }

}
