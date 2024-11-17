<?php

namespace App\Services\Twilio;

use Twilio\Rest\Client;

class Number
{
    /** @var Client */
    public static $client;

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public static function setClient()
    {
        info(config('services.twilio.sid'));
        info(config('services.twilio.token'));
        info('credentials');
        self::$client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    /**
     * @return string
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public static function create()
    {
        self::setClient();
        info( self::$client );

        // List of Numbers
        $numbers = self::$client->availablePhoneNumbers('US')->local->read();

        $number = self::$client->incomingPhoneNumbers->create([
            'phoneNumber' => $numbers[0]->phoneNumber,
            'SmsUrl' => route('sms'),
            'VoiceUrl' => route('voice')
        ]);

        return $number->phoneNumber;
    }
}