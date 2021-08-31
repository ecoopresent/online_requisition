<?php 
require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.reports.php";

$reports = new Reports();
$date_prepared = $_GET['date'];
$date_preparedto = $_GET['dateto'];
$rca_list = $reports->getPettylist($date_prepared,$date_preparedto);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('PETTY CASH SUMMARY');
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
					<td style="border: 1px solid black;text-align:center;font-size: 14px;background-color: lightgray"><b>PETTY CASH REPORTS</b></td>
				</tr>

				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
				</tr>

				<tr>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Voucher No</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Department</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Voucher Date</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Particulars</b></td>
					<td style="width: 25%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Cash Advance</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>Actual Amount</b></td>
				</tr>';

foreach($rca_list as $k=>$v) {

	$html .= '<tr>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['voucher_no'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['department'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['voucher_date'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['particulars'].'</td>
					<td style="width: 25%;border: 1px solid #0d0d0d" align="center">'.$v['cash_advance'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['actual_amount'].'</td>
				</tr>';
}


 	$html .= '</table>';

if($_GET['action'] == "pdf"){
$pdf->writeHTML($html, true, false, true, false, '');
ob_end_clean();
$pdf->Output('PettycashReports.pdf', 'I');
}

if($_GET['action'] == "excel"){

        $backup_name = "PettycashReports.xls";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $html;
        exit;

}
 ?>