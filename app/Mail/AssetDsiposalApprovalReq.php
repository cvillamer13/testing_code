<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetDisposal;
use App\Models\User;
class AssetDsiposalApprovalReq extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $data_disposal;
    public $data_approver;
    public function __construct(public $assetdisposal_id, public $page_id, public $user_id)
    {
        $data = AssetDisposal::with(['details'])->find($assetdisposal_id);
        $approver_data = User::find($user_id);
        $this->data_approver = $approver_data;
        $this->data_disposal = $data;
        $this->subject = "Asset Disposal Request for Approval - Reference No: $data->ref_num";
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
            view: 'mail.disposal_notif',
            with:[
                'data_disposal' => $this->data_disposal,
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
