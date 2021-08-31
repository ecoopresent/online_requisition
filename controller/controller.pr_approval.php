<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.pr_approval.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$pr_approval = new Pr_approval();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $status = Sanitizer::filter('status', 'get');
        $pr_approval = $pr_approval->getPRlist($status,$user_dept);
        foreach($pr_approval as $k=>$v) {
            $pr_status = $v['pr_status'];
            if($pr_status =="Disapproved" || $pr_status== "Approved"){
                $pr_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>
                                              <button class='btn btn-secondary btn-sm' onclick='undo_PR(".$v['id'].")'><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-success btn-sm' disabled=''><i class='fas fa-sm fa-check'></i> Approved</button>
                                              <button class='btn btn-danger btn-sm' disabled=''><i class='fas fa-sm fa-times'></i> Disapproved</button>";
            }else if($pr_status =="Canvassed" || $pr_status =="Finished" || $pr_status =="Rejected"){
                $pr_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>
                                              <button class='btn btn-secondary btn-sm' disabled=''><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-success btn-sm' disabled=''><i class='fas fa-sm fa-check'></i> Approved</button>
                                              <button class='btn btn-danger btn-sm' disabled=''><i class='fas fa-sm fa-times'></i> Disapproved</button>";
            }else{
                $pr_approval[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View</button>
                                              <button class='btn btn-secondary btn-sm' disabled=''><i class='fas fa-sm fa-undo'></i> Undo</button>
                                              <button class='btn btn-success btn-sm' onclick='approve_PR(".$v['id'].")'><i class='fas fa-sm fa-check'></i> Approved</button>
                                              <button class='btn btn-danger btn-sm' onclick='disapprove_PR(".$v['id'].")'><i class='fas fa-sm fa-times'></i> Disapproved</button>";
            }
            
        }
        $response = array("data" => $pr_approval);
        break;

    case  "status";
        $id = Sanitizer::filter('id', 'post', 'int');
        $pr_status = Sanitizer::filter('pr_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $pr_approval->UpdateStatus($id,$pr_status,$approver,$remarks);
        $response = array("code"=>1, "message"=>"Updated Status");
        break;

    case "addPR";
        $department = Sanitizer::filter('department', 'post');
        $date_prepared = Sanitizer::filter('date_prepared', 'post');
        $date_needed = Sanitizer::filter('date_needed', 'post');
        $pr_no = Sanitizer::filter('pr_no', 'post');
        $purpose = Sanitizer::filter('purpose', 'post');
        $last_id = $pr->addPRequest($department,$date_prepared,$date_needed,$pr_no,$purpose);
        $response = array("code"=>1, "last_id"=>$last_id);
        break;

    case "addPR_details";
        $item_code = Sanitizer::filter('item_code', 'post');
        $stock = Sanitizer::filter('stock', 'post');
        $rqmt = Sanitizer::filter('rqmt', 'post');
        $uom = Sanitizer::filter('uom', 'post');
        $item_description = Sanitizer::filter('item_description', 'post');
        $pr_id = Sanitizer::filter('pr_id', 'post');
        $pr->addPRdetails($item_code,$stock,$rqmt,$uom,$item_description,$pr_id);
        $response = array("code"=>1, "message"=>"PR details Added");
        break;

    case "UpdatePR_details";
        $item_code = Sanitizer::filter('item_code', 'post');
        $stock = Sanitizer::filter('stock', 'post');
        $rqmt = Sanitizer::filter('rqmt', 'post');
        $uom = Sanitizer::filter('uom', 'post');
        $item_description = Sanitizer::filter('item_description', 'post');
        $id = Sanitizer::filter('id', 'post');
        $pr->updatePRdetails($item_code,$stock,$rqmt,$uom,$item_description,$id);
        $response = array("code"=>1, "message"=>"PR details Added");
        break;

    case "delete_PRdetails";
        $id = Sanitizer::filter('id', 'post', 'int');
        $pr->deletePRdetails($id);
        $response = array("code"=>1, "message"=>"Client Deleted");
        break;

    case "submit";
        $pr_id = Sanitizer::filter('pr_id', 'post', 'int');
        $pr->submitPR($pr_id);
        $response = array("code"=>1, "message"=> "Submitted");
        break;


}


echo json_encode($response);



 ?>