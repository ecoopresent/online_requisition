<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.accounting.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$accounting = new Accounting();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $cash_status = Sanitizer::filter('cash_status', 'get');
        $accounting = $accounting->getCashlist($cash_status);
        foreach($accounting as $k=>$v) {
            $cash_status = $v['cash_status'];
            $cashstatus = "";

              $accounting[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>";
                                              $cashstatus = $cash_status;

            $pr_id = $v['pr_id'];
            $rca_txt = "RCAPR".date('Y').$pr_id;
            if($pr_id==0){
                $rca_txt = "RCA".date('Y').'-'.$v['id'];
            }

            $accounting[$k]['rca'] = $rca_txt;
            $accounting[$k]['cashstatus'] = $cashstatus;
            
        }
        $response = array("data" => $accounting);
        break;

    case  "status";
        $id = Sanitizer::filter('id', 'post', 'int');
        $cash_status = Sanitizer::filter('cash_status', 'post');
        $accounting->UpdateStatus($id,$cash_status);
        $response = array("code"=>1, "message"=>"Updated Status");
        break;

    case "UpdateCashadvance";
        $type = Sanitizer::filter('type', 'get');
        $cash_id = Sanitizer::filter('cash_id', 'get');
        $accounting->Update_Cashadvance($type,$cash_id);
        $response = array("code"=>1,"message"=>"Cash Advanced Status Updated");
        exit();
        break;



}


echo json_encode($response);



 ?>