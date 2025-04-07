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
use App\Models\User;
use App\Models\ApproversStatus;

class AssetDsiposalRevised extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;
    public $data_disposal;
    public $employee_data;
    public $rfinal_by;
    public $disapproval_reason;
    public $disapprovedby;
    public function __construct(public $assetdisposal_id, public $approver_id)
    {
        $data = AssetDisposal::with(['details'])->find($assetdisposal_id);
        $reqby = User::where('email', $data->finalizedby)->first();
        $this->rfinal_by = $reqby;
        $employee_data = Employee::find($data->trans_emp_id);
        $this->employee_data = $employee_data;
        $this->subject = "Asset Disposal Disapproved - Reference No: $data->ref_num";
        $this->data_disposal = $data;


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
            view: 'mail.disposal_disapproved',
            with:[
                'data_disposal' => $this->data_disposal,
                'employee_data' => $this->employee_data,
                'reqby' => $this->rfinal_by,
                'disapproval_reason' => $this->disapproval_reason,
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
