<?php

namespace Karabin\TelnectSms;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Arr;
use Karabin\TelnectSms\Events\SmsSendingFailedEvent;
use Karabin\TelnectSms\Events\SmsSentSuccessfullyEvent;
use Karabin\TelnectSms\Exceptions\CouldNotSendNotification;

class TelnectSmsClient
{
    public const TELNECT_SMS_API_URL = 'https://api.telnect.com/v1/TextMessage/Send';

    public function __construct(
        protected GuzzleClient $client,
        protected string $apiKey,
    ) {
        //
    }

    public function send(TelnectSmsMessage $message, string $destination)
    {
        if (! $message->getSender()) {
            $message->originator(config('services.telnect_sms.originator', ''));
        }

        $parameters = [
            'text' => $message->getBody(),
            'to' => $destination,
            'from' => $message->getSender(),
        ];

        $response = $this->client->request('POST', static::TELNECT_SMS_API_URL, [
            'body' => json_encode($parameters),
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        /**
         * If error code is 1, the message was sent successfully.
         */
        $body = $response->getBody()->getContents();
        $errorCode = Arr::get(json_decode($body, true), 'status');
        if ((int) $errorCode !== 1) {
            SmsSendingFailedEvent::dispatch($body);

            throw CouldNotSendNotification::serviceRespondedWithAnError($body);
        }

        SmsSentSuccessfullyEvent::dispatch($body);
    }
}
