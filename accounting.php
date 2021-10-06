<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'Petty Cash';

require_once "controller/controller.auth.php";
$auth = new Auth();
$full_name = $auth->getSession("full_name");


if($full_name==false){
    header('Location: login.php');
}
require_once "component/header.php";
 ?>

        <?php include 'component/sidenavPr.php'; ?>

        <div class="content">

                <div class="tab_container">
                    
                    <div class="rowx">

                        <div class="col-md-12">
                            <h4><i class="fas fa-md fa-thumbs-up"></i> APPROVED CASH ADVANCE/CHECK ISSUANCE REQUEST</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <select class="p-1 mt-1 dropdown mb-3" id="cash_status" style="display: none;">
                                <option value="Approved"> Pending</option>
                                <option value="Finished" selected=""> Approved</option>
                                <option value="Disapproved2"> Disapproved</option>
                                <option value="Rejected"> Rejected</option>
                            </select>

                            <table id="Cashrequest_table" class="table">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">RCA Number</th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">Payee</th>
                                    <th class="bg-header">Date Prepared</th>
                                    <th class="bg-header">Date Needed</th>
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

<script type="text/javascript">
<?php 
    include 'services/accounting/accounting.js';
    include 'services/index/index.js';
?>
</script>