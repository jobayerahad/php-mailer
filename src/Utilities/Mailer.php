<?php

namespace Utilities;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
  public static function sendEmail($to, $subject, $text, $html)
  {
    $mail = new PHPMailer(true);

    try {
      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
        )
      );

      $mail->IsSMTP();
      $mail->Mailer = "smtp";
      $mail->Host = getenv('SMTP_HOST');
      $mail->Port = getenv('SMTP_PORT');
      $mail->SMTPAuth = false;
      $mail->SMTPSecure = false;
      $mail->Username = getenv('SMTP_USERNAME');
      $mail->Password = getenv('SMTP_PASSWORD');

      $mail->setFrom(getenv('SMTP_FROM_EMAIL'), 'CMS');
      $mail->addAddress($to);
      $mail->Subject = $subject;
      $mail->isHTML(true);
      $mail->Body = $html;
      $mail->AltBody = $text;

      $mail->send();
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
}
