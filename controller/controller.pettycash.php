<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.pettycash.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");
$pettycash = new Pettycash();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
    case "addPetty";

        $department = Sanitizer::filter('department', 'post');
        $voucher_date = Sanitizer::filter('voucher_date', 'post');
        $voucher_no = Sanitizer::filter('voucher_no', 'post');
        $particulars = Sanitizer::filter('particulars', 'post');
        $cash_advance = Sanitizer::filter('cash_advance', 'post');
        $actual_amount = Sanitizer::filter('actual_amount', 'post');
        $charge_to = Sanitizer::filter('charge_to', 'post');
        $liquidated_on = Sanitizer::filter('liquidated_on', 'post');
        $requested_by = Sanitizer::filter('requested_by', 'post');
        $payee = Sanitizer::filter('payee', 'post');
        $name_ApproverWL = Sanitizer::filter('name_ApproverWL', 'post');

        $pcv = $pettycash->addPettyCash($department,$voucher_date,$voucher_no,$particulars,$cash_advance,$actual_amount,$charge_to,$liquidated_on,$requested_by,$payee,$name_ApproverWL);
        $response = array("code"=>1, "message"=>"Petty Cash Added", "pcv"=>$pcv);

    break;

    case "option";
        $pettycashs = $pettycash->getAllapprover($user_dept);
        $html = "";
        
        foreach($pettycashs as $k=>$v){
            $id = $pettycashs[$k]["id"];
            $name = $pettycashs[$k]["department_head"];
            $html .= "<option value='$id'>$name</option>";
        }

        $response = array("code"=>1,"html"=>$html);
    break;

    case "updatePetty";

        $PettyID = Sanitizer::filter('PettyID', 'post');
        $petty_department = Sanitizer::filter('petty_department', 'post');
        $petty_date = Sanitizer::filter('petty_date', 'post');
        $petty_voucherno = Sanitizer::filter('petty_voucherno', 'post');
        $petty_particulars = Sanitizer::filter('petty_particulars', 'post');
        $petty_cash_advance = Sanitizer::filter('petty_cash_advance', 'post');
        $petty_actual_amount = Sanitizer::filter('petty_actual_amount', 'post');
        $petty_charge_to = Sanitizer::filter('petty_charge_to', 'post');
        $petty_liquidated_on = Sanitizer::filter('petty_liquidated_on', 'post');
        $petty_requested_by = Sanitizer::filter('petty_requested_by', 'post');

        $pettycash->updatePettyCash($PettyID,$petty_department,$petty_date,$petty_voucherno,$petty_particulars,$petty_cash_advance,$petty_actual_amount,$petty_charge_to,$petty_liquidated_on,$petty_requested_by);
        $response = array("code"=>1, "message"=>"Petty Cash Updated");

    break;

    case "Delete";

        $id = Sanitizer::filter('id', 'post');
        $pettycash->deletePettyCash($id,$user_dept);
        $response = array("code"=>1, "message"=>"Petty Cash Deleted");
        
    break;
    case "getApprover";

        $id = Sanitizer::filter('id', 'post');
        $response = $pettycash->get_Approver($id);

    break;

    case "tableList";
        $status = Sanitizer::filter('status', 'get');
        $pettycash = $pettycash->getPettycashlist($user_dept,$status);
        foreach($pettycash as $k=>$v) {

                $pettycashstatus = $v['pettycash_status'];
                if($pettycashstatus == ""){
                    $pettycashstatus = "Floating";
                    $pettycash[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editPetty(".$v['id'].",\"".$v['department']."\",\"".$v['voucher_date']."\",\"".$v['voucher_no']."\",\"".$v['particulars']."\",\"".$v['cash_advance']."\",\"".$v['actual_amount']."\",\"".$v['charge_to']."\",\"".$v['liquidated_on']."\",\"".$v['requested_by']."\")'><i class='fas fa-sm fa-edit'></i> Edit</button>
                                            <button class='btn btn-sm btn-danger' onclick='deletePetty(".$v['id'].")'><i class='fas fa-sm fa-trash'></i> Delete</button>
                                            <button class='btn btn-sm btn-warning' onclick='sendPetty(".$v['id'].",\"".$v['department']."\")'><i class='fas fa-sm fa-paper-plane'></i> Submit</button>";
                }else if($pettycashstatus == "Sent"){
                    $pettycashstatus = "Sent";
                    $pettycash[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editPetty(".$v['id'].",\"".$v['department']."\",\"".$v['voucher_date']."\",\"".$v['voucher_no']."\",\"".$v['particulars']."\",\"".$v['cash_advance']."\",\"".$v['actual_amount']."\",\"".$v['charge_to']."\",\"".$v['liquidated_on']."\",\"".$v['requested_by']."\")'><i class='fas fa-sm fa-edit'></i> Edit</button>
                                            <button class='btn btn-sm btn-danger' onclick='deletePetty(".$v['id'].")'><i class='fas fa-sm fa-trash'></i> Delete</button>
                                            <button class='btn btn-sm btn-warning' onclick='sendPetty(".$v['id'].",\"".$v['department']."\")'><i class='fas fa-sm fa-paper-plane'></i> Re-send</button>";
                }else if($pettycashstatus == "PreApp"){
                    $pettycash[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='reSendPC(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Re-send</button>";
                }else if($pettycashstatus == "Pending"){
                    $pettycash[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='viewPettyC(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PC</button> <button class='btn btn-sm btn-primary' onclick='addLiquidation(".$v['id'].",\"".$v['pettycash_status']."\",\"".$v['department']."\",\"".$v['particulars']."\",\"".$v['liquidated_on']."\")'><i class='fas fa-sm fa-arrow-circle-up'></i> Liquidate</button>";
                }else if($pettycashstatus == "Submitted"){
                    $pettycash[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='viewPettyC(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> View PC</button> <button class='btn btn-sm btn-warning' onclick='resendLiquidation(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Re-send</button>";
                }else{
                    $pettycash[$k]['action'] = "<button disabled=''  class='btn btn-sm btn-primary' onclick='addLiquidation(".$v['id'].",\"".$v['pettycash_status']."\",\"".$v['department']."\",\"".$v['particulars']."\",\"".$v['liquidated_on']."\")'><i class='fas fa-sm fa-arrow-circle-up'></i> Liquidate</button>
                                            <button disabled=''  class='btn btn-sm btn-success'><i class='fas fa-sm fa-edit'></i> Edit</button>
                                            <button disabled=''  class='btn btn-sm btn-danger'><i class='fas fa-sm fa-trash'></i> Delete</button>";
                }

                
                
                $pettycash[$k]['pettycashstatus'] = $pettycashstatus;
    
        }
        $response = array("data" => $pettycash);
    break;

    case "tableListdone";
        $status = Sanitizer::filter('status', 'get');
        $pettycash = $pettycash->getPettycashlistdone($status,$user_dept);
        foreach($pettycash as $k=>$v) {
            if($status=="Approved"){
                $pettycash[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='openPetty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open PC</button>
                                            <button class='btn btn-sm btn-primary' onclick='openLiqui(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open Liquidation</button>
                                            <button class='btn btn-sm btn-danger' onclick='resendPetty(".$v['id'].")'><i class='fas fa-sm fa-paper-plane'></i> Re-send</button>";
            }else{
                $pettycash[$k]['action'] = "<button class='btn btn-sm btn-primary' onclick='openPetty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open PC</button>
                                            <button class='btn btn-sm btn-primary' onclick='openLiqui(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open Liquidation</button>";
            }


                
    
        }
        $response = array("data" => $pettycash);
    break;

    case "tableDetails";
        $id = Sanitizer::filter('id', 'get');
        $pettycash = $pettycash->getliquidationdetails($id);
        foreach($pettycash as $k=>$v) {
                $pettycash[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editRoute(".$v['id'].",\"".$v['l_from']."\",\"".$v['l_to']."\",\"".$v['vehicle_type']."\",\"".$v['amount']."\")'><i class='fas fa-sm fa-edit'></i> Edit</button>
                                            <button class='btn btn-sm btn-danger' onclick='deleteRoute(".$v['id'].")'><i class='fas fa-sm fa-trash'></i> Delete</button>";
    
        }
        $response = array("data" => $pettycash);
    break;

    case "Submit";
       $LiquiType = Sanitizer::filter('LiquiType', 'post');
       $pettycash_id = Sanitizer::filter('pettycash_id', 'post');
       $actual_amount = Sanitizer::filter('actual_amount', 'post');

       $response = $pettycash->SubmitPetty($LiquiType,$pettycash_id,$actual_amount);
       
    break;

    case "addLiqui";
        $pettycash_id = Sanitizer::filter('pettycash_id', 'post');
        $name = Sanitizer::filter('name', 'post');
        $liquidation_date = Sanitizer::filter('liquidation_date', 'post');
        $branch = Sanitizer::filter('branch', 'post');
        $position = Sanitizer::filter('position', 'post');
        $eparticular = Sanitizer::filter('eparticular', 'post');

        $pettycash->add_liquidation($pettycash_id,$name,$liquidation_date,$branch,$position,$eparticular,$full_name);
        $response = array("code"=>1, "message"=>"Liquidation Added");
    break;

    case "updateLiqui";
        $liquidation_id = Sanitizer::filter('liquidation_id', 'post');
        $pettycash_id = Sanitizer::filter('pettycash_id', 'post');
        $name = Sanitizer::filter('name', 'post');
        $liquidation_date = Sanitizer::filter('liquidation_date', 'post');
        $branch = Sanitizer::filter('branch', 'post');
        $position = Sanitizer::filter('position', 'post');
        $eparticular = Sanitizer::filter('eparticular', 'post');

        $pettycash->update_liquidation($pettycash_id,$name,$liquidation_date,$branch,$position,$eparticular,$liquidation_id);
        $response = array("code"=>1, "message"=>"Liquidation Updated");
    break;

    case "CheckPetty";
        $id = Sanitizer::filter('id', 'post');
        $response = $pettycash->check_Petty($id);
    break;

    case "addRoute";
        $liquidation_id = Sanitizer::filter('liquidation_id', 'post');
        $l_from = Sanitizer::filter('l_from', 'post');
        $l_to = Sanitizer::filter('l_to', 'post');
        $Vehicle_type = Sanitizer::filter('Vehicle_type', 'post');
        $l_amount = Sanitizer::filter('l_amount', 'post');

        $pettycash->add_Route($liquidation_id,$l_from,$l_to,$Vehicle_type,$l_amount);
        $response = array("code"=>1, "message"=>"Route Added");
    break;

    case "updateRoute";
        $liquiDetailsID = Sanitizer::filter('liquiDetailsID', 'post');
        $l_from = Sanitizer::filter('l_from', 'post');
        $l_to = Sanitizer::filter('l_to', 'post');
        $Vehicle_type = Sanitizer::filter('Vehicle_type', 'post');
        $l_amount = Sanitizer::filter('l_amount', 'post');

        $pettycash->update_Route($liquiDetailsID,$l_from,$l_to,$Vehicle_type,$l_amount);
        $response = array("code"=>1, "message"=>"Route Updated");

    break;

    case "DeleteRoute";
        $id = Sanitizer::filter('id', 'post');

        $pettycash->delete_Route($id);
        $response = array("code"=>1, "message"=>"Route Deleted");
    break;

    case "countRoute";
        $liquidation_id = Sanitizer::filter('liquidation_id', 'post');

        $response = $pettycash->count_Route($liquidation_id);
    break;

    case "getVoucher";

        $response = $pettycash->getVoucherno();
    break;

    case "option";
        $pettycash = $pettycash->getAllDepartment();
        $html = "";
        
        foreach($pettycash as $k=>$v){
            $id = $pettycash[$k]["department"];
            $name = $pettycash[$k]["department"];
            $html .= "<option value='$id'>$name</option>";
        }

        $response = array("code"=>1,"html"=>$html);
    break;

    case "optionPayee";
        $pettycash = $pettycash->getAllPayee();
        $html = "";
        
        foreach($pettycash as $k=>$v){
            $id = $pettycash[$k]["id"];
            $name = $pettycash[$k]["payee_name"];
            $html .= "<option value='$id'>$name</option>";
        }

        $response = array("code"=>1,"html"=>$html);
    break;

}   


echo json_encode($response);



 ?>