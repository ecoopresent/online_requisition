<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.reports.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");


$reports = new Reports();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";
        $date_prepared = Sanitizer::filter('date', 'get');
        $date_preparedto = Sanitizer::filter('dateto', 'get');
        $reports = $reports->getCashlist($date_prepared,$date_preparedto);
        foreach($reports as $k=>$v) {
            $cash_status = $v['cash_status'];
            $pr_id = $v['pr_id'];
            $yearprepared = date('Y', strtotime($v['date_prepared']));
            $voucher_id = "RCA".$yearprepared."-".$v['id'];
            if($pr_id==0){
                $voucher_id = "RCAPR".$yearprepared."-".$v['id'];
            }
        
            $reports[$k]['voucher_id'] = $voucher_id;
            $reports[$k]['amounts'] = number_format($v['amount'],2);

            $reports[$k]['cashstatus'] = "";
            
        }
        $response = array("data" => $reports);
        break;

    case "tablePetty";
        $date_prepared = Sanitizer::filter('date', 'get');
        $date_preparedto = Sanitizer::filter('dateto', 'get');
        $department = Sanitizer::filter('department', 'get');
        $reports = $reports->getPettylist($date_prepared,$date_preparedto,$department);
        foreach($reports as $k=>$v) {

            $reports[$k]['cash_advances'] = $v['cash_advance'];
            $reports[$k]['actual_amounts'] = $v['actual_amount'];
            

        }
        $response = array("data" => $reports);
        break;


}


echo json_encode($response);



 ?>