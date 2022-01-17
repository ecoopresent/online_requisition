<?php 

// error_reporting(E_ALL);require 'Exception.php';require 'PHPMailer.php';require 'SMTP.php';require 'PHPMailerAutoload.php';
// $mail = new PHPMailer();$mail->Host = "smtp.pmc.ph";$mail->IsHTML(true);$mail->Username = "no-reply@pmc.ph";$mail->Password = "Unimex123!";$mail->SetFrom("no-reply@pmc.ph", "");

$e_address = "jericopresentacion08@gmail.com";
// $e_address = "ntngo@pmcgroup.com";

require 'PHPMailer\src\Exception.php';require 'PHPMailer\src\PHPMailer.php';require 'PHPMailer\src\SMTP.php';require 'PHPMailer\src\PHPMailerAutoload.php';
$mail = new PHPMailer();$mail->IsSMTP();$mail->SMTPDebug = 0;$mail->SMTPAuth = true;$mail->SMTPSecure = 'ssl';$mail->Host = "smtp.gmail.com";$mail->Port = 465;$mail->IsHTML(true);$mail->Username = "pmcmailchimp@gmail.com";$mail->Password = "1_pmcmailchimp@gmail.com";$mail->SetFrom("inquiry@inmed.com.ph", "");




require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.purchasing.php";
require_once "../../model/model.canvasing.php";

$canvasing = new Canvasing();
$purchasing = new Purchasing();
$pr_id = $_GET['id'];
$pr_details = $purchasing->getPRDetails($pr_id);
$pr_info = $purchasing->getPRInfo($pr_id);
$canvas_info = $canvasing->getCanvasInfo($pr_id);
$canvas_id = $canvas_info['canvas_id'];
$canvas_details = $canvasing->getCanvasDetails($canvas_id);
$name_Approver = "Homer C. Lim";
$depts = $pr_info['department'];

