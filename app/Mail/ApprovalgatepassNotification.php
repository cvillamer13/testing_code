<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\GatepassData;
use App\Models\AssetIssuance;
use App\Models\User;
use App\Models\Location;

class ApprovalgatepassNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $gatepass_no;
    public $data;
    public $name;
    public $created_date;
    public $gatepass_id_dta;
    public $location_from_data;
    public $location_to_data;
    // public $pages_id;
    public function __construct(public $gatepass_id, public $pages_id, public $user_id)
    {
        $gatepass_data = GatepassData::find($gatepass_id);
        $this->gatepass_id_dta = $gatepass_id;
        $this->subject = "Approval Request for Gate Pass No: " . $gatepass_data->gatepass_no;
        $this->gatepass_no = $gatepass_data->gatepass_no;
        $this->created_date = $gatepass_data->created_at;
        $user_data = User::find($user_id);
        $this->name = $user_data->name;
        $from_location = Location::with(['company','department'])->find($gatepass_data->from_location);
        $to_location = Location::with(['company','department'])->find($gatepass_data->to_location);
        $this->location_from_data = $from_location;
        $this->location_to_data = $to_location;
        switch ($gatepass_data->module_from) {
            case 'issuance':
                $data_used = AssetIssuance::with(['details', 'assetDetails', 'getLocation'])->find($gatepass_data->data_id);
                // echo "<pre>";
                // print_r($data->assetDetails);
                // exit;
                $this->data = $data_used;
            break;
        }

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
            view: 'mail.request_approval_gatepass',
            with: [
                'gate_pass_no' => $this->gatepass_no,
                'pages_id' => $this->pages_id,
                'user_id' => $this->user_id,
                'data' => $this->data,
                'name' => $this->name,
                'created_date' => $this->created_date,
                'gatepass_id_dta' => $this->gatepass_id_dta,
                'from_location' => $this->location_from_data,
                'to_location' => $this->location_to_data
            ],
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
