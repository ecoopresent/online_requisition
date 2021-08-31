<?php 
$user_type = $auth->getSession("user_type");
$user_dept = $auth->getSession("user_dept");
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
	<a href="users.php" id="tab_users"><i class="fas fa-md fa-users"></i> USERS</a>
	<a href="department.php" id="tab_department"><i class="fas fa-md fa-building"></i> DEPARTMENTS</a>
	<a href="payee.php" id="tab_payee"><i class="fas fa-md fa-cash-register"></i> PAYEE</a>
	<a href="audit.php" id="tab_audit"><i class="fas fa-md fa-history"></i> LOGS</a>
	<?php endif ?>
	<a href="#" id="logout" class="tabs"><i class="fas fa-md fa-sign-out-alt"></i> LOG-OUT</a>

	<div class="footer">
		<p>
		   <span class="fw-b">User Type: </span><?php echo $user_type; ?><br>
		   <span class="fw-b">Department: </span><?php echo $user_dept; ?>
		</p>
	</div>

</div>
