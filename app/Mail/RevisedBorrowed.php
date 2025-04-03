<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetBorrowed;
use App\Models\ApproversStatus;
use App\Models\User;

class RevisedBorrowed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $rev_num;
    public $borrowed_id;
    public $disapproval_reason;
    public $disapprovedby;
    public $name;
    public function __construct(public $issuance_id, public $approver_id)
    {
        $data_issuance = AssetBorrowed::find($issuance_id);
        $this->subject = "Borrowed Asset Request Disapproved Document No.: " . $data_issuance->ref_num;
        $this->rev_num = $data_issuance->ref_num;
        $this->borrowed_id = $data_issuance->id;
        $users = User::where('email', $data_issuance->requested_by)->first();
        $this->name = $users->name;


        $approver_data = ApproversStatus::find($approver_id);
        $this->disapproval_reason = $approver_data->remarks;
        $users_dis = User::find($approver_data->user_id);
        $this->disapprovedby = $users_dis->name;
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
            view: 'mail.revised_borrowed',
            with: [
                'rev_num' =>  $this->rev_num,
                'issued_id' => $this->borrowed_id,
                'disapproval_reason' => $this->disapproval_reason,
                'name' => $this->name,
                'disapprovedby' => $this->disapprovedby,

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
