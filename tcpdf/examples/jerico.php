<?php
error_reporting(E_ALL);require 'Exception.php';require 'PHPMailer.php';require 'SMTP.php';require 'PHPMailerAutoload.php';
$mail = new PHPMailer();$mail->Host = "smtp.pmc.ph";$mail->IsHTML(true);$mail->Username = "no-reply@pmc.ph";$mail->Password = "Unimex123!";$mail->SetFrom("no-reply@pmc.ph", "");

$e_address = "jericopresentacion08@gmail.com";
$mail->Subject = "Jerico Testing";
$badie = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ Email Subject }}</title>
        <style>
            html,
            body,
            table,
            tbody,
            tr,
            td,
            div,
            p,
            ul,
            ol,
            li,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                margin: 0;
                padding: 0;
            }
            body {
                margin: 0;
                padding: 0;
                font-size: 0;
                line-height: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            table {
                border-spacing: 0;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            table td {
                border-collapse: collapse;
            }
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .ReadMsgBody {
                width: 100%;
            }
            img {
                -ms-interpolation-mode: bicubic;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-family: Arial;
            }
            h1 {
                font-size: 28px;
                line-height: 32px;
                padding-top: 10px;
                padding-bottom: 24px;
            }
            h2 {
                font-size: 24px;
                line-height: 28px;
                padding-top: 10px;
                padding-bottom: 20px;
            }
            h3 {
                font-size: 20px;
                line-height: 24px;
                padding-top: 10px;
                padding-bottom: 16px;
            }
            p {
                font-size: 16px;
                line-height: 20px;
                font-family: Georgia, Arial, sans-serif;
            }
            </style>
            <style>
                
            .container600 {
                width: 600px;
                max-width: 100%;
            }
            @media all and (max-width: 599px) {
                .container600 {
                    width: 100% !important;
                }
            }
        </style>

    </head>
    <body style="background-color:#F4F4F4;">
        <center>
    
          <table class="container600" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:calc(100%);max-width:calc(600px);margin: 0 auto;">
            <tr>
              <td width="100%" style="text-align: left;">
    
                <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                    <tr>
                        <td style="background-color:#FFFFFF;color:#000000;padding:30px;">
                            <img src="https://panamed.com.ph/assets/graphics/logo.jpg" width="160" style="display: block; margin: auto" />
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                    <tr>
                        <td style="padding:80px 50px; background-color:#e8f1fd;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 18px; font-weight: bold; line-height:30px;text-align:center;">
                                            Cash / Check Advance Request
                                        </td>
                                    </tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;">
                                            <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%; margin: auto">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 33%;"></td>
                                                        <td style="padding:5px;font-family: Arial,sans-serif; font-size: 14px; line-height:20px;text-align:left;">
                                                            <img src="https://pmc.ph/email_assets/done.png" width="25" style="vertical-align: middle;" /> &nbsp; &nbsp; <b>REQUESTED BY</b>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="width: 33%;"></td>
                                                        <td style="padding:5px;font-family: Arial,sans-serif; font-size: 14px; line-height:20px;text-align:left;">
                                                            <img src="https://pmc.ph/email_assets/pending.png" width="25" style="vertical-align: middle;" /> &nbsp; &nbsp; JERICO PRESENTACION
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;">
                                            For your approval, Please see attached files.
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 14px; line-height:60px;text-align:center;">
                                            <a href="#" style="color: #fff; text-decoration: none;"><span class="btn" style="padding: 13px 17px; background-color: #0d3e7c;">Click Here to Approve or Disapprove</span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                    <tr>
                        <td width="100%" style="min-width:100%;background-color:#58585A;color:#ffffff;padding:30px;">
                            <p style="font-size:12px;line-height:20px;font-family: Arial,sans-serif;text-align:center;">&copy;2021 Panamed Philippines Incorporation</p>
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
    
        </center>
    </body>
    </html>';
$mail->Body = $badie;
$mail->AddAddress($e_address);

$file_to_attach = '../../attachments/RCA2021-131/SPR- TDHI 050521.pdf';
$mail->AddAttachment( $file_to_attach , 'SPR- TDHI 050521.pdf' );
// $file_to_attach = '../../attachments/RCA2021-131/TOP-F-04_rev.7.doc Questionnaire.docx';
// $mail->AddAttachment( $file_to_attach , 'TOP-F-04_rev.7.doc Questionnaire.docx' );

if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Email sent";
}

?>