<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.login.php";
require_once "controller.auth.php";
$auth = new Auth();

$login = new Login();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
    case "login";
        $username = Sanitizer::filter('username', 'post');
        $password = Sanitizer::filter('password', 'post');
        $status = $login->loginUser($username, $password);
        $response = $status;
        if($status['full_name'] != null){
        	$auth->setSession('full_name', $status['full_name']);
            $auth->setSession('user_type', $status['user_type']);
            $auth->setSession('user_dept', $status['user_dept']);
            $auth->setSession('department_head', $status['department_head']);
            $auth->setSession('department_email', $status['department_email']);
        }
        break;

}


echo json_encode($response);



 ?>
