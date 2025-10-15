<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewArticleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $article;
    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct($article, $type)
    {
        $this->article = $article;
        $this->type = $type;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nouvel article publié !')
            ->markdown('emails.new_article')
            ->with([
                'article' => $this->article,
                'type' => $this->type,
            ]);
    }
}
