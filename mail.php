<?php 

require_once "php/pdo.php";
session_start();
error_reporting(0);

date_default_timezone_set("Asia/Kolkata");
$time = date("h:i:sa");
$date = date("Y-m-d");

$sql = "SELECT email,headline,message,createdate FROM emails WHERE deliverydate = '$date' and status = 'Not Delivered'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':ag' => $_POST['email'],
            ':rn' => $_POST['headline'],
            ':ms' => $_POST['message'],
            ':pw' => $_POST['createdate']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);


$email = $row['email'];
$headline = $row['headline'];
$message = $row['message'];
$createdate = $row['createdate'];

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

// $mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'quizzoneforyou@gmail.com';                 // SMTP username
$mail->Password = 'quizzoneforyou810@';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('quizzoneforyou@gmail.com', 'Future Me');
$mail->addAddress($email, $email);     // Add a recipient

// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $headline;
$mail->Body = '<!DOCTYPE html>
<html>
<title>Future Me</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<div class="w3-container">

  <div class="w3-card-4" style="width:50%;">
    <header class="w3-container w3-blue">
      <h1>FutureMe from '.$createdate.' </h1>
    </header>

    <div class="w3-container">
    	<h2>Hi '.$email.',</h2>
      <p>'.$message.'.</p>
    </div>

    <footer class="w3-container w3-blue">
      <h4>Thanks,</h4>
      <h4>Future Me team</h4>
    </footer>
  </div>
</div>

</body>
</html>
';




if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    $status = 'Delivered';
        $sql = "UPDATE emails
        SET status = :st
        WHERE email = :ag and deliverydate = :dd";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':st' => $status,
        ':dd' => $date,
        ':ag' => $email));

    }
    echo 'Message has been sent';


?>