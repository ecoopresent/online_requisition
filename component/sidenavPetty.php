<?php 
require_once "controller/controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");
$user_type = $auth->getSession("user_type");
$user_dept = $auth->getSession("user_dept");


require_once "controller/controller.db.php";
require_once "model/model.pettycash.php";

$pettycash = new Pettycash();

$notifval_side = $pettycash->countPettycashApproval('Submitted');
if($notifval_side > 0){
	$border_side = "background-color: #ffcc00;color: #00004d;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
	$border_side = "";
	$notifval_side = "";
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
		<a href="pettycash.php" id="tab_pettycash"><i class="fas fa-md fa-money-bill-wave"></i> PETTY CASH REQUEST</a>
		<a href="petty_approval.php" id="tab_petty_approval"><i class="fas fa-md fa-thumbtack"></i> PETTY CASH APPROVAL <span style="<?php echo $border_side; ?>"><?php echo $notifval_side; ?></span></a>
		<a href="petty_accounting.php" id="tab_accounting_approval"><i class="fas fa-md fa-thumbs-up"></i> APPROVED PETTY CASH</a>
	<?php endif ?>
	
	
	<?php if ($user_type=="Enduser" || $user_type=="Purchaser"): ?>
		<a href="pettycash.php" id="tab_pettycash"><i class="fas fa-md fa-money-bill-wave"></i> PETTY CASH REQUEST</a>
	<?php endif ?>
	
	<?php if ($user_type=="Accounting"): ?>
		<a href="petty_accounting.php" id="tab_accounting_approval"><i class="fas fa-md fa-thumbs-up"></i> APPROVED PETTY CASH</a>
		<a href="petty_accountingLiquidate.php" id="tab_accountingLiquidate"><i class="fas fa-md fa-edit"></i> LIQUIDATED PETTY CASH</a>
		<a href="petty_reports.php" id="tab_pettyreports"><i class="fas fa-md fa-file-excel"></i> REPORTS</a>
	<?php endif ?>

	<?php if ($user_type=="Logistics"): ?>
		<a href="pettycash.php" id="tab_pettycash"><i class="fas fa-md fa-money-bill-wave"></i> PETTY CASH REQUEST</a>
		<a href="petty_accounting.php" id="tab_accounting_approval"><i class="fas fa-md fa-thumbs-up"></i> APPROVED PETTY CASH</a>
		<a href="petty_accountingLiquidate.php" id="tab_accountingLiquidate"><i class="fas fa-md fa-edit"></i> LIQUIDATED PETTY CASH</a>
		<a href="petty_reports.php" id="tab_pettyreports"><i class="fas fa-md fa-file-excel"></i> REPORTS</a>
	<?php endif ?>
	<a href="#" id="logout" class="tabs"><i class="fas fa-md fa-sign-out-alt"></i> LOG-OUT</a>

	<div class="footer">
		<p>
		   <span class="fw-b">User Type: </span><?php echo $user_type; ?><br>
		   <span class="fw-b">Department: </span><?php echo $user_dept; ?>
		</p>
	</div>

</div>