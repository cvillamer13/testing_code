<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetTransfer;
use App\Models\AssetIssuance;
use App\Models\User;

class AssetTransferNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $transfer_data;
    public $issuance_data;
    public $name;
    public function __construct(public $transfer_id, public $pages_id, public $user_id)
    {
        $main_data = AssetTransfer::with(['details', 'assetDetails', 'getEmployee', 'getEmployee_to'])->find($transfer_id);

        
        $issueance = AssetIssuance::with(['details', 'assetDetails', 'getEmployee', 'getLocation'])->where('rev_num', $main_data->from_issuance)->first();
        
        $this->transfer_data = $main_data;
        $this->issuance_data = $issueance;
        $user_notif = User::find($user_id);
        $this->name = $user_notif->name;
        $from_employee = $main_data->getEmployee->first_name . " " . $main_data->getEmployee->last_name;
        $to_employee = $main_data->getEmployee_to->first_name . " " . $main_data->getEmployee_to->last_name;
        $this->subject = "Asset Transfer Notification – From $from_employee to $to_employee ";
        // $this->transfer_id_data = transfer_id;

        // print_r($this->name);
        // exit;

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
            view: 'mail.notification_asset_transfer',
            with: [
                'transfer_data' => $this->transfer_data,
                'issuance_data' => $this->issuance_data,
                'name' => $this->name,
                'transfer_id' => $this->transfer_id,
                'pages_id' => $this->pages_id,
                'user_id', $this->user_id
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
