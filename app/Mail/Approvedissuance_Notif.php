<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetIssuance;
use App\Models\User;

class Approvedissuance_Notif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    // public $name;
    public $rev_num;
    public $issueby;
    public $assignee;
    public $date_req;
    public $date_need;
    public $subject;
    // private $issuance_id;

    public function __construct(public $issuance_id, public $gatepass_id)
    {
        $issuncance = AssetIssuance::with(['details', 'getEmployee', 'getLocation'])->find($issuance_id);
        
        $users = User::where('email', $issuncance->issued_by)->first(); 
        // dd($users);
        $this->assignee = $issuncance->getEmployee->first_name . ' ' . $issuncance->getEmployee->last_name;
        $this->rev_num = $issuncance->rev_num;
        $this->issueby = $users->name;
        $this->date_req = $issuncance->date_req;
        $this->date_need = $issuncance->date_need;
        $this->subject = "Issuance Request is Approved Rev. No. " . $this->rev_num; 
        $this->issuance_id = $issuance_id;
        $this->gatepass_id = $gatepass_id;
        // $this
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
            view: 'mail.approved_issuance',
            with: [
                'rev_num' => $this->rev_num,
                'issueby' => $this->issueby,
                'assignee' => $this->assignee,
                'date_req' => $this->date_req,
                'date_need' => $this->date_need,
                // 'pages_id' => $this->pages_id,
                'issuance_id' => $this->issuance_id,
                'gatepass_id' => $this->gatepass_id,
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
