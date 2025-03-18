<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\GatepassData;
use App\Models\User;

class ReleaseGatePass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $issueby;
    public $gatepass_no;
    public function __construct(public $gatepass_id)
    {
        $gatepass_data = GatepassData::find($gatepass_id);
        $this->subject = "Gate Pass ".$gatepass_data->gatepass_no." Ready for Release" ;
        $user_data = User::where('email', $gatepass_data->finalizedby)->first();
        // print_r($user_data);
        // exit;
        $this->issueby = $user_data->name;
        $this->gatepass_no = $gatepass_data->gatepass_no;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            cc: [
                new Address('christian.villamer@jakagroup.com', 'Christian Villamer'),
                // new Address('cc2@example.com', 'Another CC Name'),
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.Released_gatepass',
            with: [
                'issueby' => $this->issueby,
                'gatepass_no' => $this->gatepass_no
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
