<?php

namespace App\Http\Controllers;

use App\Jobs\Messaging\OrderMessaging;

class QueueTestController extends Controller
{
    public function test(): string
    {
        for ($i = 0; $i < 5; $i++) {
            OrderMessaging::dispatch(2);
            sleep(rand(0, 5));
        }

        return 'Done';
    }
}
