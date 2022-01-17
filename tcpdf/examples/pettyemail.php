<?php 
// error_reporting(E_ALL);require 'Exception.php';require 'PHPMailer.php';require 'SMTP.php';require 'PHPMailerAutoload.php';$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));$mail->SMTPAuth = true;$mail->Host = "smtp.panamed.com.ph";$mail->IsHTML(true);$mail->Username = "no-reply@panamed.com.ph";$mail->Password = "Unimex123!";$mail->SetFrom("no-reply@panamed.com.ph", "");

require 'PHPMailer\src\Exception.php';require 'PHPMailer\src\PHPMailer.php';require 'PHPMailer\src\SMTP.php';require 'PHPMailer\src\PHPMailerAutoload.php';
$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPAuth = true;$mail->SMTPSecure = 'ssl';$mail->Host = "smtp.gmail.com";$mail->Port = 465;$mail->IsHTML(true);$mail->Username = "pmcmailchimp@gmail.com";$mail->Password = "1_pmcmailchimp@gmail.com";$mail->SetFrom("inquiry@inmed.com.ph", "");

$e_address = "jericopresentacion08@gmail.com";
// $e_address = "jtchua@pmcgroup.com";

require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.petty_approval.php";

$petty_approval = new PettycashApproval();
$voucher_id = $_GET['id'];
$petty_info = $petty_approval->getPettyInfo($voucher_id);

// $button_link = "https://panamed.com.ph/online_requisition/approvalPettycashHead.php?id=$voucher_id&approver=Jerome T. Chua";
$button_link = "http://192.168.101.41/online_requisition/approvalPettycashHead.php?id=$voucher_id&approver=Jerome T. Chua";

// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$thermalSize = array(130, 152);

