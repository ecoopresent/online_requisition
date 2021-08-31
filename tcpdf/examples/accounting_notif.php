<?php 
$pr_id = $_GET['id'];

require_once "../../controller/controller.db.php";
require_once "../../model/model.users.php";

$users = new Users();
$e_address = $users->getEmailAcct();

// error_reporting(E_ALL);require 'Exception.php';require 'PHPMailer.php';require 'SMTP.php';require 'PHPMailerAutoload.php';$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));$mail->SMTPAuth = true;$mail->Host = "smtp.panamed.com.ph";$mail->IsHTML(true);$mail->Username = "no-reply@panamed.com.ph";$mail->Password = "Unimex123!";$mail->SetFrom("no-reply@panamed.com.ph", "");


require 'PHPMailer\src\Exception.php';require 'PHPMailer\src\PHPMailer.php';require 'PHPMailer\src\SMTP.php';require 'PHPMailer\src\PHPMailerAutoload.php';
$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPAuth = true;$mail->SMTPSecure = 'ssl';$mail->Host = "smtp.gmail.com";$mail->Port = 465;$mail->IsHTML(true);$mail->Username = "pmcmailchimp@gmail.com";$mail->Password = "1_pmcmailchimp@gmail.com";$mail->SetFrom("inquiry@inmed.com.ph", "");


$mail->Subject = "NEW APPROVED RCA";
$badie = 'You have new approved RCA to your dashboard. Go to website to check. click this -> <a href="https://panamed.com.ph/online_requisition/login.php">Online Requisition Form</a>';
$mail->Body = $badie;

foreach ($e_address as $k => $v) {
	$mail->AddAddress($v['payee_email']);
}

if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    // echo "Email sent";
    header('location:../../approvalCashCheckFinal.php?id='.$pr_id."&approver=");
}


 ?>