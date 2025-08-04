<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmail extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Successfully Absensi HIMTECH')
            ->line('Terima kasih telah mengisi form absensi.')
            ->line('Berikut adalah detail absensi Anda:')
            ->line('Nama: ' . $notifiable->nama) // Sesuaikan dengan properti yang benar
            ->line('No Telepon: ' . $notifiable->no_telpon) // Sesuaikan dengan properti yang benar
            ->line('Minat: ' . $notifiable->minat) // Sesuaikan dengan properti yang benar
            ->line('Tombol "Informasi Lebih Lanjut" akan mengarahkan Anda ke website Profile HIMTECH.')
            ->action('Informasi Lebih Lanjut', url('https://himtech-2025.vercel.app'))
            ->line('Terima kasih, **' . $notifiable->nama . '** telah mengisi form absensi dan bergabung bersama keluarga besar TRPL!')
            ->line('Kami sangat senang menyambut kehadiranmu. Semangat terus ya, dalam menjalani setiap langkah perjalananmu di TRPL.')
            ->line('Teruslah belajar, tumbuh, dan berkarya untuk meraih impian dan masa depan yang gemilang!')
            ->salutation('Salam hangat, Panitia HIMTECH'); // Ganti ini sesuai keinginanmu
                
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
