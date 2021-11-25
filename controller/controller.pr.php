<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.pr.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$pr = new Pr();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";
        $pr_id = Sanitizer::filter('pr_id', 'get');
        $pr = $pr->getPRDetails($pr_id);
        foreach($pr as $k=>$v) {
            $pr[$k]['action'] = "<button class='btn btn-info btn-sm' onclick='editPR_details(".$v['id'].",\"".$v['item_code']."\",\"".$v['stock']."\",\"".$v['rqmt']."\",\"".$v['uom']."\",\"".$v['item_description']."\")'><i class='fas fa-sm fa-pencil-alt'></i> Edit</button> 
								   <button class='btn btn-warning btn-sm' onclick='deletePR_details(".$v['id'].")'><i class='fas fa-sm fa-trash-alt'></i> Delete</button>";
        }
        $response = array("data" => $pr);
        break;

    case "tableList";

        $pr = $pr->getPRlist($full_name);
        foreach($pr as $k=>$v) {
            if($v['pr_status']=='Pending'){
                $pr[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='select_PR(".$v['id'].",\"".$v['pr_no']."\",\"".$v['pr_status']."\",\"".$v['purpose']."\",\"".$v['pr_type']."\")'><i class='fas fa-sm fa-mouse-pointer'></i> Open</button>
                                     <button class='btn btn-sm btn-success' onclick='edit_PR(".$v['id'].",\"".$v['department']."\",\"".$v['date_prepared']."\",\"".$v['date_needed']."\",\"".$v['pr_no']."\",\"".$v['purpose']."\",\"".$v['pr_type']."\")'><i class='fas fa-sm fa-edit'></i> Edit</button>
                                     <button class='btn btn-sm btn-danger' onclick='delete_PR(".$v['id'].")'><i class='fas fa-sm fa-trash'></i> Delete</button>";
            }else if($v['pr_status']=='Pre-Approved'){

                $pr[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='view_PRequest(".$v['id'].")'><i class='fas fa-sm fa-mouse-pointer'></i> Open</button>
                                     <button class='btn btn-sm btn-success' onclick='resend_PR(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Resend</button>";

            }
            else{
                $pr[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='select_PR(".$v['id'].",\"".$v['pr_no']."\",\"".$v['pr_status']."\",\"".$v['purpose']."\",\"".$v['pr_type']."\")'><i class='fas fa-sm fa-mouse-pointer'></i> Open</button>
                                     <button class='btn btn-sm btn-success' disabled=''><i class='fas fa-sm fa-edit'></i> Edit</button>
                                     <button class='btn btn-sm btn-danger' disabled=''><i class='fas fa-sm fa-trash'></i> Delete</button>";
            }
            

            
        }
        $response = array("data" => $pr);
        break;

    case "tableListdone";
        $status = Sanitizer::filter('status', 'get');
        $pr = $pr->getPRlistdone($status,$full_name);
        foreach($pr as $k=>$v) {

            $pr[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='view_PRequest(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PR</button>";

        }
        $response = array("data" => $pr);
        break;


    case "addPR";
        $department = Sanitizer::filter('department', 'post');
        $date_prepared = Sanitizer::filter('date_prepared', 'post');
        $date_needed = Sanitizer::filter('date_needed', 'post');
        $pr_no = Sanitizer::filter('pr_no', 'post');
        $purpose = Sanitizer::filter('purpose', 'post');
        $pr_type = Sanitizer::filter('pr_type', 'post');
        $last_id = $pr->addPRequest($department,$date_prepared,$date_needed,$pr_no,$purpose,$full_name,$pr_type);
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

    case "updatePR";
        $id = Sanitizer::filter('id', 'post');
        $department = Sanitizer::filter('department', 'post');
        $date_prepared = Sanitizer::filter('date_prepared', 'post');
        $date_needed = Sanitizer::filter('date_needed', 'post');
        $pr_no = Sanitizer::filter('pr_no', 'post');
        $purpose = Sanitizer::filter('purpose', 'post');
        $pr_pr_type = Sanitizer::filter('pr_pr_type', 'post');
        $pr->update_PR($id,$department,$date_prepared,$date_needed,$pr_no,$purpose,$pr_pr_type);
        $response = array("code"=>1, "message"=> "PR Updated");
        break;

    case "delete_PRdetails";
        $id = Sanitizer::filter('id', 'post', 'int');
        $pr->deletePRdetails($id);
        $response = array("code"=>1, "message"=>"Pr Details Deleted");
        break;

    case "deletePR";
        $id = Sanitizer::filter('id', 'post', 'int');
        $pr->delete_PR($id,$user_dept);
        $response = array("code"=>1, "message"=>"PR Deleted");
        break;

    case "submit";
        $pr_id = Sanitizer::filter('pr_id', 'post', 'int');
        $pr->submitPR($pr_id);
        $response = array("code"=>1, "message"=> "Submitted");
        break;

    case "submitTrade";
        $pr_id = Sanitizer::filter('pr_id', 'post', 'int');
        $pr->submitPRTrade($pr_id);
        $response = array("code"=>1, "message"=> "Submitted");
        break;

    case "getPR";

        $response = $pr->getPRno();
    break;

    case "countPR";
        $pr_id = Sanitizer::filter('pr_id', 'post');

        $response = $pr->count_Pr($pr_id);
    break;


}


echo json_encode($response);



 ?>