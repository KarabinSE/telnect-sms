<?php

namespace Karabin\TelnectSms\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SmsSendingFailedEvent
{
    use Dispatchable;

    public function __construct(public string $response)
    {
        //
    }
}
