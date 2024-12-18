<?php

namespace App\Mail;

use App\Models\Preorder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PreorderSubmittedToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $preorder;

    /**
     * Create a new message instance.
     *
     * @param Preorder $preorder
     */
    public function __construct(Preorder $preorder)
    {
        $this->preorder = $preorder;
    }

    public function build()
    {
        return $this->subject('New Preorder Received')
            ->view('emails.preorder_submitted_admin')
            ->with([
                'preorder' => $this->preorder,
            ]);
    }
}