$pr_number = $pr_info['pr_no'];
$mail->Subject = "Dept: ".$depts."- Canvass Requisition ( ".$pr_number." )";
$newFolder = "CANVAS".date('Y')."(".$pr_id.")";
$canvas_attachments = $canvasing->getAttachments($pr_id);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Purchase Requisition');
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
$pdf->AddPage('P','A4');
$pdf->setJPEGQuality(75);
// Image example with resizing
$pdf->Image('logo.png', 7, 7,63, 15, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

// print a message
$txt = "";
$pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
$pdf->SetY(1);
// $pdf->setCellPaddings( $left = '', $top = '2', $right = '', $bottom = '2');
$pdf->setCellPadding(1);
// -----------------------------------------------------------------------------
$html = '';
$html .= '<table width="100%" style="font-size: 11px">
				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td style="width: 62%"></td>
					<td style="border: 1px solid black;text-align:center;font-size: 14px;background-color: lightgray"><b>PURCHASE REQUISITION</b></td>
				</tr>

				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td style="width: 27%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>DEPARTMENT</b></td>
					<td style="width: 29%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>DATE PREPARED</b></td>
					<td style="width: 23%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>DATE NEEDED</b></td>
					<td style="width: 21%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>PR NO.</b></td>
				</tr>
				<tr>
					<td style="width: 27%;border: 1px solid #0d0d0d" align="center">'.$pr_info['department'].'</td>
					<td style="width: 29%;border: 1px solid #0d0d0d" align="center">'.$pr_info['date_prepared'].'</td>
					<td style="width: 23%;border: 1px solid #0d0d0d" align="center">'.$pr_info['date_needed'].'</td>
					<td style="width: 21%;border: 1px solid #0d0d0d" align="center">'.$pr_info['pr_no'].'</td>
				</tr>
				<tr>
					<td style="width: 100%;border: 1px solid #0d0d0d" align="left"><b>PURPOSE: </b>'.$pr_info['purpose'].'</td>
				</tr>
				<tr>
					<td style="width: 17%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>ITEM CODE</b></td>
					<td style="width: 10%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>STOCK ON HAND</b></td>
					<td style="width: 9%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>RQMT</b></td>
					<td style="width: 8%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>UOM</b></td>
					<td style="width: 56%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>ITEM DESCRIPTION</b></td>
				</tr>';

$a = 8;
$b = 0;
foreach($pr_details as $k=>$v) {
	$b++;
	$html .= '<tr>
					<td style="width: 17%;border: 1px solid #0d0d0d" align="center">'.$v['item_code'].'</td>
					<td style="width: 10%;border: 1px solid #0d0d0d" align="center">'.$v['stock'].'</td>
					<td style="width: 9%;border: 1px solid #0d0d0d" align="center">'.$v['rqmt'].'</td>
					<td style="width: 8%;border: 1px solid #0d0d0d" align="center">'.$v['uom'].'</td>
					<td style="width: 56%;border: 1px solid #0d0d0d" align="center">'.$v['item_description'].'</td>
				</tr>';
}

$rows = $a - $b;
for($x=0;$x<$rows;$x++){
	$html .= '<tr>
					<td style="width: 17%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 10%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 9%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 8%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 56%;border: 1px solid #0d0d0d" align="center"></td>
				</tr>';
}

 	  $html .= '<tr>
					<td style="width: 21%;border-left: 1px solid #0d0d0d" align="left"><b>REQUESTED BY:</b></td>
					<td style="width: 29%;border-bottom: 1px solid #0d0d0d" align="center">'.$pr_info['requested_by'].'<br>Signed '.$pr_info['date_prepared'].'</td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d" align="left"><b>APPROVED BY:</b></td>
					<td style="width: 29%;border-bottom: 1px solid #0d0d0d;border-right: 1px solid #0d0d0d" align="center">'.$pr_info['approved_by'].'<br>Signed '.$pr_info['date_approve'].'</td>
				</tr>
				<tr>
					<td style="width: 21%;border-left: 1px solid #0d0d0d;border-bottom: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 29%;border-bottom: 1px solid #0d0d0d" align="center">PRINT NAME-SIGN</td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d;border-bottom: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 29%;border-bottom: 1px solid #0d0d0d;border-right: 1px solid #0d0d0d" align="center">DEPT HEAD</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td style="width: 62%;font-size: 15px">FOR PURCHASING USE ONLY</td>
					<td style="width: 38%;border: 1px solid black;text-align:center;font-size: 14px;background-color: lightgray"><b>CANVASS SHEET</b></td>
				</tr>
				<tr>
					<td></td>
				</tr>
 </table>';

 	$html .= '<table width="100%" style="font-size: 11px">
				<tr>
					<td style="width: 100%;border: 1px solid #0d0d0d" align="left"><b>DATE: </b>'.$canvas_info['canvas_date'].'</td>
				</tr>
				<tr>
					<td style="width: 5%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center" rowspan="4"><b>QTY</b></td>
					<td style="width: 5%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center" rowspan="4"><b>UOM</b></td>
					<td style="width: 25%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center" rowspan="4"><b>PRODUCT DESCRIPTION</b></td>
					<td style="width: 13%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>SUPPLIER</b></td>
					<td style="width: 13%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>SUPPLIER</b></td>
					<td style="width: 13%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>SUPPLIER</b></td>
					<td style="width: 13%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>SUPPLIER</b></td>
					<td style="width: 13%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>SUPPLIER</b></td>
				</tr>
				<tr>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
				</tr>
				<tr>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
				</tr>
				<tr>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$canvas_info['supplier1'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$canvas_info['supplier2'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$canvas_info['supplier3'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$canvas_info['supplier4'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$canvas_info['supplier5'].'</td>
				</tr>';

$c = 0;
$totalprice1 = 0;
$totalprice2 = 0;
$totalprice3 = 0;
$totalprice4 = 0;
$totalprice5 = 0;
foreach ($canvas_details as $kk => $vv) {
	$c++;

	$totalprice1 += $vv['price1'];
	$totalprice2 += $vv['price2'];
	$totalprice3 += $vv['price3'];
	$totalprice4 += $vv['price4'];
	$totalprice5 += $vv['price5'];


	if($vv['price1']==0){
		$vv['price1'] = "";
		$priceUnit1 = "";
	}else{
		$priceUnit1 = $vv['price1'] / $vv['qty'];
		$priceUnit1 = number_format($priceUnit1,2);
		$vv['price1'] = number_format($vv['price1'],2);
	}
	if($vv['price2']==0){
		$vv['price2'] = "";
		$priceUnit2 = "";
	}else{
		$priceUnit2 = $vv['price2'] / $vv['qty'];
		$priceUnit2 = number_format($priceUnit2,2);
		$vv['price2'] = number_format($vv['price2'],2);
	}
	if($vv['price3']==0){
		$vv['price3'] = "";
		$priceUnit3 = "";
	}else{
		$priceUnit3 = $vv['price3'] / $vv['qty'];
		$priceUnit3 = number_format($priceUnit3,2);
		$vv['price3'] = number_format($vv['price3'],2);
	}
	if($vv['price4']==0){
		$vv['price4'] = "";
		$priceUnit4 = "";
	}else{
		$priceUnit4= $vv['price4'] / $vv['qty'];
		$priceUnit4 = number_format($priceUnit4,2);
		$vv['price4'] = number_format($vv['price4'],2);
	}
	if($vv['price5']==0){
		$vv['price5'] = "";
		$priceUnit5 = "";
	}else{
		$priceUnit5 = $vv['price5'] / $vv['qty'];
		$priceUnit5 = number_format($priceUnit5,2);
		$vv['price5'] = number_format($vv['price5'],2);
	}
	if($vv['qty']==0){
		$vv['qty'] = "";
	}else{
		$vv['qty'] = number_format($vv['qty']);
	}



	$html .= '<tr>
					<td style="width: 5%;border: 1px solid #0d0d0d" align="center">'.$vv['qty'].'</td>
					<td style="width: 5%;border: 1px solid #0d0d0d" align="center">'.$vv['uom'].'</td>
					<td style="width: 25%;border: 1px solid #0d0d0d" align="center">'.$vv['product_desc'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d;font-size: 10px" align="left">Price: '.$priceUnit1.'<br><b>Total:</b> '.$vv['price1'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d;font-size: 10px" align="left">Price: '.$priceUnit2.'<br><b>Total:</b> '.$vv['price2'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d;font-size: 10px" align="left">Price: '.$priceUnit3.'<br><b>Total:</b> '.$vv['price3'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d;font-size: 10px" align="left">Price: '.$priceUnit4.'<br><b>Total:</b> '.$vv['price4'].'</td>
					<td style="width: 13%;border: 1px solid #0d0d0d;font-size: 10px" align="left">Price: '.$priceUnit5.'<br><b>Total:</b> '.$vv['price5'].'</td>
				</tr>';	


}

			$html .= '<tr>
								<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 25%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
							</tr>';

				if($totalprice1==0){
					$totalprice1 = "";
				}else{
					$totalprice1 = number_format($totalprice1,2);
				}
				if($totalprice2==0){
					$totalprice2 = "";
				}else{
					$totalprice2 = number_format($totalprice2,2);
				}
				if($totalprice3==0){
					$totalprice3 = "";
				}else{
					$totalprice3 = number_format($totalprice3,2);
				}
				if($totalprice4==0){
					$totalprice4 = "";
				}else{
					$totalprice4 = number_format($totalprice4,2);
				}
				if($totalprice5==0){
					$totalprice5 = "";
				}else{
					$totalprice5 = number_format($totalprice5,2);
				}

				$html .= '<tr>
								<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
								<td style="width: 25%;border: 1px solid #0d0d0d" align="center"><b>TOTAL:</b></td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$totalprice1.'</td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$totalprice2.'</td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$totalprice3.'</td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$totalprice4.'</td>
								<td style="width: 13%;border: 1px solid #0d0d0d" align="center">'.$totalprice5.'</td>
							</tr>';	


$d = 6;
$rows = $d - $c;
for($x=0;$x<$rows;$x++){

	$html .= '<tr>
					<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 5%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 25%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 13%;border: 1px solid #0d0d0d" align="center"></td>
				</tr>';	

}
$dept_sign = "";
if($pr_info['department']=="IT"){
	$dept_sign = $canvas_info['operation_incharge'].'<br>Signed '.$canvas_info['oi_date_approved'];
}
	$html .= '<tr>
					<td style="width: 16%;border-left: 1px solid #0d0d0d" align="left"><b>REMARKS:</b></td>
					<td style="width: 40%" align="center">'.$canvas_info['remarks'].'</td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d" align="left"><b>APPROVED FOR P.O.:</b></td>
					<td style="width: 23%;border-right: 1px solid #0d0d0d" align="center"></td>
				</tr>
				<tr>
					<td style="width: 16%;border-left: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 40%" align="center"></td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d" align="center">'.$dept_sign.'</td>
					<td style="width: 23%;border-right: 1px solid #0d0d0d" align="center">'.$canvas_info['approved_by'].'<br>Signed '.$canvas_info['date_approved'].'</td>
				</tr>
				<tr>
					<td style="width: 16%;border-left: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 40%" align="center"></td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d;border-top: 1px solid #0d0d0d" align="center">DEPT. HEAD</td>
					<td style="width: 23%;border-right: 1px solid #0d0d0d;border-top: 1px solid #0d0d0d" align="center">PRESIDENT</td>
				</tr>
				<tr>
					<td style="width: 16%;border-left: 1px solid #0d0d0d;border-bottom: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 40%;border-bottom: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 21%;border-left: 1px solid #0d0d0d;border-bottom: 1px solid #0d0d0d" align="center"></td>
					<td style="width: 23%;border-bottom: 1px solid #0d0d0d;border-right: 1px solid #0d0d0d" align="center"></td>
				</tr>';

	$html .= '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln();

//Close and output PDF document
$pdfname = 'Purchase Request.pdf';
// $pdffile = $pdf->Output('PR.pdf', 'I');
// exit();
$pdffile = $pdf->Output('PR.pdf', 'S');

	// $badie = "<br><a href='http://192.168.101.41/online_requisition/controller/controller.canvasing.php?mode=UpdateCanvas&type=Approve&pr_id=$pr_id' style='text-decoration: none;padding: 10px;font-size: 20px;background-color: green;color: white;border-radius: 5px;'>Approve</a> <a href='http://192.168.101.41/online_requisition/controller/controller.canvasing.php?mode=UpdateCanvas&type=Disapprove&pr_id=$pr_id' style='text-decoration: none;padding: 10px;font-size: 20px;background-color: red;color: white;border-radius: 5px;'>Disapprove</a><br>";

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
                            <img src="https://pmc.ph/assets/logo.png" width="160" style="display: block; margin: auto" />
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                    <tr>
                        <td style="padding:80px 50px; background-color:#F8F7F0;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 18px; font-weight: bold; line-height:30px;text-align:center;">
                                            Approved Canvass Requisition
                                        </td>
                                    </tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>

                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    <tr><td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;"></td></tr>
                                    
                                    <tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 16px; line-height:30px;text-align:center;">
                                            Please see attached files.
                                        </td>
                                    </tr>';
                    foreach($canvas_attachments as $k=>$v) {
                        $link_name = "http://localhost/online_requisition/attachments/".$newFolder."/".$v['attachment']; 
                         $badie .= '<tr>
                                        <td style="padding:5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;text-align:center;"><a href="'.$link_name.'">'.$v['attachment'].' (Click to open)</a></td>
                                    </tr>';

                    }

                    $badie .= '</tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                    <tr>
                        <td width="100%" style="min-width:100%;background-color:#58585A;color:#ffffff;padding:30px;">
                            <p style="font-size:12px;line-height:20px;font-family: Arial,sans-serif;text-align:center;">&copy;2021 Progressive Medical Corporation</p>
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
    
    // foreach($canvas_attachments as $k=>$v) {

    // $file_to_attach = '../../attachments/'.$newFolder.'/'.$v['attachment'];
    // $mail->AddAttachment( $file_to_attach , $v['attachment'] );

    // }

    if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
    // echo "Email sent";
    header('location:../../approvalCanvas.php?id='.$pr_id.'&approver=');
    }


 ?>