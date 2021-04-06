<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


class EnvioMail{
    
    function envio_mail($email,$nombre,$asunto,$mensaje){
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'comiteempresarialmembrillal@gmail.com';                     // SMTP username
            $mail->Password   = 'znxusounbbsifcls';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('comiteempresarialmembrillal@gmail.com', 'Equipo de cuentas ZIMEP');
            $mail->addAddress($email, $nombre);     // Add a recipient

            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;
            
        
            $mail->send();
            echo 0;
        } catch (Exception $e) {
            echo "No se ha podido enviar el mensaje. Error: {$mail->ErrorInfo}";
        }
    }
}
?>