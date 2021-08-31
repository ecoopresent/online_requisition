<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.petty_approval.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$petty_approval = new PettycashApproval();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";  

        $status = Sanitizer::filter('status', 'get');
        $petty_approval = $petty_approval->getPettycashlist($status,$user_dept);
        foreach($petty_approval as $k=>$v) {
            $pettycash_status = $v['pettycash_status'];
            if($pettycash_status =="Disapproved"){
                $petty_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_Petty(".$v['id'].")'><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-success btn-sm' disabled=''><i class='fas fa-sm fa-check'></i> Approved</button>
                                              <button class='btn btn-danger btn-sm' disabled=''><i class='fas fa-sm fa-times'></i> Disapproved</button>";
            }else if($pettycash_status== "Approved"){
                $petty_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_Petty(".$v['id'].")'><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-warning btn-sm' onclick='send_Petty(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Send</button>";
            }
            else{
                $petty_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                              <button class='btn btn-secondary btn-sm' disabled=''><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-success btn-sm' onclick='approve_Petty(".$v['id'].")'><i class='fas fa-sm fa-check'></i> Approved</button>
                                              <button class='btn btn-danger btn-sm' onclick='disapprove_Petty(".$v['id'].")'><i class='fas fa-sm fa-times'></i> Disapproved</button>";
            }
            
        }
        $response = array("data" => $petty_approval);
        break;

    case "UpdateStat";

        $id = Sanitizer::filter('id', 'post');
        $pettycash_status = Sanitizer::filter('pettycash_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $petty_approval->UpdateStatus($id,$pettycash_status,$approver,$remarks);
        $response = array("code"=>1,"message"=>"Petty Cash Status Updated");
        break;

    case "UpdateStatcash";

        $id = Sanitizer::filter('id', 'post');
        $pettycash_status = Sanitizer::filter('pettycash_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $petty_approval->UpdateStatcash($id,$pettycash_status,$approver,$remarks);
        $response = array("code"=>1,"message"=>"Petty Cash Status Updated");
        break;

    case "UpdateStatFinal";

        $id = Sanitizer::filter('id', 'post');
        $pettycash_status = Sanitizer::filter('pettycash_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $petty_approval->UpdateStatusFinal($id,$pettycash_status,$approver,$remarks);
        $response = array("code"=>1,"message"=>"Petty Cash Status Updated");
        break;

    case "checkPetty";

        $id = Sanitizer::filter('id', 'post');
        $response = $petty_approval->check_Petty($id);
        break;


}


echo json_encode($response);



 ?>