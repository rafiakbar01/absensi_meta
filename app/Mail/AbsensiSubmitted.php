<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbsensiSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;

    public $email;
    public $no_telp;
    public $minat;

    /**
     * Create a new message instance.
     */
    public function __construct($nama, $email, $no_telp, $minat)
    {
        $this->nama = $nama;

        $this->email = $email;
        $this->no_telp = $no_telp;
        $this->minat = $minat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Absensi Submitted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

    public function build()
    {
        return $this->subject('Absensi Anda Telah Diterima')
                    ->view('emails.absensi_submitted', [
                        'nama' => $this->nama,
                        'email' => $this->email,
                        'no_telp' => $this->no_telp,
                        'minat' => $this->minat,
                    ]);
    }
}
