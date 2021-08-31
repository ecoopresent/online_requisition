<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.department.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$department = new Department();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
    case "tableList";
        $department = $department->getDepartment();
        foreach($department as $k=>$v) {

                $department[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editDept(".$v['id'].",\"".$v['department']."\",\"".$v['department_head']."\",\"".$v['department_email']."\")'><i class='fas fa-sm fa-edit'></i></button>
                                        <button class='btn btn-sm btn-danger' onclick='deleteDept(".$v['id'].")'><i class='fas fa-sm fa-trash'></i></button>";
                $department[$k]['passwords'] = "********";
        }
        $response = array("data" => $department);
    break;

    case "add";
        $departments = Sanitizer::filter('department', 'post');
        $department_head = Sanitizer::filter('department_head', 'post');
        $department_email = Sanitizer::filter('department_email', 'post');
        $department->add_Department($departments,$department_head,$department_email);
        $response = array("code"=>1, "message"=>"Data Saved");
    break;

    case "delete";
        $id = Sanitizer::filter('id', 'post');
        $department->deleteDepartment($id);
        $response = array("code"=>1, "message"=>"Deleted");
    break;

    case "update";
        $id = Sanitizer::filter('id', 'post');
        $departments = Sanitizer::filter('department', 'post');
        $department_head = Sanitizer::filter('department_head', 'post');
        $department_email = Sanitizer::filter('department_email', 'post');

        $department->update_Department($id,$departments,$department_head,$department_email);
        $response = array("code"=>1, "message"=>"Data Saved");
    break;

}   


echo json_encode($response);



 ?>