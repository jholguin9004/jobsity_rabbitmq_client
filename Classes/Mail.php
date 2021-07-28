<?php

declare(strict_types=1);

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail{
    
    public static function SendMsg($body){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = false;//SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = (bool) $_ENV['SMTP_AUTH'];
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
            $mail->Port = $_ENV['SMTP_PORT'];
            $data = json_decode($body);
            //Recipients
            $mail->setFrom($_ENV['SMTP_FROM_MAIL'], $_ENV['SMTP_FROM_NAME']);
            $mail->addAddress($data->to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Here is your stooq request!';
            $mail->Body = self::getBody($data->data);
            $mail->send();
            echo "Message has been sent to user {$data->to}\n";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
        }
    }

    /**
     * Construct budy html
     *
     * @param array $data
     * @return void
     */
    private static function getBody($data){
        $html = '<ul>';
        foreach($data as $title => $val){
            $html.= "<li><b>{$title}</b>: {$val}</li>";
        }
        $html.= '</ul>';
        return $html;
    }
}