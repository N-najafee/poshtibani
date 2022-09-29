<?php

namespace App\Mail;

use App\Models\Response;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $response;
    protected $user;
    public function __construct(Response $response,User $user)
    {
        $this->response=$response;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.mail_response', ['response' => $this->response])
            ->subject($this->response->description)
            ->to($this->user->email);
    }
}
