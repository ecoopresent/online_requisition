<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.users.php";
require_once "controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");

$users = new Users();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
    case "tableList";
        $users = $users->getUsers();
        foreach($users as $k=>$v) {

                $users[$k]['action'] = "<button class='btn btn-sm btn-success' onclick='editUser(".$v['id'].",\"".$v['full_name']."\",\"".$v['username']."\",\"".$v['password']."\",\"".$v['user_type']."\",\"".$v['user_dept']."\")'><i class='fas fa-sm fa-edit'></i></button>
                                        <button class='btn btn-sm btn-danger' onclick='deleteUser(".$v['id'].")'><i class='fas fa-sm fa-trash'></i></button>";
                $users[$k]['passwords'] = "********";
        }
        $response = array("data" => $users);
    break;

    case "add";
        $full_name = Sanitizer::filter('full_name', 'post');
        $username = Sanitizer::filter('username', 'post');
        $password = Sanitizer::filter('password', 'post');
        $user_type = Sanitizer::filter('user_type', 'post');
        $department = Sanitizer::filter('department', 'post');

        $users->add_User($full_name,$username,$password,$user_type,$department);
        $response = array("code"=>1, "message"=>"Data Saved");
    break;

    case "delete";
        $id = Sanitizer::filter('id', 'post');
        $users->deleteUser($id);
        $response = array("code"=>1, "message"=>"Deleted");
    break;

    case "update";
        $id = Sanitizer::filter('id', 'post');
        $full_name = Sanitizer::filter('full_name', 'post');
        $username = Sanitizer::filter('username', 'post');
        $password = Sanitizer::filter('password', 'post');
        $user_type = Sanitizer::filter('user_type', 'post');
        $department = Sanitizer::filter('department', 'post');

        $users->update_User($full_name,$username,$password,$user_type,$id,$department);
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