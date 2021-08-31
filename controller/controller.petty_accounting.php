<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.petty_accounting.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_dept = $auth->getSession("user_dept");

$petty_accounting = new PettyAccounting();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";  

        $status = Sanitizer::filter('status', 'get');
        $petty_accounting = $petty_accounting->getPettycashlist($status,$user_dept);
        foreach($petty_accounting as $k=>$v) {
            $pettycash_status = $v['pettycash_status'];

            $petty_accounting[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_Petty(".$v['id'].")'><i class='fas fa-sm fa-eye'></i> Open</button>
                                                <button class='btn btn-danger btn-sm' onclick='decline_Petty(".$v['id'].")'><i class='fas fa-sm fa-times'></i> Decline</button>";

            
        }
        $response = array("data" => $petty_accounting);
        break;

    case "UpdateStat";
        $full_name = "Jerome Chua";
        $id = Sanitizer::filter('id', 'get');
        $pettycash_status = Sanitizer::filter('pettycash_status', 'get');
        $petty_accounting->UpdateStatus($id,$pettycash_status,$full_name);
        $response = array("code"=>1,"message"=>"Petty Cash Status Updated");
        break;

    case "checkPetty";

        $id = Sanitizer::filter('id', 'post');
        $response = $petty_accounting->check_Petty($id);
        break;

    case "declinePetty";

        $id = Sanitizer::filter('id', 'post');
        $response = $petty_accounting->declinePetty($id);
        break;


}


echo json_encode($response);



 ?>