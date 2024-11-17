<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class WebHookController extends Controller
{
    public function voice(Request $request)
    {
        $response = new VoiceResponse();

        // Find a user by searching for their Twilio number
        $user = User::where('twilio_phone', '=', $request->To)->first();

        if(is_null($user)){
            return response(['message' => 'No number found'], 400);
        }
        // Call user's real phone number
        $response->dial($user->phone);

        // Robotic voice say goodbye
        $response->say('Goodbye.');

        // Return XML
        return response($response->asXML())->header('Content-Type', 'text/xml');

    }

    public function sms(Request $request)
    {
        $response = new VoiceResponse();

        // Find a user by searching for their Twilio number
        $user = User::where('twilio_phone', '=', $request->To)->first();

        if(is_null($user)){
            return response(['message' => 'No number found'], 400);
        }

        // Send text message to real user #
        $response->sms($request->Body, [
            'to' => $user->phone
        ]);

        // Return XML
        return response($response->asXML())->header('Content-Type', 'text/xml');
    }
}
