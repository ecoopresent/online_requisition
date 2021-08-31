<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.purchasing.php";

$purchasing = new Purchasing();
$purchasing2 = new Purchasing();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
	case "table";

        $purchasing = $purchasing->getPRlist();
        foreach($purchasing as $k=>$v) {
            // if($v['pr_status']=="Canvassed"){
            //     $purchasing[$k]['action'] = "<button class='btn btn-primary btn-sm' disabled=''><i class='fas fa-sm fa-mouse-pointer'></i></button>
            //                                  <button class='btn btn-danger btn-sm' onclick='view_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>";
            // }else{
                // $purchasing[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].",\"".$v['department']."\",\"".$v['date_prepared']."\",\"".$v['date_needed']."\",\"".$v['pr_no']."\",\"".$v['purpose']."\")'><i class='fas fa-sm fa-mouse-pointer'></i></button>
                //                              <button class='btn btn-danger btn-sm' onclick='view_PR(".$v['id'].")'><i class='fas fa-sm fa-eye'></i></button>";
            // }
            $label = "";
            $id = $v['id'];
            $status = $purchasing2->check_Canvas($id);
            if($status['statuss']=="submitted"){
                $label = "CANVASSED";
            }else{
                $label = "PENDING";
            }
            $canvas_id = $status['canvas_id'];
            $supplier1 = $status['supplier1'];
            $supplier2 = $status['supplier2'];
            $supplier3 = $status['supplier3'];
            $supplier4 = $status['supplier4'];
            $supplier5 = $status['supplier5'];
            $canvas_date = $status['canvas_date'];
            $remarks = $status['remarks'];

            $canvas_status = "";
            if($v['canvas_status']=="Submitted"){
                $canvas_status = "<i class='fas fa-sm fa-check-circle'></i> Sent";
            }else{
                $canvas_status = "Pending";
            }
            $purchasing[$k]['prtype'] = $v['pr_type'];
            $purchasing[$k]['canvas_statuss'] = $canvas_status;

            $purchasing[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='open_PR(".$v['id'].",\"".$v['department']."\",\"".$v['date_prepared']."\",\"".$v['date_needed']."\",\"".$v['pr_no']."\",\"".$v['purpose']."\",".$canvas_id.",\"".$supplier1."\",\"".$supplier2."\",\"".$supplier3."\",\"".$supplier4."\",\"".$supplier5."\",\"".$canvas_date."\",\"".$remarks."\")'><i class='fas fa-sm fa-edit'></i> Set Supliers</button>
                                             <button class='btn btn-danger btn-sm' onclick='view_PR(".$canvas_id.")'><i class='fas fa-sm fa-list-alt'></i> Canvas Sheet</button>";
            
            $purchasing[$k]['status'] = $label;
            
        }
        $response = array("data" => $purchasing);
        break;

    case  "tablePRDetails";
        $pr_id = Sanitizer::filter('pr_id', 'get');
        $purchasing = $purchasing->getPRDetails($pr_id);

        $response = array("data" => $purchasing);
        break;



    case "AddCanvas";
        $pr_id = Sanitizer::filter('pr_id', 'post');
        $canvas_date = Sanitizer::filter('canvas_date', 'post');
        $supplier1 = Sanitizer::filter('supplier1', 'post');
        $supplier2 = Sanitizer::filter('supplier2', 'post');
        $supplier3 = Sanitizer::filter('supplier3', 'post');
        $supplier4 = Sanitizer::filter('supplier4', 'post');
        $supplier5 = Sanitizer::filter('supplier5', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $canvas_id = $purchasing->add_canvas($pr_id,$canvas_date,$supplier1,$supplier2,$supplier3,$supplier4,$supplier5,$remarks);
        $response = array("code"=>1, "canvas_id"=> $canvas_id);
        break;

    case "UpdateCanvas";
        $canvas_id = Sanitizer::filter('canvas_id', 'post');
        $pr_id = Sanitizer::filter('pr_id', 'post');
        $canvas_date = Sanitizer::filter('canvas_date', 'post');
        $supplier1 = Sanitizer::filter('supplier1', 'post');
        $supplier2 = Sanitizer::filter('supplier2', 'post');
        $supplier3 = Sanitizer::filter('supplier3', 'post');
        $supplier4 = Sanitizer::filter('supplier4', 'post');
        $supplier5 = Sanitizer::filter('supplier5', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $canvas_id = $purchasing->update_canvas($canvas_id,$canvas_date,$supplier1,$supplier2,$supplier3,$supplier4,$supplier5,$remarks);
        $response = array("code"=>1, "canvas_id"=> $canvas_id);
        break;

}

echo json_encode($response);



 ?>