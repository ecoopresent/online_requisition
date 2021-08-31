<?php 
require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.petty_approval.php";

$petty_approval = new PettycashApproval();
$voucher_id = $_GET['id'];
$petty_info = $petty_approval->getPettyInfo($voucher_id);
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

//Close and output PDF document
$pdf->Output('PR.pdf', 'I');

 ?>