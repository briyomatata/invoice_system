<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendResetEmail($toEmail, $resetLink) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'otienobriyo@gmail.com';   // your Gmail
        $mail->Password   = 'sowu yamk kfhp octn';     // Gmail App Password, not your Gmail login
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('otienobriyo@gmail.com', 'Admin Support');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "
            <p>Hello,</p>
            <p>Click the link below to reset your password:</p>
            <p><a href='$resetLink'>$resetLink</a></p>
            <p>If you did not request this, you can ignore this email.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
