<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Dotenv\Dotenv;


//Load Composer's autoloader
require '../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
// Haal de formuliergegevens op
$naam = $_POST['naam'] ?? 'Naam onbekend';
$email = $_POST['e-mail'] ?? 'Geen e-mail ingevuld';
$klacht = $_POST['klacht'] ?? 'Geen klacht beschreven';
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.strato.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = $_ENV["Username"];                     //SMTP username
    $mail->Password = $_ENV["Password"];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV["Username"], 'Mailer');
    $mail->addAddress($_ENV["Username"], 'Ian User');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // E-mailinhoud
    $mail->isHTML(true);                                        // Instellen op HTML e-mail
    $mail->Subject = 'Nieuwe klacht van ' . $naam;
    $mail->Body = "
    <h1>Nieuwe klacht ontvangen</h1>
    <p><strong>Naam:</strong> {$naam}</p>
    <p><strong>E-mail:</strong> {$email}</p>
    <p><strong>Klacht:</strong><br>{$klacht}</p>";
    $mail->AltBody = "Naam: {$naam}\nE-mail: {$email}\nKlacht: {$klacht}";

    // E-mail versturen
    $mail->send();
    echo 'De klacht is succesvol verzonden.';

    // //Content
    // $mail->isHTML(true);                                  //Set email format to HTML
    // $mail->Subject = 'Klacht';
    // $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    // $mail->AltBody = 'This   is the body in plain text for non-HTML mail clients';


    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php



    ?>
    <div class="form-container">
        <form action="index.php" method="post">
            <label for="naam">Naam:</label>
            <input type="text" name="naam" id="naam" required>

            <label for="e-mail">E-mail:</label>
            <input type="email" name="e-mail" id="e-mail" required>

            <label for="klacht">Klacht:</label>
            <input type="text" name="klacht" id="klacht" required>

            <input type="submit" value="Verzenden">
        </form>
    </div>

</body>

</html>