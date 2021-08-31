<?php

require_once "./controller/controller.auth.php";
require_once "./controller/controller.sanitizer.php";
require_once "./controller/controller.db.php";

$auth = new Auth();

// $isLoggedIn = $auth->getSession("auth");

$auth->redirect("auth", true, "login.php");	


// $__role = $auth->getSession("role");