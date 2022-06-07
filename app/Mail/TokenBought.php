<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TokenBought extends Mailable
{
    use Queueable, SerializesModels;

    protected $nft;

    public function __construct($nft)
    {
        $this->nft = $nft;
    }

    public function build()
    {
        return $this->view('mail-templates.user.token-bought')->with(['nft' => $this->nft]);
    }
}
