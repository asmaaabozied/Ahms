<?php

namespace Modules\ContactUsMassages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ContactUsMassages\Entities\ContactUsMassage;

class ContactUsMassagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {


        $massages = ContactUsMassage::when($request->search, function ($q) use ($request) {


            return $q->where('massage_type', 'like', '%' . $request->search . '%')
                ->orWhere('user_type', 'like', '%' . $request->search . '%')
                ->orWhere('from_email', 'like', '%' . $request->search . '%')
                ->orWhere('from_name', 'like', '%' . $request->search . '%')
                ->orWhere('massages', 'like', '%' . $request->search . '%');
        })->latest()->paginate(Paginate_number);


        return view('contactusmassages::massages.index', compact('massages'));
    }


}
