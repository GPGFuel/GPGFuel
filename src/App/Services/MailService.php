<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService {
    private function init() {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['MAILER_HOST'];
        $phpmailer->SMTPAuth = $_ENV['MAILER_AUTH'];
        $phpmailer->Port = $_ENV['MAILER_PORT'];
        $phpmailer->Username = $_ENV['MAILER_USERNAME'];
        $phpmailer->Password = $_ENV['MAILER_PASSWORD'];
        $phpmailer->setFrom($_ENV['MAILER_FROM'], $_ENV['MAILER_NAME']);
        return $phpmailer;
    }

    public function sendMail($email, $name, $subject, $content) {
        $mailer = $this->init();
        $mailer->addAddress($email, $name);
        $mailer->Subject = $subject;
        $mailer->Body =  $content;
        $mailer->send();
    }
}