<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.payee.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$payee = new Payee();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
    
    case "tableList";
        $payee = $payee->getPayee();
        foreach($payee as $k=>$v) {

                $payee[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editPayee(".$v['id'].",\"".$v['payee_name']."\",\"".$v['payee_email']."\",\"".$v['payee_dept']."\")'><i class='fas fa-sm fa-edit'></i></button>
                                        <button class='btn btn-sm btn-danger' onclick='deletePayee(".$v['id'].")'><i class='fas fa-sm fa-trash'></i></button>";
                $payee[$k]['passwords'] = "********";
        }
        $response = array("data" => $payee);
    break;

    case "tableAudit";
        $payee = $payee->getAudit();
        $response = array("data" => $payee);
    break;

    case "tablePCadmin";
        $payee = $payee->getPCadmin();
        foreach($payee as $k=>$v) {

                $vstatus = "";
                if($v['pettycash_status']=="" || $v['pettycash_status']=="Pending"){
                    $vstatus = "Pending";
                }else{
                    $vstatus = "Approved";
                }

                $payee[$k]['voucher_status'] = $vstatus;

                $payee[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='openPC(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>
                                        <button class='btn btn-sm btn-danger' onclick='deletePC(".$v['id'].")'><i class='fas fa-sm fa-trash'></i></button>";
        }
        $response = array("data" => $payee);
    break;

    case "tableRCAadmin";
        $payee = $payee->getRCAadmin();
        foreach($payee as $k=>$v) {


                $payee[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='openRCA(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>
                                        <button class='btn btn-sm btn-danger' onclick='deleteRCA(".$v['id'].")'><i class='fas fa-sm fa-trash'></i></button>";

                $yearprepared = date('Y', strtotime($v['date_prepared']));
                $payee[$k]['rca_no'] = 'RCA'.$yearprepared.'-'.$v['id'];
        }
        $response = array("data" => $payee);
    break;

    case "add";
        $payee_name = Sanitizer::filter('payee_name', 'post');
        $payee_email = Sanitizer::filter('payee_email', 'post');
        $payee_dept = Sanitizer::filter('payee_dept', 'post');
        $payee->add_Payee($payee_name,$payee_email,$payee_dept);
        $response = array("code"=>1, "message"=>"Data Saved");

    break;

    case "delete";
        $id = Sanitizer::filter('id', 'post');
        $payee->deletePayee($id);
        $response = array("code"=>1, "message"=>"Deleted");
    break;

    case "deletePCadmin";
        $id = Sanitizer::filter('id', 'post');
        $payee->deletePCadmin($id);
        $response = array("code"=>1, "message"=>"Deleted");
    break;

    case "deleteRCAadmin";
        $id = Sanitizer::filter('id', 'post');
        $payee->deleteRCAadmin($id);
        $response = array("code"=>1, "message"=>"Deleted");
    break;

    case "update";
        $id = Sanitizer::filter('id', 'post');
        $payee_name = Sanitizer::filter('payee_name', 'post');
        $payee_email = Sanitizer::filter('payee_email', 'post');
        $payee_dept = Sanitizer::filter('payee_dept', 'post');

        $payee->updatePayee($id,$payee_name,$payee_email,$payee_dept);
        $response = array("code"=>1, "message"=>"Data Saved");
    break;

    case "option";
        $users = $users->getAllDepartment();
        $html = "";
        
        foreach($users as $k=>$v){
            $id = $users[$k]["department"];
            $name = $users[$k]["department"];
            $html .= "<option value='$id'>$name</option>";
        }

        $response = array("code"=>1,"html"=>$html);
        break;

}   


echo json_encode($response);



 ?>