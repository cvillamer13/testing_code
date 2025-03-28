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

class AssetReturnToChecker extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $subject;
    public $employee;
    public $return_data;
    public $user_id;
    public $name;
    public $requestor;
    public function __construct(public $assetreturn_id, public $user_checker)
    {
        //
        $data_return = AssetReturn::with(['details', 'employee_data', 'assetDetails'])->find($assetreturn_id);
        $this->return_data = $data_return;
        $this->employee = $data_return->employee_data;
        $employee_data_name = $data_return->employee_data->first_name. " " .$data_return->employee_data->last_name;
        $this->subject = "Asset Return Request (Ref: $data_return->ref ) for $employee_data_name";

        $checker = User::where('email', $user_checker)->first();
        $this->user_id = $checker->id;
        $this->name = $checker->name;
        $this->requestor = User::where('email', $data_return->finalizedby)->first(); 
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
            view: 'mail.Asset_returntocheck',
            with: [
                'employee' => $this->employee,
                'return_data' => $this->return_data,
                'user_id' => $this->user_id,
                'name' => $this->name,
                'requestor' => $this->requestor

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
