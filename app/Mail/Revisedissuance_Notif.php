<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetIssuance;
use App\Models\ApproversStatus;
use App\Models\User;

class Revisedissuance_Notif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $subject;
    public $rev_num;
    public $issued_id;
    public $disapproval_reason;
    public $disapprovedby;
    public $name;
    public function __construct(public $issuance_id, public $approver_id)
    {
        $data_issuance = AssetIssuance::find($issuance_id);
        $this->rev_num = $data_issuance->rev_num;
        $this->subject = "Issuance Request Disapproved Rev No.: " . $data_issuance->rev_num;
        $this->issued_id = $data_issuance->id;
        $users = User::where('email', $data_issuance->issued_by)->first();
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
            subject: $this->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.revised_issuance',
            with: [
                'rev_num' =>  $this->rev_num,
                'issued_id' => $this->issued_id,
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
