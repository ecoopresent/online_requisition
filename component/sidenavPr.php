<?php 
require_once "controller/controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_type = $auth->getSession("user_type");
$user_dept = $auth->getSession("user_dept");

require_once "controller/controller.db.php";
require_once "model/model.purchasing.php";
require_once "model/model.approvedpr.php";

$purchasing = new Purchasing();

$notifval_side = $purchasing->countPRapproved('Approved');
if($notifval_side > 0){
	$border_side = "background-color: #ffcc00;color: #00004d;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
	$border_side = "";
	$notifval_side = "";
}

$approvedpr = new Approvedpr();
$c_notifval_side = $approvedpr->countCanvasapproved();
if($c_notifval_side > 0){
	$c_border_side = "background-color: #ffcc00;color: #00004d;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
	$c_border_side = "";
	$c_notifval_side = "";
}

$rca_notifval_side = $approvedpr->countApprovedRCA();
if($rca_notifval_side > 0){
	$rca_border_side = "background-color: #ffcc00;color: #00004d;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
	$rca_border_side = "";
	$rca_notifval_side = "";
}

?>
<div class="sidebar">
	<div class="company-name">
		<div class="row">
			<div class="c-icon">
				<img src="logo.png" class="company-icon">
			</div>
			<!-- <div class="c-name">
				<h1 class="text-white">PROGRESSIVE</h1>
				<h6 class="text-white">MEDICAL CORPORATION</h6>
			
			</div> -->
		</div>
		
	</div>
	
	<?php if ($user_type=="Administrator"): ?>
		<a href="index.php" id="tab_dashboard"><i class="fas fa-md fa-home"></i> HOME</a>
		<a href="pr.php" id="tab_pr"><i class="fas fa-md fa-shopping-basket"></i> PURCHASE REQUEST</a>
		<a href="pr_approval.php" id="tab_pr_approval"><i class="fas fa-md fa-thumbtack"></i> PR APPROVAL</a>
		<a href="cashadvance_approval.php" id="tab_cashadvance_approval"><i class="fas fa-md fa-thumbtack"></i> CASH ADVANCE APPROVAL</a>
		<a href="purchasing.php" id="tab_purchasing"><i class="fas fa-md fa-poll-h"></i> CANVASSING <span style="<?php echo $border_side; ?>"><?php echo $notifval_side; ?></span></a>
		<a href="approvedPr.php" id="tab_approvedPR"><i class="fas fa-md fa-thumbs-up"></i> APPROVED CANVASSED <span style="<?php echo $c_border_side; ?>"><?php echo $c_notifval_side; ?></span></a>
		<a href="accounting.php" id="tab_accounting"><i class="fas fa-md fa-thumbs-up"></i> APPROVED RCA <span style="<?php echo $rca_border_side; ?>"><?php echo $rca_notifval_side; ?></span></a>
		<a href="approvedCash.php" id="tab_approvedCash"><i class="fas fa-md fa-thumbs-up"></i> APPROVED CASH ADVANCE</a>
		<a href="rca.php" id="tab_rca"><i class="fas fa-md fa-money-check"></i> REQUEST CASH ADVANCE</a>
		<a href="rca_reports.php" id="tab_rcareports"><i class="fas fa-md fa-file-excel"></i> REPORTS</a>
	<?php endif ?>

	<?php if ($user_type=="Enduser" || $user_type=="Logistics"): ?>
	<a href="pr.php" id="tab_pr"><i class="fas fa-md fa-shopping-basket"></i> PURCHASE REQUEST</a>
	<a href="rca.php" id="tab_rca"><i class="fas fa-md fa-money-check"></i> REQUEST CASH ADVANCE</a>
	<?php endif ?>


	<?php if ($user_type=="Purchaser"): ?>
		<a href="pr.php" id="tab_pr"><i class="fas fa-md fa-shopping-basket"></i> PURCHASE REQUEST</a>
		<a href="purchasing.php" id="tab_purchasing"><i class="fas fa-md fa-poll-h"></i> CANVASSING <span style="<?php echo $border_side; ?>"><?php echo $notifval_side; ?></span></a>
		<a href="approvedPr.php" id="tab_approvedPR"><i class="fas fa-md fa-thumbs-up"></i> APPROVED CANVASSED <span style="<?php echo $c_border_side; ?>"><?php echo $c_notifval_side; ?></span></a>
		<a href="rca.php" id="tab_rca"><i class="fas fa-md fa-money-check"></i> REQUEST CASH ADVANCE</a>
		<!-- <a href="accounting.php" id="tab_accounting"><i class="fas fa-md fa-thumbs-up"></i> APPROVED RCA <span style="<?php echo $rca_border_side; ?>"><?php echo $rca_notifval_side; ?></span></a> -->
	<?php endif ?>

	<?php if ($user_type=="Accounting"): ?>
		<a href="approvedCash.php" id="tab_approvedCash"><i class="fas fa-md fa-thumbs-up"></i> APPROVED CASH ADVANCE</a>
		<a href="rca.php" id="tab_rca"><i class="fas fa-md fa-money-check"></i> REQUEST CASH ADVANCE</a>
		<a href="rca_reports.php" id="tab_rcareports"><i class="fas fa-md fa-file-excel"></i> REPORTS</a>
	<?php endif ?>
	
	<br>
	<br>
	<a href="#" id="logout" class="tabs"><i class="fas fa-md fa-sign-out-alt"></i> LOG-OUT</a>
	<div class="footer">
		<p>
		   <span class="fw-b">User Type: </span><?php echo $user_type; ?><br>
		   <span class="fw-b">Department: </span><?php echo $user_dept; ?>
		</p>
	</div>
</div>