<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetBorrowed;
use App\Models\User;

class BorrowedNotif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $data_ned;
    public $data_approver;
    public function __construct(public $borrowed_id, public $page_id, public $user_id)
    {
        $data = AssetBorrowed::with(['getEmployee', 'getLocation_from', 'details'])->find($borrowed_id);
        $approver_data = User::find($user_id);
        $this->data_approver = $approver_data;
        $this->data_ned = $data;
        $this->subject = "Asset Borrowing Request for Approval - Reference No: {{ $data->ref_num }}";

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.borrowed_notif',
            with:[
                'data_ned' => $this->data_ned,
                'approver_data' => $this->data_approver
            ]
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
