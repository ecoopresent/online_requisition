<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.petty_accountingLiquidate.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$accountingliquidate = new AccountingLiquidate();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";  

        $status = Sanitizer::filter('status', 'get');
        $accountingliquidate = $accountingliquidate->getPettycashlist($status,$user_dept);
        foreach($accountingliquidate as $k=>$v) {
            $pettycash_status = $v['pettycash_status'];
            if($pettycash_status== "Approved1"){
                $accountingliquidate[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                              <button class='btn btn-success btn-sm' onclick='finish_Petty(".$v['id'].")'><i class='fas fa-sm fa-check-circle'></i> Finish</button>
                                              <button class='btn btn-danger btn-sm' onclick='decline_Petty(".$v['id'].")'><i class='fas fa-sm fa-times'></i> Decline</button>";
            }else if($pettycash_status =="Finished"){
                $accountingliquidate[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_Petty(".$v['id'].")'><i class='fas fa-sm fa-undo'></i> Undo</button>";
            }else{
                $accountingliquidate[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>";
            }
            
        }
        $response = array("data" => $accountingliquidate);
        break;

    case "UpdateStat";
        $full_name = "Susan T. Panugayan";
        $id = Sanitizer::filter('id', 'get');
        $pettycash_status = Sanitizer::filter('pettycash_status', 'get');
        $accountingliquidate->UpdateStatus($id,$pettycash_status,$full_name);
        $response = array("code"=>1,"message"=>"Petty Cash Status Updated");
        break;

    case "checkPetty";

        $id = Sanitizer::filter('id', 'post');
        $response = $accountingliquidate->check_Petty($id);
        break;


}


echo json_encode($response);



 ?>