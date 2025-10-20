<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'otienobriyo@gmail.com'; // Your Gmail
    $mail->Password   = 'sowu yamk kfhp octn';   // Your 16-char app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('otieno@gmail.com', 'Peaksphere Ken Limited');
    $mail->addAddress('brianokanga8', 'Client Name'); // Receiver

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Invoice Email';
    $mail->Body    = '<h3>Hello!</h3><p>This is a test email sent from <b>PHPMailer with Gmail SMTP</b> on XAMPP.</p>';
    $mail->AltBody = 'This is the plain text version for older email clients.';

    $mail->send();
    echo "✅ Message has been sent successfully!";
} catch (Exception $e) {
    echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
