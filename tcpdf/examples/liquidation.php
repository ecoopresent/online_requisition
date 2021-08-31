<?php 
require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.pettycash.php";

$pettycash = new Pettycash();
$id = $_GET['id'];
$liquidationInfo = $pettycash->check_Petty($id);
$liquidation_id = $liquidationInfo['id'];
$Routedetails = $pettycash->getliquidationdetails($liquidation_id);

// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$thermalSize = array(231, 180);

$pdf = new TCPDF('P', 'mm', $thermalSize, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Liquidation Transportation');
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
$pdf->Image('logo.png', 7, 7,58, 12, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

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
					<td colspan="5"></td>
				</tr>
				<tr>
					<td style="width:65%;"></td>
					<td colspan="4" style="text-align:left;font-size: 10px;width:35%;"><b>LIQUIDATION TRANSPORTATION</b></td>
				</tr>
				<tr>
					<td style="width:65%;"></td>
					<td colspan="4" style="text-align:left;font-size: 10px;width:35%;"><b>EXPENSE REPORT</b></td>
				</tr>
				<tr>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td style="width: 25%;border-left: 1px solid black;border-top: 1px solid black;font-size: 10px"><b>NAME OF EMPLOYEE:</b></td>
					<td colspan="2" style="width: 40%;border-top: 1px solid black;border-right: 1px solid black;font-size: 10px">'.$liquidationInfo['name'].'</td>
					<td style="width: 15%;border-top: 1px solid black;font-size: 10px"><b>DATE:</b></td>
					<td style="width: 20%;border-top: 1px solid black;border-right: 1px solid black;font-size: 10px">'.$liquidationInfo['liquidation_date'].'</td>
				</tr>
				<tr>
					<td style="width: 25%;border-left: 1px solid black;"></td>
					<td colspan="2" style="width: 40%;border-right: 1px solid black"></td>
					<td style="width: 15%;"></td>
					<td style="width: 20%;border-right: 1px solid black"></td>
				</tr>
				<tr>
					<td style="width: 37%;border-left: 1px solid black;border-top: 1px solid black;font-size: 10px"><b>BRANCH/DEPARTMENT/DIVISION:</b></td>
					<td colspan="2" style="width: 28%;border-top: 1px solid black;border-right: 1px solid black;font-size: 10px">'.$liquidationInfo['branch'].'</td>
					<td style="width: 15%;border-top: 1px solid black;font-size: 10px"><b>POSITION:</b></td>
					<td style="width: 20%;border-top: 1px solid black;border-right: 1px solid black;font-size: 10px">'.$liquidationInfo['position'].'</td>
				</tr>
				<tr>
					<td style="width: 37%;border-left: 1px solid black;"></td>
					<td colspan="2" style="width: 28%;border-right: 1px solid black"></td>
					<td style="width: 15%;"></td>
					<td style="width: 20%;border-right: 1px solid black"></td>
				</tr>
				<tr>
					<td colspan="2" style="width: 37%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px"><b>PARTICULARS/CUSTOMER/PLACE</b></td>
					<td style="width: 28%;border-right: 1px solid black;border-top: 1px solid black;text-align:center;font-size: 10px"><b>ROUTE</b></td>
					<td style="width: 20%;border-top: 1px solid black;border-right: 1px solid black;text-align:center;font-size: 10px"><b>VEHICLE TYPE</b></td>
					<td style="width: 15%;border-right: 1px solid black;border-top: 1px solid black;text-align:center;font-size: 10px"><b>AMOUNT</b></td>
				</tr>
				<tr>
					<td style="width: 37%;border-left: 1px solid black;border-right: 1px solid black;text-align:center"></td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center;font-size: 10px"><b>FROM</b></td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center;font-size: 10px"><b>TO</b></td>
					<td style="width: 20%;border-right: 1px solid black;text-align:center"></td>
					<td style="width: 15%;border-right: 1px solid black;text-align:center"></td>
				</tr>';
				
$a = 0; 
$b = 21;
$totalamount = 0;
foreach ($Routedetails as $k => $v) {

	if($a==1){
		$liquidationInfo['particulars'] = "";
	}
	$html .=	'<tr>
					<td style="width: 37%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align:center">'.$liquidationInfo['particulars'].'</td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center">'.$v['l_from'].'</td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center">'.$v['l_to'].'</td>
					<td style="width: 20%;border-right: 1px solid black;border-top: 1px solid black;text-align:center">'.$v['vehicle_type'].'</td>
					<td style="width: 15%;border-right: 1px solid black;border-top: 1px solid black;text-align:center">'.$v['amount'].'</td>
				</tr>';
	$a++;
	$totalamount += $v['amount'];

}
$rows = $b - $a;
for($x=0;$x<$rows;$x++){

	$html .=	'<tr>
					<td style="width: 37%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align:center"></td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center"></td>
					<td style="width: 14%;border-right: 1px solid black;border-top: 1px solid black;text-align:center"></td>
					<td style="width: 20%;border-right: 1px solid black;border-top: 1px solid black;text-align:center"></td>
					<td style="width: 15%;border-right: 1px solid black;border-top: 1px solid black;text-align:center"></td>
				</tr>';
}

	$html .=	'<tr>
					<td colspan="4" style="width: 85%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align:right;font-size: 10px"><b>TOTAL</b></td>
					<td style="width: 15%;border-right: 1px solid black;border-top: 1px solid black;text-align:center">'.$totalamount.'</td>
				</tr>
				<tr>
					<td colspan="3" style="width: 33%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;text-align:left;font-size: 10px"><b>PREPARED BY:</b></td>
					<td style="width: 34%;border-right: 1px solid black;border-top: 1px solid black;text-align:left;font-size: 10px"><b>CHECKED BY:</b></td>
					<td style="width: 33%;border-right: 1px solid black;border-top: 1px solid black;text-align:left;font-size: 10px"><b>APPROVED BY:</b></td>
				</tr>
				<tr>
					<td colspan="3" style="width: 33%;border-left: 1px solid black;border-right: 1px solid black;text-align:center">'.$liquidationInfo['prepared_by'].'</td>
					<td style="width: 34%;border-right: 1px solid black;text-align:center">'.$liquidationInfo['checked_by'].'</td>
					<td style="width: 33%;border-right: 1px solid black;text-align:center">'.$liquidationInfo['approved_by'].'</td>
				</tr>
				<tr>
					<td colspan="3" style="width: 33%;border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align:center;font-size: 10px"><b>PRINT NAME AND SIGN</b></td>
					<td style="width: 34%;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;text-align:center;font-size: 10px"><b>PRINT NAME AND SIGN</b></td>
					<td style="width: 33%;border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;text-align:center;font-size: 10px"><b>PRINT NAME AND SIGN</b></td>
				</tr>';

 $html .= '</table>';


// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln();

//Close and output PDF document
$pdf->Output('PR.pdf', 'I');

 ?>
