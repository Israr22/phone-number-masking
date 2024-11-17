<?php

namespace App\Http\Controllers;

use App\Services\Twilio\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function assign()
    {
        $user = Auth::user();
        if(!is_null($user->twilio_number)) return back()->with('error', 'You already have a Twilio number.');

        // try{
            $phone = Number::create();
            $user->update(['twilio_phone' => $phone]);
            return back()->with('success', 'A phone number has been assigned to you.');
        // }catch (\Exception $exception){
        //     return back()->with('error', $exception->getMessage());
        // }
    }
}
