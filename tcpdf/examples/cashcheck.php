<?php 
require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.cash_approval.php";

$cash_approval = new Cash_approval();
$cash_id = $_GET['id'];
$cash_info = $cash_approval->getCashadvanceById($cash_id);
// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$thermalSize = array(140, 202);

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

$extra_approver = $cash_info['head_approver'].'<br> Signed '.$cash_info['date_headapproved'].'<br>';
if($cash_info['head_approver']=="" || $cash_info['date_headapproved']=="0000-00-00"){
	$extra_approver = "";
}
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
					<td style="border-left: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px;height: 100px">'.number_format($cash_info['amount'],2).'</td>
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
					<td colspan="2" style="border-left: 1px solid black;width: 25%;font-size: 10px;text-align:center">'.$cash_info['prepared_by'].'<br> Signed '.$cash_info['date_prepared'].'</td>
					<td style="border-left: 1px solid black;width: 25%;font-size: 10px;text-align:center">'.$extra_approver.''.$cash_info['department_head'].'<br> Signed '.$cash_info['date_preapproved'].'</td>
					<td style="width: 25%;font-size: 10px;text-align:center">'.$cash_info['president'].'<br> Signed '.$cash_info['date_approved'].'</td>
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
$pdf->Output('PR.pdf', 'I');

 ?>