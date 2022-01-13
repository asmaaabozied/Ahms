<?php

namespace Modules\ContactUsMassages\Http\Controllers\api\v1;
use App\User;
use Illuminate\Routing\Controller;
use Modules\ContactUsMassages\Entities\ContactUsMassage;
use Modules\Pages\Entities\Page;
use Illuminate\Http\Request;

class ContactUsMassagesController extends Controller
{
    public function sendMassage(Request $request)
    {

        $attributes = $request->all();
        $users = User::where('type', '=', 'SuperAdmin')->first();
        $attributes['to_id'] = $users->id;
        $attributes['to_email'] = $users->email;
        $attributes['to_name'] = $users->name;
        $stadium = ContactUsMassage::create($attributes);

        return response()->json(['status' => 200, 'data' => [
            'massage' => __('site.added_successfully')]]);
    }
}
