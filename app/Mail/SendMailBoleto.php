<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailBoleto extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $attachAdress;
    protected $mesAtual;
    protected $nomeAluno;
    public function __construct($adress,$mesAtual, $nomeAluno)
    {
        $this->attachAdress = $adress;
        $this->mesAtual = $mesAtual;
        $this->nomeAluno = $nomeAluno;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$adress = $this->attachAdress ;
        $mesAtual= $this->mesAtual ;
        $nomeAluno = $this->nomeAluno ;
        return $this->from("boletos@vicampe.com.br", "Sistema de Boletos")
            ->subject("Boleto Fretamento Universitário")
                    ->attach($this->attachAdress)
                    ->view('corpo_email', compact('mesAtual',"nomeAluno"));
    }
}
