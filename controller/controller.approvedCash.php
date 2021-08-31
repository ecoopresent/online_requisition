<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.approvedCash.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$approvedcash = new ApprovedCash();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $cash_status = Sanitizer::filter('cash_status', 'get');
        $approvedcash = $approvedcash->getCashlist($cash_status);
        foreach($approvedcash as $k=>$v) {
            $cash_status = $v['cash_status'];
            $cashstatus = "";
            if($cash_status =="Finished"){
                $approvedcash[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>
                                              <button class='btn btn-success btn-sm' onclick='check_Cash(".$v['id'].")'><i class='fas fa-sm fa-check'></i> Finish Transaction</button>
                                              <button class='btn btn-info btn-sm' onclick='attach_RCA(".$v['id'].")'><i class='fas fa-sm fa-paperclip'></i> Attachments</button>
                                              <button class='btn btn-danger btn-sm' onclick='decline_RCA(".$v['id'].")'><i class='fas fa-sm fa-times'></i> Decline</button>";
                                              $cashstatus = "Approved Canvassed";
            }else{
                $approvedcash[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Cash(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_Cash(".$v['id'].")'><i class='fas fa-sm fa-undo'></i> Undo</button>";
                                              $cashstatus = "Transaction Ended";
            }

            $approvedcash[$k]['cashstatus'] = $cashstatus;
            
        }
        $response = array("data" => $approvedcash);
        break;

    case  "status";
        $id = Sanitizer::filter('id', 'post', 'int');
        $cash_status = Sanitizer::filter('cash_status', 'post');
        $approvedcash->UpdateStatus($id,$cash_status,$full_name);
        $response = array("code"=>1, "message"=>"Updated Status");
        break;

    case "UpdateCashadvance";
        $type = Sanitizer::filter('type', 'get');
        $cash_id = Sanitizer::filter('cash_id', 'get');
        $approvedcash->Update_Cashadvance($type,$cash_id);
        header('location:../approvedCash.php');
        exit();
        break;

    case "declineRCA";
        $id = Sanitizer::filter('id', 'post');
        $approvedcash->declineRCA($id);
        $response = array("code"=>1, "message"=>"Updated Status");
        break;
    
    case "tableAttach";
        $cashcheck_id = Sanitizer::filter('cashcheck_id', 'get');
        $approvedcash = $approvedcash->getAttachments($cashcheck_id);
        foreach($approvedcash as $k=>$v) {
            $newFolder = "RCA".date('Y')."-".$cashcheck_id;
            $approvedcash[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='openAttachment(\"".$v['attachment']."\",\"".$newFolder."\")'><i class='fas fa-sm fa-eye'></i> Open</button>";
        }
        $response = array("data" => $approvedcash);
        break;



}


echo json_encode($response);



 ?>