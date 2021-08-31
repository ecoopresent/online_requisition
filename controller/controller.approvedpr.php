<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.approvedpr.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$approvedpr = new Approvedpr();
$approvedpr2 = new Approvedpr();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $canvas_status = Sanitizer::filter('canvas_status', 'get');
        $approvedpr = $approvedpr->getPRlist($canvas_status);
        foreach($approvedpr as $k=>$v) {

            $label = "";
            $id = $v['id'];
            $status = $approvedpr2->check_cashReq($id);
            if($status['cash_status']=="" || $status['cash_status']=="Pending"){
                $label = "PENDING";
            }else{
                $label = "SUBMITTED";
            }
            if($v['pr_status']== 'Rejected'){
                $label = "<span style='color:red'> REJECTED </span>";
            }

            $id = $status['id'];
            $department = $status['department'];
            $payee = $status['payee'];
            $date_prepared = $status['date_prepared'];
            $date_needed = $status['date_needed'];
            $particulars = $status['particulars'];
            $amount = $status['amount'];
            $purpose = $status['purpose'];
            $remarks = $status['remarks'];
            $charge_to = $status['charge_to'];
            $budget = $status['budget'];
            $liquidated_on = $status['liquidated_on'];
            $prepared_by = $status['prepared_by'];
            $cash_status = $status['cash_status'];
            if($department==""){
                $department = $v['department'];
            }

            if($v['pr_status'] == 'Rejected'){
                $approvedpr[$k]['action'] = "<button class='btn btn-primary btn-sm' disabled=''><i class='fas fa-sm fa-mouse-pointer'></i> Request Cash Advance</button>
                                        <button class='btn btn-danger btn-sm' onclick='view_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PR & Canvassed</button>";

            }else if($v['pr_status'] == "Finished" && $v['cash_status'] == "Approved"){
                $approvedpr[$k]['action'] = "<button class='btn btn-danger btn-sm' onclick='view_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PR</button> <button class='btn btn-primary btn-sm' onclick='view_RCA(".$v['idRCA'].")'><i class='fas fa-sm fa-eye'></i> View RCA</button> <button class='btn btn-success btn-sm' onclick='resendRCA(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Resend</button>";
            }else{
                $approvedpr[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].",".$id.",\"".$department."\",\"".$payee."\",\"".$date_prepared."\",\"".$date_needed."\",\"".$particulars."\",\"".$amount."\",\"".$purpose."\",\"".$remarks."\",\"".$charge_to."\",\"".$budget."\",\"".$liquidated_on."\",\"".$label."\")'><i class='fas fa-sm fa-mouse-pointer'></i> Request Cash Advance</button>
                                        <button class='btn btn-danger btn-sm' onclick='view_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PR & Canvassed</button>";
            }
            
            
            $approvedpr[$k]['status'] = $label;
            
        }
        $response = array("data" => $approvedpr);
        break;

    case "addCash";

        $pr_id = Sanitizer::filter('pr_id', 'post');
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


        $approvedpr->add_Cash($pr_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$full_name);
        $response = array("code"=>1, "message"=>"Cash Request Saved");
        break;

    case "updateCash";

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


        $approvedpr->update_Cash($cash_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$full_name);
        $response = array("code"=>1, "message"=>"Cash Request Saved");
        break;

    case "send";
        $id = Sanitizer::filter('id', 'post');
        $approvedpr->sendCash($id);
        $response = array('code'=>1, "message"=> "Request Sent");
        break;

    case "UpdateStatus";
        $id = Sanitizer::filter('id', 'post');
        $cash_status = Sanitizer::filter('cash_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $approvedpr->UpdateStatus($id,$cash_status,$remarks,$approver);
        $response = array('code'=>1, "message"=> "Request Sent");
        break;

    case "UpdateFinalStatus";
        $id = Sanitizer::filter('id', 'post');
        $cash_status = Sanitizer::filter('cash_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $approvedpr->UpdateFinalStatus($id,$cash_status,$remarks,$approver);
        $response = array('code'=>1, "message"=> "Request Sent");
        break;

    case "respond";
        $id = Sanitizer::filter('id', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $cash_status = Sanitizer::filter('cash_status', 'post');

        $approvedpr->respondTo($id,$remarks,$approver,$cash_status);
        $response = array('code'=>1, "message"=> "Respond Success");
        break;

    case "finalrespond";
        $id = Sanitizer::filter('id', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $cash_status = Sanitizer::filter('cash_status', 'post');

        $approvedpr->finalrespondTo($id,$remarks,$approver,$cash_status);
        $response = array('code'=>1, "message"=> "Respond Success");
        break;


}

echo json_encode($response);



 ?>