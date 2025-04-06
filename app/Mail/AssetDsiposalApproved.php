<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;
use App\Models\AssetDisposal;
class AssetDsiposalApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $data_disposal;
    public $employee_data;
    public function __construct(public $assetdisposal_id, public $page_id, public $emp_id)
    {
        $data = AssetDisposal::with(['details'])->find($assetdisposal_id);
        $employee_data = Employee::find($emp_id);
        $this->employee_data = $employee_data;
        $this->subject = "Asset Disposal Approved - Reference No: $data->ref_num";
        $this->data_disposal = $data;
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
            view: 'mail.disposal_approved',
            with:[
                'data_disposal' => $this->data_disposal,
                'employee_data' => $this->employee_data
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
