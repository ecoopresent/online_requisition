<?php 

/* Exception class. */
   	require 'PHPMailer\src\Exception.php';

    /* The main PHPMailer class. */
    require 'PHPMailer\src\PHPMailer.php';

    /* SMTP class, needed if you want to use SMTP. */
    require 'PHPMailer\src\SMTP.php';

    require 'PHPMailer\src\PHPMailerAutoload.php';

require_once('tcpdf_include.php');

	$mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->IsHTML(true);
    $mail->Username = "pmcmailchimp@gmail.com";
    $mail->Password = "1_pmcmailchimp@gmail.com";


    $mail->SetFrom("inquiry@inmed.com.ph", "");
    $mail->Subject = "Cah Advance/Check Issuance";

require_once "../../controller/controller.db.php";
require_once "../../model/model.cash_approval.php";

$cash_approval = new Cash_approval();
$cash_id = $_GET['id'];
$cash_info = $cash_approval->getCashadvance($cash_id);
// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$thermalSize = array(129, 202);

$pdf = new TCPDF('L', 'mm', $thermalSize, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Request For Cash Advance/ Check issuance');
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

$html .= '<table width="100%" border="0" style="font-size: 11px">

				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td style="width:40%;"></td>
					<td colspan="3" style="border: 1px solid black;text-align:center;font-size: 14px;background-color: dimgray;color:white;width:60%;"><b>REQUEST FOR CASH ADVANCE/CHECK ISSUANCE</b></td>
				</tr>
				<tr>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 25%">DEPARTMENT DIVISION</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 25%">PAYEE</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 25%">DATE PREPARED</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px;width: 25%">DATE NEEDED</td>
				</tr>
				<tr>
					<td style="border-left: 1px solid black;text-align:center;font-size: 10px">'.$cash_info['department'].'</td>
					<td style="border-left: 1px solid black;text-align:center;font-size: 10px">'.$cash_info['payee'].'</td>
					<td style="border-left: 1px solid black;text-align:center;font-size: 10px">'.$cash_info['date_prepared'].'</td>
					<td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px">'.$cash_info['date_needed'].'</td>
				</tr>
				<tr>
					<td colspan="3" style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px">PARTICULARS</td>
					<td style="border: 1px solid black;text-align:center;font-size: 12px;background-color: dimgray;color:white;font-size: 10px">AMOUNT</td>
				</tr>
				<tr>
					<td colspan="3" style="border-left: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.$cash_info['particulars'].'</td>
					<td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.$cash_info['amount'].'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-top: 1px solid black;border-left: 1px solid black;width: 50%;font-size: 10px">PURPOSE: '.$cash_info['purpose'].'</td>
					<td colspan="2" style="border-top: 1px solid black;width: 50%;font-size: 10px;border-right: 1px solid black;border-left: 1px solid black">REMARKS/INSTRUCTION: '.$cash_info['remarks'].'</td>

				</tr>
				<tr>
					<td colspan="2" style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 34%;font-size: 9px;text-align:left">CHARGE TO: '.$cash_info['charge_to'].'</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 33%;font-size: 9px;text-align:left">BUDGET: '.$cash_info['budget'].'</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;border-right: 1px solid black;width: 33%;font-size: 9px;text-align:left">TO BE LIQUIDATED ON: '.$cash_info['liquidated_on'].'</td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 25%;font-size: 10px">PREPARED BY:</td>
					<td colspan="2" style="border-left: 1px solid black;border-right: 1px solid black;width: 75%;font-size: 10px">APPROVED BY: </td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 25%;font-size: 10px"></td>
					<td colspan="2" style="border-left: 1px solid black;border-right: 1px solid black;width: 75%;font-size: 10px"></td>
				</tr>
				<tr>
					<td colspan="2" style="border-left: 1px solid black;width: 25%;font-size: 10px;text-align:center">'.$cash_info['prepared_by'].'</td>
					<td style="border-left: 1px solid black;width: 25%;font-size: 10px;text-align:center">'.$cash_info['department_head'].'</td>
					<td style="width: 25%;font-size: 10px;text-align:center">'.$cash_info['president'].'</td>
					<td style="border-right: 1px solid black;width: 25%;font-size: 10px;text-align:center">'.$cash_info['accounting'].'</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 25%;font-size: 9px;text-align:center">PRINT NAME & SIGN</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-left: 1px solid black;width: 25%;font-size: 9px;text-align:center">DEPARTMENT HEAD</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;width: 25%;font-size: 9px;text-align:center">PRESIDENT</td>
					<td style="border-top: 1px solid black;border-bottom:1px solid black;border-right: 1px solid black;width: 25%;font-size: 9px;text-align:center">ACCOUNTING</td>
				</tr>';

 $html .= '</table>';


// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln();

//Close and output PDF document
$pdfname = 'Cash Advance/Check Issuance.pdf';
$pdffile = $pdf->Output('CashAdvance.pdf', 'S');

	$badie = '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <title>Progressive Medical Corporation</title>
    <style>

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        img {
            -ms-interpolation-mode:bicubic;
        }

        a {
            text-decoration: none;
        }

        a[x-apple-data-detectors],
        .unstyle-auto-detected-links a,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }


        .im {
            color: inherit !important;
        }


        img.g-img + div {
            display: none !important;
        }



        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }

    </style>

    <style>

        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td-primary:hover,
        .button-a-primary:hover {
            background-color: #555555 !important;
            border-color: #555555 !important;
        }

        @media screen and (max-width: 600px) {

            .email-container p {
                font-size: 17px !important;
            }
            .block {
                display: none;
            }
        }

    </style>

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #d3d3d3;">
    <center style="width: 100%; background-color: #d3d3d3;">

        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            Progressive Medical Corporation Order Status Update
        </div>
        
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">

            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto; background-color: #fff;">
                
                <tr>
                    <td style="padding: 20px 0; text-align: center">
                        <img src="https://pmc.ph/assets/logo.png" width="200" height="50" alt="Panamed Philippines Inc." border="0" style="height: auto; background-color: #fff; font-family: sans-serif; font-size: 15px; line-height: 15px; color: #555555;">
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #ffffff;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="90%">
                            <tr>
                                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                                    <h1 style="    
                                    margin: 35px auto;
                                    font-family: sans-serif;
                                    font-size: 20px;
                                    line-height: 30px;
                                    color: #333333;
                                    font-weight: bold;
                                    text-align: left;
                                    text-transform: uppercase;
                                    letter-spacing: 1px;
                                    border-bottom: 1px solid #ddd;
                                    padding-bottom: 8px;">CANVAS REQUEST</h1>
                                    <p style="margin: 0;"><b>Good Day Sir</b>,<br><br>For your approval, Please See Attached Files</p>
                                    <br><br>
                  				</td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
               
                
                <tr>
                    <td style="background-color: #ffffff;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="90%">

                            <tr>
                                <td style="padding: 0 20px;">
                                    
                                    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                                        <tr>
                                            <td style="border-radius: 4px; font-size: 12px;">
                                                <a href="http://192.168.101.89/online_requisition/controller/controller.accounting.php?mode=UpdateCashadvance&type=Approve&cash_id=$cash_id" style="margin: 0; color: #fff; font-family: sans-serif;"><span style="padding: 13px 17px; background-color: #84ad22;">Approved</span></a> 
                                                <a href="http://192.168.101.89/online_requisition/controller/controller.accounting.php?mode=UpdateCashadvance&type=Disapprove&cash_id=$cash_id"  style="margin: 0; color: #fff; font-family: sans-serif;"><span style="padding: 13px 17px; background-color: #ff4d4d; border: 1px solid #ddd;">Disapproved</span></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><br><br><br></td>
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
            
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
                <!-- <tr>
                    <td style="padding: 20px; font-family: sans-serif; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff; background-color: #060b58;">
                        <br>
                        Progressive Medical Corporation<br><span class="unstyle-auto-detected-links">200 C. Raymundo Avenue Caniogan,<br>Pasig City 1606 Philippines</span>
                        <br>
                        
                        <br>
                    </td>
                </tr> -->
                <tr>
                    <td style="padding: 15px; font-family: sans-serif; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff; background-color: #83ae21;">
                    </td>
                </tr>
            </table>

        </div>

    </center>
</body>
</html>';


 	$mail->Body = $badie;
    $mail->addStringAttachment($pdffile,$pdfname);
    $mail->isHTML(true);

    $mail->AddAddress("jericopresentacion08@gmail.com");
   
    if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    // echo "Email sent";
    header('location:../../accounting.php');
    }


 ?>