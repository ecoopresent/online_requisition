<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'Petty Cash';

require_once "controller/controller.auth.php";

$auth = new Auth();
$full_name = $auth->getSession("full_name");

if(!$full_name){
	header('Location: login.php');
	exit;
}

require_once "component/header.php";

?>

    <?php include 'component/sidenavIndex.php'; ?>

    <div class="dashboard_content">
    	<div class="dashboard_tabs">

    		<div class="card_tabs" onclick="openPetty('\'<?php echo $user_type; ?>\'')">
	        	<p class="card_tabs_content pt-5 pb-3">
	        		<label class="card_tabs_name"><b>PETTY CASH</b></label><br>
	        		<label class="card_tabs_subname"><b>REQUEST</b></label><br>
					<i class="fas fa-md fa-arrow-right"></i>
	        	</p>
	        </div>

	        <div class="card_tabs" onclick="openCash('\'<?php echo $user_type; ?>\'')">
	        	<p class="card_tabs_content pt-5 pb-3">
	        		<label class="card_tabs_name"><b>CASH AND CHECK</b></label><br>
	        		<label class="card_tabs_subname"><b>REQUISITION</b></label><br>
					<i class="fas fa-md fa-arrow-right"></i>
	        	</p>
	        </div>

    	</div>
        
    </div>


<?php
require_once "component/footer.php";
?>  
<script src="services/index/index.js"></script>
<script>
	$(document).ready(function(){
		$('#tab_dashboard').addClass('active-module');
	});
	function openPetty(usertype){
		if(usertype=="'Accounting'"){
			window.location.href="petty_accounting.php";
		}else{
			window.location.href="pettycash.php";
		}
	}
	function openCash(usertype){
		if(usertype=="'Purchaser'"){
			window.location.href="purchasing.php";
		}else if(usertype=="'Accounting'"){
			window.location.href="accounting.php";
		}else{
			window.location.href="pr.php";
		}
		
	}
</script>