$pdf = new TCPDF('L', 'mm', $thermalSize, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Petty Cash');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(7, 28, 7);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set a barcode on the page footer
$pdf->setBarcode(date('Y-m-d H:i:s'));
// set font
$pdf->SetFont('dejavusans', '', 11);
// add a page
$pdf->AddPage();
$pdf->setJPEGQuality(75);
// Image example with resizing
$pdf->Image('logo.png', 7, 10,58, 12, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

// print a message
$txt = "";
$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
$pdf->SetY(1);
// $pdf->setCellPaddings( $left = '', $top = '2', $right = '', $bottom = '2');
$pdf->setCellPadding(1);
// -----------------------------------------------------------------------------
$html = '';
$department = $petty_info['department'];
$voucher_date = $petty_info['voucher_date'];
$voucher_no = $petty_info['voucher_no'];
$particulars = $petty_info['particulars'];
$cash_advance = $petty_info['cash_advance'];
$actual_amount = $petty_info['actual_amount'];
$charge_to = $petty_info['charge_to'];
$liquidated_on = $petty_info['liquidated_on'];
$requested_by = $petty_info['requested_by'];
$department_head = $petty_info['department_head'];
$authorized_signatory = $petty_info['authorized_signatory'];

$mail->Subject = "Petty Cash Request ( ".$voucher_no." )";

$html .= '<table width="100%" border="0" style="font-size: 11px">

				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td style="width:53%;"></td>
					<td colspan="3" style="border: 1px solid black;text-align:center;font-size: 14px;background-color: dimgray;color:white;width:47%;"><b>PETTY CASH VOUCHER</b></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 53%">DEPARTMENT DIVISION</td>
					<td colspan="2" style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 24%">DATE</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 23%">NO.</td>
				</tr>
				<tr>
					<td style="border-left: 1px solid black;text-align:center;font-size: 10px">'.$department.'</td>
					<td colspan="2" style="border-left: 1px solid black;text-align:center;font-size: 10px">'.$voucher_date.'</td>
					<td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px">'.$voucher_no.'</td>
				</tr>
				<tr>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px">PARTICULARS</td>
					<td colspan="2" style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px">CASH ADVANCE</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px">ACTUAL AMOUNT</td>
				</tr>
				<tr>
					<td style="border-left: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.$particulars.'</td>
					<td colspan="2" style="border-left: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.$cash_advance.'</td>
					<td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.$actual_amount.'</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid black;border-left: 1px solid black;width: 18%;font-size: 10px">CHARGE TO:</td>
					<td style="border-top: 1px solid black;border-right: 1px solid black;width: 35%"></td>
					<td style="border-top: 1px solid black;width: 27%;font-size: 10px">TO BE LIQUIDATED ON: </td>
					<td style="border-top: 1px solid black;border-right: 1px solid black;width: 20%"></td>
				</tr>
				<tr>
					<td style="border-bottom: 1px solid black;border-left: 1px solid black;width: 18%;font-size: 10px"></td>
					<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 35%;text-align:center;font-size: 10px">'.$charge_to.'</td>
					<td style="border-bottom: 1px solid black;width: 27%;font-size: 10px"></td>
					<td style="border-bottom: 1px solid black;border-right: 1px solid black;width: 20%;text-align:center;font-size: 10px">'.$liquidated_on.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 34%;font-size: 10px">REQUESTED/RECEIVED BY:</td>
					<td colspan="2" style="border-left: 1px solid black;border-right: 1px solid black;width: 66%;font-size: 10px">APPROVED BY: </td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 34%;font-size: 10px"></td>
					<td colspan="2" style="border-left: 1px solid black;border-right: 1px solid black;width: 66%;font-size: 10px"></td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 34%;font-size: 10px;text-align:center">'.$requested_by.'</td>
					<td style="border-left: 1px solid black;width: 33%;font-size: 10px;text-align:center">'.$department_head.'</td>
					<td style="border-right: 1px solid black;width: 33%;font-size: 10px;text-align:center">'.$authorized_signatory.'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 34%;font-size: 9px;text-align:center">PRINT NAME & SIGN</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 33%;font-size: 9px;text-align:center">DEPARTMENT HEAD</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-right: 1px solid black;width: 33%;font-size: 9px;text-align:center">AUTHORIZED SIGNATORY</td>
				</tr>';

 $html .= '</table>';


// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln();

// //Close and output PDF document
// $pdf->Output('PR.pdf', 'I');



//Close and output PDF document
$pdfname = 'Petty Cash Request.pdf';
// $pdf->Output('PR.pdf', 'I');
// exit();
$pdffile = $pdf->Output('PR.pdf', 'S');
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
                                            Petty Cash Request
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
                                                            <img src="https://pmc.ph/email_assets/done.png" width="25" style="vertical-align: middle;" /> &nbsp; &nbsp; <b>'.$requested_by.'</b>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="width: 33%;"></td>
                                                        <td style="padding:5px;font-family: Arial,sans-serif; font-size: 14px; line-height:20px;text-align:left;">
                                                            <img src="https://pmc.ph/email_assets/done.png" width="25" style="vertical-align: middle;" /> &nbsp; &nbsp; <b>'.$department_head.'</b>
                                                        </td>
                                                    </tr>
                                                
                                                    <tr>
                                                        <td style="width: 33%;"></td>
                                                        <td style="padding:5px;font-family: Arial,sans-serif; font-size: 14px; line-height:20px;text-align:left;">
                                                            <img src="https://pmc.ph/email_assets/pending.png" width="25" style="vertical-align: middle;" /> &nbsp; &nbsp; Jerome T. Chua
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
                                            <a href="'.$button_link.'" style="color: #fff; text-decoration: none;"><span class="btn" style="padding: 13px 17px; background-color: #0d3e7c;">Click Here to Approve or Disapprove</span></a>
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
    $mail->addStringAttachment($pdffile,$pdfname);
    $mail->isHTML(true);

    $mail->AddAddress($e_address);
   
    if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    // echo "Email sent";
    header('location:../../pettycash.php');
    	// echo "sent";
    }

 ?>