<?php

namespace App\services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Courriel
{
    private $mailer;
    // pour injecter un service dans un service, on utilise le constructeur
    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function envoie(){
        $email = (new Email())
            ->from('admin@eni.fr')
            ->to('moi@eni.fr')
            ->subject('Nouveau wish')
            ->text('Un nouveau souhait a été ajouté');
        $this->mailer->send($email);
    }
}