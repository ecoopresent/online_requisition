<?php 
require_once('tcpdf_include.php');
require_once "../../controller/controller.db.php";
require_once "../../model/model.reports.php";

$reports = new Reports();
$date_prepared = $_GET['date'];
$date_preparedto = $_GET['dateto'];
$rca_list = $reports->getCashlist($date_prepared,$date_preparedto);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('RCA SUMMARY');
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
					<td style="border: 1px solid black;text-align:center;font-size: 14px;background-color: lightgray"><b>RCA REPORTS</b></td>
				</tr>

				<tr>
					<td></td>
				</tr>
				<tr>
					<td></td>
				</tr>

				<tr>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>RCA ID</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>DEPARTMENT</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>DATE PREPARED</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>PARTICULARS</b></td>
					<td style="width: 25%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>REMARKS</b></td>
					<td style="width: 15%;background-color: #eeece1;border: 1px solid #0d0d0d" align="center"><b>AMOUNT</b></td>
				</tr>';

foreach($rca_list as $k=>$v) {
	$pr_id = $v['pr_id'];
	$yearprepared = date('Y', strtotime($v['date_prepared']));
    $voucher_id = "RCA".$yearprepared."-".$v['id'];
    if($pr_id==0){
        $voucher_id = "RCAPR".$yearprepared."-".$v['id'];
    }
	$html .= '<tr>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$voucher_id.'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['department'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['date_prepared'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.$v['particulars'].'</td>
					<td style="width: 25%;border: 1px solid #0d0d0d" align="center">'.$v['remarks'].'</td>
					<td style="width: 15%;border: 1px solid #0d0d0d" align="center">'.number_format($v['amount'],2).'</td>
				</tr>';
}


 	$html .= '</table>';

if($_GET['action'] == "pdf"){
$pdf->writeHTML($html, true, false, true, false, '');
ob_end_clean();
$pdf->Output('PR.pdf', 'I');
}

if($_GET['action'] == "excel"){

        $backup_name = "PR.xls";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $html;
        exit;

}
 ?>