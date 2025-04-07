<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\AssetAssigns;
use App\Models\AssetIssuance;
use App\Models\AssetIssuanceDetl;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\ApproversStatus;
use App\Models\ApproversMatrix;
use App\Models\GatepassData;

use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\ValidationException;

class AssetRecieved_Notif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public $qrCodeBase64;
    public $gatepasss_status;
    public $subject;
    public function __construct(public $id)
    {
        $data = AssetIssuance::with(['details', 'getEmployee'])->find($id);
        $this->subject = 'Asset Recieved Notification for Issuance number: ' . $data->rev_num;
        $qrCode = QrCode::create($data->id)
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
                ->setSize(200)
                ->setMargin(10);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());
        $gatepasss_status = ApproversStatus::with(['user'])->where('data_id', $id)->where('pages_id', 8)->get();
        $this->data = $data;
        $this->qrCodeBase64 = $qrCodeBase64;
        $this->gatepasss_status = $gatepasss_status;
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
            view: 'AssetAssign.issuance_pdf_rep',
            with: [
                'data_show' => $this->data,
                'qrCode' => $this->qrCodeBase64,
                'gatepasss_status' => $this->gatepasss_status
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
