<?php 
$v_id = $_GET['id'];
// error_reporting(E_ALL);require 'Exception.php';require 'PHPMailer.php';require 'SMTP.php';require 'PHPMailerAutoload.php';
// $mail = new PHPMailer();$mail->Host = "smtp.pmc.ph";$mail->IsHTML(true);$mail->Username = "no-reply@pmc.ph";$mail->Password = "Unimex123!";$mail->SetFrom("no-reply@pmc.ph", "");

$e_address = "jericopresentacion08@gmail.com";
// $e_address = "angelica.alega@pmc.ph";

require 'PHPMailer\src\Exception.php';require 'PHPMailer\src\PHPMailer.php';require 'PHPMailer\src\SMTP.php';require 'PHPMailer\src\PHPMailerAutoload.php';
$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPAuth = true;$mail->SMTPSecure = 'ssl';$mail->Host = "smtp.gmail.com";$mail->Port = 465;$mail->IsHTML(true);$mail->Username = "pmcmailchimp@gmail.com";$mail->Password = "1_pmcmailchimp@gmail.com";$mail->SetFrom("inquiry@inmed.com.ph", "");


$mail->Subject = "NEW APPROVED RCA";
$badie = 'You have new approved RCA to your dashboard. Go to website to check. click this -> <a href="https://pmc.ph/online_requisition/login.php">Online Requisition Form</a>';
$mail->Body = $badie;

$mail->AddAddress($e_address);
if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    // echo "Email sent";
    header('location:../../approvalRCAFinal.php?id='.$v_id.'&approver=&at=');
}


 ?>