<?php
namespace App\Mailers;

use App\Ticket;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer {
    protected $mailer; 
    protected $fromAddress = 'support@supportticket.dev';
    protected $fromName = "Davy's Support Ticket";
    protected $to;
    protected $subject;
    protected $view;
    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTicketInformation($user, Ticket $ticket)
    {
        $this->to = $user->email;
        $this->subject = "[Ticket ID: $ticket->slug] $ticket->title";
        $this->view = 'emails.ticket_info';
        $this->data = compact('user', 'ticket');

        return $this->deliver();
    }

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message) {
        $message->from($this->fromAddress, $this->fromName)
        ->to($this->to)->subject($this->subject);
        });
    }
    }