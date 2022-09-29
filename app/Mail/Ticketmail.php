<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ticketmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $ticket;
    protected $poshtibans;

    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->poshtibans = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.mail_ticket', ['ticket' => $this->ticket])
            ->subject($this->ticket->name)
            ->to($this->poshtibans->email);
    }
}
