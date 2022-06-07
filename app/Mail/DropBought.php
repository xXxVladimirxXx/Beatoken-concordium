<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DropBought extends Mailable
{
    use Queueable, SerializesModels;

    protected $drop;
    protected $nfts;

    public function __construct($drop, $nfts)
    {
        $this->drop = $drop;
        $this->nfts = $nfts;
    }

    public function build()
    {
        return $this->view('mail-templates.user.drop-bought')->with(['drop' => $this->drop, 'nfts' => $this->nfts]);
    }
}
