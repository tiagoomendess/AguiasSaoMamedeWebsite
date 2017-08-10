<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Lang;

class EmailResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $nome, $apelido, $email, $token, $assunto, $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $apelido, $email, $token)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->token = $token;
        $this->assunto = Lang::trans('emails.password_reset_subject');

        $this->link = 'https://' . Lang::trans('geral.dominio') . '/password/change/' . $this->token;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->assunto)
            ->replyTo('respostas@sao-mamede.mendes.com.pt')
            ->view('emails.password-recovery');
    }
}
