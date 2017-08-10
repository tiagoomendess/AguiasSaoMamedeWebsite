<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Lang;

class EmailConfirmation extends Mailable
{

    public $nome, $apelido, $email, $token, $assunto, $html_body, $html_footer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $apelido, $email, $token)
    {
        $this->nome = $nome;
        $this->apelido = $apelido;
        $this->email = $email;
        $this->token = $token;
        $this->assunto = Lang::trans('emails.email_confirmation_subject');

        //Vars auxiliares
        $tokenNegro = '<b>' . $token . '</b>';
        $link = 'https://' . Lang::trans('geral.dominio') . '/registar/confirmar?email=' . urlencode($this->email) . '&token=' . $this->token;

        //Construir o email
        $this->html_body = '<p>' .Lang::trans('emails.email_confirmation_greeting', ['nome' => $this->nome, 'apelido' => $this->apelido]) . ',</p>'; //adicionar saudação
        $this->html_body .= '<p>' . Lang::trans('emails.email_confirmation_explain', ['token' => $tokenNegro]) . '</p>'; //Texto a explicar
        $this->html_body .= '<p><a href="' . $link . '">' . $link . '</a></p>';
        $this->html_body .= '<p>' . Lang::trans('emails.email_confirmation_after_btn', ['email' => $this->email]) . '</p>';

        $this->html_footer = '<p>' . Lang::trans('geral.clube_full') . '<br>' .
            Lang::trans('geral.main_email') . '<br>' .
            Lang::trans('geral.dominio') . '<br>' .
            Lang::trans('geral.morada') .
            '</p>';

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
            ->view('emails.email-confirmation');
    }
}
