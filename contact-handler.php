<?php

require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure le fichier de chargement automatique de PHPMailer
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
 

// Le destinataire de l'email
$destinataire = 'mohamed@dadssi.com';

// 1. Récupérer et valider les données du formulaire
$name = trim($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL); // Valide l'email
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Vérifier si les champs obligatoires ne sont pas vides
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    // Rediriger vers la page du formulaire avec un message d'erreur
    header('Location: index.html?status=error&msg=Veuillez remplir tous les champs.');
    exit();
}

// 2. Initialiser PHPMailer
$mail = new PHPMailer(true);

try {
    // 3. Paramètres du serveur SMTP
    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_username;
    $mail->Password   = $smtp_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Ou 'ssl' pour le port 465
    $mail->Port       = $smtp_port;

    // 4. Paramètres de l'email
    $mail->setFrom($smtp_username, 'dadssi.com'); // L'expéditeur
    $mail->addAddress($destinataire); // Le destinataire
    $mail->addReplyTo($email, $name); // Permet de répondre directement à l'expéditeur

    $mail->isHTML(true);
    $mail->Subject = $subject;
    
    // Corps de l'email en HTML
    $mail->Body    = "
        <h3>Nouveau message de ton portfolio !</h3>
        <p><strong>Nom :</strong> " . htmlspecialchars($name) . "</p>
        <p><strong>Email :</strong> " . htmlspecialchars($email) . "</p>
        <p><strong>Sujet :</strong> " . htmlspecialchars($subject) . "</p>
        <p><strong>Message :</strong></p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>
    ";

    // Envoi de l'email
    $mail->send();

    echo "Message envoyé avec succès !";

    // Redirection vers la page du formulaire avec un message de succès
    header('Location: index.php?status=success&msg=Votre message a été envoyé avec succès !');
    exit();
    
} catch (Exception $e) {
    // echo "Le message n'a pas pu être envoyé. Erreur Mailer : {$mail->ErrorInfo}";
    // Gérer l'erreur et rediriger avec un message d'échec
    header('Location: index.php?status=error&msg=Le message n\'a pas pu être envoyé. Erreur Mailer : ' . $mail->ErrorInfo);
    exit();
}
?>