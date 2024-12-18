<?php

namespace App\Listeners;

use App\Events\PreorderSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\PreorderSubmittedToUser;
use App\Mail\PreorderSubmittedToAdmin;

class SendPreorderSubmittedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PreorderSubmitted $event)
    {
        Mail::to('admin@example.com')->send(new PreorderSubmittedToAdmin($event->preorder));
        Mail::to($event->preorder->email)->send(new PreorderSubmittedToUser($event->preorder));
    }
}
