<?php 
date_default_timezone_set("Asia/Manila");

require_once "controller/controller.auth.php";
require_once "controller/controller.sanitizer.php";
require_once "controller/controller.db.php";

$meta_title = 'Login';



$auth = new Auth();
$full_name = $auth->getSession("full_name");
if($full_name != false){
    header('Location: index.php');
}

require_once "component/header.php";

 ?>

        <div class="login-form">
            <div class="company-name">
                <div class="row">
                    <div class="c-icon">
                        <img src="https://inmed.com.ph/static/inmed_logo.png" class="company-icon">
                    </div>
                </div>
                
            </div>

            <h1 class="p-3 text-white" align="center">YOU MUST LOG-IN FIRST.</h1>
            <div class="form-group ml-3 mr-3">
                <div class="alert alert-secondary text-center border-0" role="alert">
                  Online Form Requisition
                </div>
            </div>

            <div class="form-group ml-3 mr-3">
                 <label class="text-white"><i class="fas fa-user"></i> Username</label>
                 <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter Username">
             </div>
             <div class="form-group ml-3 mr-3">
                 <label class="text-white"><i class="fas fa-lock"></i> Password</label>
                 <input type="password" class="form-control" placeholder="Enter Password" id="password">
             </div>
             <input type="hidden" id="usertype" name="">

             <div class="form-group ml-3 mr-3 d-none">
                 <select class="form-control" id="system_type" aria-describedby="emailHelp" placeholder="Enter Username">
                     <option value="petty">Petty Cash Request</option>
                     <option selected value="rca">Cash And Check Requisition</option>
                 </select>
             </div>
             <div class="ml-3 mr-3">
                 <center>
                    <button type="button" id="login" class="btn btn-info p-2 button-login font-weight-bold">Login</button>
                 </center>
             </div>

        </div>

        <div class="content-login">
               
        </div>
     
     <div id="welcome-modal" class="modal fade" data-backdrop="static" data-keyboard="false" data-focus="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-body p-5">

                    <div class="card-panel p-4 border-0 mb-0 rounded-0 text-cente">
                        <div class="icon-lg-pop mb-4 text-center">
                            <i style="font-size: 30px" class="fas fa-lg fa-bell"></i>
                        </div>
                        <p class="m-0 font-weight-bold text-center">Welcome User</p>
                        <div class="pt-4 text-center">
                            <button id="welcome-ok" class="btn-info btn" data-callback="true">Click to Proceed !</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>  

<?php
require_once "component/footer.php";
?>               

<script type="text/javascript">
    <?php include 'services/login/login.js'; ?>
</script>
