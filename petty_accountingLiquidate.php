<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'Petty Cash Accounting';

require_once "controller/controller.auth.php";

$auth = new Auth();
$full_name = $auth->getSession("full_name");

if(!$full_name){
    header('Location: login.php');
    exit;
}

require_once "component/header.php";
 ?>

        <?php include 'component/sidenavPetty.php'; ?>

        <div class="content">

                <div class="tab_container">
                    
                    <div class="rowx">

                        <div class="col-md-12">
                            <h4><i class="fas fa-md fa-edit"></i> LIQUIDATED PETTY CASH</h4><br>
                        </div>

                        <div class="responsive-table mt-2" id="">
                            <select class="p-1 mt-1 dropdown mb-3" id="petty_status">
                                    <option value="Approved1"> Pending </option>
                                    <option value="Finished"> Finished </option>
                            </select>
                            <table id="Pettycash_approvalTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">Date Prepared</th>
                                    <th class="bg-header">Voucher No</th>
                                    <th class="bg-header">Particulars</th>
                                    <th class="bg-header">Cash Advance</th>
                                    <th class="bg-header">Actual Amount</th>
                                    <th class="bg-header">Charge To</th>
                                    <th class="bg-header">To be liquidated on</th>
                                </thead>
                            </table>
                        </div>

                    </div>
                        
                </div>

        </div>

<div class="modal fade mt-5" id="ReportsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Select Reports</h5>
            </div>
            <div class="modal-body">

                <div class="col col-md-12 mt-2">
                    <input type="hidden" class="form-control" id="pettyCashId" name="">
                    <div class="input-group mb-3 ml-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>Petty Cash</b></span>
                        </div>
                        <button type="button" onclick="pettycash()" class="btn btn-warning w-50"><b><i class="fas fa-sm fa-file-pdf"></i> Open PDF File</b></button>

                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3 ml-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>Liquidations</b></span>
                        </div>
                        <button type="button" id="btn_liquidate" onclick="liquidate()" class="btn btn-warning w-50"><b><i class="fas fa-sm fa-file-pdf"></i> Open PDF File</b></button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>



<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/petty_accounting/petty_accountingLiquidate.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
    <?php 
        include 'services/petty_accounting/petty_accountingLiquidate.js';
        include 'services/index/index.js';
    ?>
</script>