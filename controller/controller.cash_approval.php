<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.cash_approval.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$cash_approval = new Cash_approval();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $cash_status = Sanitizer::filter('cash_status', 'get');
        $cash_approval = $cash_approval->getCashlist($cash_status);
        foreach($cash_approval as $k=>$v) {
            $cash_status = $v['cash_status'];
            if($cash_status =="Disapproved" || $cash_status== "Approved"){
                $cash_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_Cash(".$v['id'].")'><i class='fas fa-sm fa-undo'></i></button>
                                              <button class='btn btn-success btn-sm' disabled=''><i class='fas fa-sm fa-check'></i></button>
                                              <button class='btn btn-danger btn-sm' disabled=''><i class='fas fa-sm fa-times'></i></button>";
            }else if($cash_status =="Canvassed" || $cash_status =="Finished" || $cash_status =="Rejected"){
                $cash_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>
                                              <button class='btn btn-secondary btn-sm' disabled=''><i class='fas fa-sm fa-undo'></i></button>
                                              <button class='btn btn-success btn-sm' disabled=''><i class='fas fa-sm fa-check'></i></button>
                                              <button class='btn btn-danger btn-sm' disabled=''><i class='fas fa-sm fa-times'></i></button>";
            }else{
                $cash_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>
                                              <button class='btn btn-secondary btn-sm' disabled=''><i class='fas fa-sm fa-undo'></i></button>
                                              <button class='btn btn-success btn-sm' onclick='approve_Cash(".$v['id'].")'><i class='fas fa-sm fa-check'></i></button>
                                              <button class='btn btn-danger btn-sm' onclick='disapprove_Cash(".$v['id'].")'><i class='fas fa-sm fa-times'></i></button>";
            }
            
        }
        $response = array("data" => $cash_approval);
        break;

    case  "status";
        $id = Sanitizer::filter('id', 'post', 'int');
        $cash_status = Sanitizer::filter('cash_status', 'post');
        $cash_approval->UpdateStatus($id,$cash_status,$full_name);
        $response = array("code"=>1, "message"=>"Updated Status");
        break;



}


echo json_encode($response);



 ?>