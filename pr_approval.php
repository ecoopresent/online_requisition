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

        <?php include 'component/sidenavPr.php'; ?>

        <div class="content">

                <div class="tab_container">
                    
                    <div class="rowx">

                        <div class="col-md-12">
                            <h4><i class="fas fa-md fa-thumbtack"></i> PENDING PURCHASE REQUEST</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <select class="p-1 mt-1 dropdown mb-3" id="pr_status">
                                    <option value="Submitted"> Pending </option>
                                    <option value="Approved"> Approved </option>
                                    <option value="Disapproved"> Disapproved </option>
                            </select>
                            <table id="Prequest_table" class="table">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">Date Prepared</th>
                                    <th class="bg-header">Date Needed</th>
                                    <th class="bg-header">PR No</th>
                                    <th class="bg-header">Purpose</th>
                                    <th class="bg-header">Requested By</th>
                                    <th class="bg-header">Status</th>
                                        
                                </thead>
                            </table>
                        </div>

                    </div>
                        
                </div>

        </div>



<?php
require_once "component/footer.php";
?>  
<script src="services/pr_approval/pr_approval.js"></script>
<script src="services/index/index.js"></script>