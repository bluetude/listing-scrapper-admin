<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer,
    )
    {
    }

    public function sendVerificationMail(string $email, string $url): void
    {
        $email = (new Email())
            ->from('test@test.com')
            ->to('test@test.com')
            ->subject('Please verify your email address')
            ->text($url)
        ;

        $this->mailer->send($email);
    }
}