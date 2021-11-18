<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.rca.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$rca = new Rca();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {

	case "table";
        $rca = $rca->getRCAList($user_dept);
        foreach($rca as $k=>$v) {
            $rca[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='editRCA(".$v['id'].",\"".$v['department']."\",\"".$v['payee']."\",\"".$v['date_prepared']."\",\"".$v['date_needed']."\",\"".$v['particulars']."\",\"".$v['amount']."\",\"".$v['purpose']."\",\"".$v['remarks']."\",\"".$v['charge_to']."\",\"".$v['budget']."\",\"".$v['liquidated_on']."\",\"".$v['prepared_by']."\")'><i class='fas fa-sm fa-pencil-alt'></i> Edit</button>
            <button class='btn btn-danger btn-sm' onclick='deleteRCA(".$v['id'].")'><i class='fas fa-sm fa-trash-alt'></i> Delete</button>
            <button class='btn btn-success btn-sm' onclick='addAttach(".$v['id'].")'><i class='fas fa-sm fa-paperclip'></i> Attach</button>
            <button class='btn btn-warning btn-sm' onclick='sendRCA(".$v['id'].",\"".$v['prepared_by']."\")'><i class='fas fa-sm fa-paper-plane'></i> Send</button>";
            $pr_id = $v['pr_id'];
            $rca_txt = "RCAPR".date('Y').$v['id'];
            if($pr_id==0){
                $rca_txt = "RCA".date('Y').'-'.$v['id'];
            }
            $rca[$k]['rca_no'] = $rca_txt;
        }
        $response = array("data" => $rca);
        break;

    case "tableDone";
        $status = Sanitizer::filter('status', 'get');
        $rca = $rca->getRCAListdone($user_dept,$status);
        foreach($rca as $k=>$v) {

            if($status == "Finished" || $status == "Disapproved"){
                $rca[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='viewRCA(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>";
            }else if($status == "Submitted"){
                $rca[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='viewRCA(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button> <button class='btn btn-success btn-sm' onclick='sendRCA(".$v['id'].",\"".$v['prepared_by']."\")'><i class='fas fa-sm fa-paper-plane'></i> Resend</button>";
            }else{
                $rca[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='viewRCA(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button> <button class='btn btn-success btn-sm' onclick='resendRCA(".$v['id'].",\"".$v['approver_type']."\")'><i class='fas fa-sm fa-paper-plane'></i> Resend</button>";
            }
            $approvers = "";
            if($v['approver_type']=="one"){
                $approvers = "JTC";
            }else if($v['approver_type']=="oneB"){
                $approvers = "STP";
            }else if($v['approver_type']=="two"){
                $approvers = "JTC & HCL";
            }else if($v['approver_type']=="twoC"){
                $approvers = "JDP & JTC";
            }else if($v['approver_type']=="twoE"){
                $approvers = "JCP & JTC";
            }else if($v['approver_type']=="twoF"){
                $approvers = "JAL & JTC";
            }else if($v['approver_type']=="twoD"){
                $approvers = "NGC & HCL";
            }else if($v['approver_type']=="twoD2"){
                $approvers = "MPM & HCL";
            }else if($v['approver_type']=="threeB"){
                $approvers = "AGS & JTC & HCL";
            }else if($v['approver_type']=="threeC"){
                $approvers = "JTC & MPM & HCL";
            }else{
                $approvers = "JCP & JTC & HCL";
            }
            $rca[$k]['approvers'] = $approvers;
            $pr_id = $v['pr_id'];
            $rca_txt = "RCAPR".date('Y').$v['id'];
            if($pr_id==0){
                $rca_txt = "RCA".date('Y').'-'.$v['id'];
            }
            $rca[$k]['rca_no'] = $rca_txt;
            
        }
        $response = array("data" => $rca);
        break;

    case "tableAttach";
        $cashcheck_id = Sanitizer::filter('cashcheck_id', 'get');
        $rca = $rca->getAttachments($cashcheck_id);
        foreach($rca as $k=>$v) {
            $newFolder = "RCA".date('Y')."-".$cashcheck_id;
            $rca[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='openAttachment(\"".$v['attachment']."\",\"".$newFolder."\")'><i class='fas fa-sm fa-eye'></i> Open</button> 
            <button class='btn btn-danger btn-sm' onclick='deleteAttachment(".$v['id'].",\"".$v['attachment']."\",".$v['cashcheck_id'].")'><i class='fas fa-sm fa-trash-alt'></i> Delete</button>";
        }
        $response = array("data" => $rca);
        break;

    case "add";
        $department = Sanitizer::filter('department', 'post');
        $payee = Sanitizer::filter('payee', 'post');
        $date_prepared = Sanitizer::filter('date_prepared', 'post');
        $date_needed = Sanitizer::filter('date_needed', 'post');
        $particulars = Sanitizer::filter('particulars', 'post');
        $amount = Sanitizer::filter('amount', 'post');
        $purpose = Sanitizer::filter('purpose', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $charge_to = Sanitizer::filter('charge_to', 'post');
        $budget = Sanitizer::filter('budget', 'post');
        $liquidated_on = Sanitizer::filter('liquidated_on', 'post');
        $prepared_by = Sanitizer::filter('prepared_by', 'post');
        $rca->addRCA($department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$prepared_by);
        $response = array("code"=>1, "message"=>"Data saved");
        break;

    case "update";
        $cash_id = Sanitizer::filter('cash_id', 'post');
        $department = Sanitizer::filter('department', 'post');
        $payee = Sanitizer::filter('payee', 'post');
        $date_prepared = Sanitizer::filter('date_prepared', 'post');
        $date_needed = Sanitizer::filter('date_needed', 'post');
        $particulars = Sanitizer::filter('particulars', 'post');
        $amount = Sanitizer::filter('amount', 'post');
        $purpose = Sanitizer::filter('purpose', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $charge_to = Sanitizer::filter('charge_to', 'post');
        $budget = Sanitizer::filter('budget', 'post');
        $liquidated_on = Sanitizer::filter('liquidated_on', 'post');
        $prepared_by = Sanitizer::filter('prepared_by', 'post');
        $rca->updateRCA($cash_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$prepared_by);
        $response = array("code"=>1, "message"=>"Data updated");
        break;

    case "delete";
        $id = Sanitizer::filter('id', 'post');
        $rca->deleteRCA($id,$user_dept);
        $response = array("code"=>1, "message"=>"Data Deleted");
        break;

    case "deleteAttach";
        $id = Sanitizer::filter('id', 'post');
        $attachment = Sanitizer::filter('attachment', 'post');
        $cashcheck_id = Sanitizer::filter('cashcheck_id', 'post');
        $rca->deleteAttche($id,$attachment,$cashcheck_id);
        $response = array("code"=>1, "message"=>"Data Deleted");
        break;

    case "submit";
        $id = Sanitizer::filter('id', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $rca->submitRCA($id,$approver);
        $response = array("code"=>1, "message"=>"Data Submitted");
        break;

    case "upload";

        $cashcheck_id = Sanitizer::filter('cashcheck_id', 'post');
        $newFolder = "RCA".date('Y')."-".$cashcheck_id;
        mkdir("../attachments/".$newFolder);
        $target_dir = "../attachments/".$newFolder."/";
        $file = $_FILES['rca_attachment']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $attachfile = $filename.".".$ext;
        $temp_name = $_FILES['rca_attachment']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        $attachment_name = $filename.".".$ext;
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            $response = array('code'=>0,'message'=>'Upload failed. File already exists.');
        } else {
            move_uploaded_file($temp_name,$path_filename_ext);
            $rca->saveRCA_Attachment($cashcheck_id,$attachment_name);
            header('location: ../rca.php');
            // $response = array('code'=>1,'message'=>$cashcheck_id);
        }
        
        
        break;

}


echo json_encode($response);



 ?>