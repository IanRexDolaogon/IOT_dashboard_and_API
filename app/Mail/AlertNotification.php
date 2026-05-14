<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\SensorData; // Import your model

class AlertNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sensorData; // Variable to hold the data

    public function __construct(SensorData $sensorData)
    {
        $this->sensorData = $sensorData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'URGENT: Ventilation Required in Classroom',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.alert', // We will create this view next
        );
    }
}