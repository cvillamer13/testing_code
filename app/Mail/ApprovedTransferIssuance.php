<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetIssuance;
use App\Models\AssetTransfer;
use App\Models\User;

class ApprovedTransferIssuance extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $issueby;
    public $asset_data;
    public $issuance_ref;
    public $name_to;

    public function __construct(public $transfer_id, public $issuance_id)
    {
        $asset_issuance = AssetIssuance::with(['getEmployee', 'details', 'assetDetails', 'getLocation'])->find($issuance_id);
        $this->issuance_ref = $asset_issuance->rev_num;
        $transfer_asset = AssetTransfer::with(['details', 'assetDetails', 'getEmployee', 'getEmployee_to'])->find($transfer_id);
        $user = User::where('email', $asset_issuance->issued_by)->first();
        $this->issueby = $user->name;
        $this->asset_data = $transfer_asset;
        $this->subject = "Issuance Required: Asset Transfer Successfully Approved";
        $this->name_to = $transfer_asset->getEmployee_to->first_name . " " . $transfer_asset->getEmployee_to->last_name;

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
            view: 'mail.AssetTransferIssuance',
            with: [
                'issueby' => $this->issueby,
                'issuance_ref' =>  $this->issuance_ref,
                'issuance_id' => $this->issuance_id,
                'assignee' => $this->name_to,
                'asset_data' => $this->asset_data

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
