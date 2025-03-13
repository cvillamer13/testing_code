<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetIssuance;

class Approvedissuance_Notif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $issuance_id)
    {
        $issuncance = AssetIssuance::with(['details', 'getEmployee', 'getLocation'])->find($issuance_id);
        // $this
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Approvedissuance Notif',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.approved_issuance',
            // with: [
            //     'name' => $this->name,
            //     'rev_num' => $this->rev_num,
            //     'issueby' => $this->issueby,
            //     'assignee' => $this->assignee,
            //     'date_req' => $this->date_req,
            //     'date_need' => $this->date_need,
            //     'pages_id' => $this->pages_id,
            //     'user_id' => $this->user_id,
            // ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
