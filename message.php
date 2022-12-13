<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/vendor/autoload.php';

include('./gmailConfig.php');
$data = ["error" => true];
if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["message"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $phone = $_POST["phone"];

    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;

    $mail->Username = $username;
    $mail->Password = $password;

    $mail->setFrom($email, $name);
    $mail->addAddress('federation.iznaguen@gmail.com', 'Federation Iznaguen');
    $mail->Subject = 'Federation Iznaguen | New Message';
    
    $content = file_get_contents('content/message.html');
    $content = str_replace("{name}", $name, $content);
    $content = str_replace("{email}", $email, $content);
    $content = str_replace("{phone}", $phone, $content);
    $content = str_replace("{message}", $message, $content);

    $mail->msgHTML($content, __DIR__);

    if (!$mail->send()) {
    } else {
        $data = ["error" => false];
    }
}
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
echo json_encode($data);