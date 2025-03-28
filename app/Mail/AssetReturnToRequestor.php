<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetReturn;
use App\Models\User;

class AssetReturnToRequestor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $requestor;
    public $confirmor;
    public $employee;
    public $return_data;
    public function __construct(public $return_id)
    {
        $data_return = AssetReturn::with(['details', 'employee_data', 'assetDetails'])->find($return_id);
        $this->return_data = $data_return;
        $this->confirmor = User::where('email', $data_return->confirmed_by)->first();
        $this->employee = $data_return->employee_data;
        $this->requestor = User::where('email', $data_return->finalizedby)->first(); 
        // $this->return_data = $data_return;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Asset Return To Requestor',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.Asset_returntorequest',
            with:[
                'requestor' => $this->requestor,
                'confirmor' => $this->confirmor,
                'employee' => $this->employee,
                'return_data' => $this->return_data 
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
