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
                            <h4><i class="fas fa-md fa-thumbs-up"></i> APPROVED CASH ADVANCE</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <select class="p-1 mt-1 dropdown mb-3" id="cash_status">
                                <option value="Finished" selected=""> Approved Cash/Check Request</option>
                                <option value="Checked"> Finished Transaction </option>
                            </select>
                            <table id="Cashrequest_table" class="table">
                                <thead>
                                    <th class="bg-header"></th>
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

        <div class="modal fade mt-5" id="attachmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attach Files</h5>
                    </div>
                    <div class="modal-body">
                            <div class="col col-md-12 mt-2">
                                <table id="attachmentTable" class="table" width="100%">
                                    <thead>
                                        <th class="bg-header"></th>
                                        <th class="bg-header">Attachment</th>
                                    </thead>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

        </div>



<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/approvedCash/approvedCash.js"></script> -->
<!-- <script src="services/index/index.js"></script> -->

<script type="text/javascript">
    <?php 
        include 'services/approvedCash/approvedCash.js';
        include 'services/index/index.js';
    ?>
</script>