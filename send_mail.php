<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.peaksphereken.com';   // ✅ check cPanel -> Email Accounts -> Connect Devices
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@peaksphereken.com';   // ✅ your domain email
        $mail->Password   = 'YOUR_EMAIL_PASSWORD';      // ✅ the password you set in cPanel
        $mail->SMTPSecure = 'ssl';                      // 'ssl' or 'tls'
        $mail->Port       = 465;                        // 465 for SSL, 587 for TLS

        // Email headers
        $mail->setFrom('info@peaksphereken.com', 'Website Contact Form');
        $mail->addAddress('peaksphere@gmail.com');      // ✅ where you want to receive the queries
        $mail->addReplyTo($email, $name);               // ✅ reply goes to the client

        // Email content
        $mail->isHTML(false);
        $mail->Subject = "New Inquiry from Website";
        $mail->Body    = "You have received a new inquiry:\n\n"
                       . "Name: $name\n"
                       . "Email: $email\n"
                       . "Service: $service\n"
                       . "Message:\n$message\n";

        // Send the email
        $mail->send();
        echo "<script>alert('✅ Thank you! Your message has been sent.'); window.location.href='index.html';</script>";

    } catch (Exception $e) {
        echo "<script>alert('❌ Sorry, something went wrong: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>
