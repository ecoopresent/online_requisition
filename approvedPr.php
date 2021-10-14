<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'Accounting';

require_once "controller/controller.auth.php";

$auth = new Auth();
$full_name = $auth->getSession("full_name");

if(!$full_name){
    header('Location: login.php');
    exit;
}

require_once "component/header.php";
require_once "controller/controller.db.php";
require_once "model/model.approvedpr.php";

$approvedpr = new Approvedpr();
$notifval_sidee = $approvedpr->countCanvasrejected('Rejected');
if($notifval_sidee > 0){
    $border_sidee = "background-color: seagreen;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $border_sidee = "";
    $notifval_sidee = "";
}

$notifval_side2 = $approvedpr->countCanvasrejected('PreFinished');
if($notifval_side2 > 0){
    $border_side2 = "background-color: seagreen;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $border_side2 = "";
    $notifval_side2 = "";
}
 ?>
        <?php include 'component/sidenavPr.php'; ?>

        <div class="content">

            <div class="tab_container">
            
                <div class="rowx">

                    

                    <div class="responsive-table mt-2" id="canvas_div">

                        <h4><i class="fas fa-md fa-thumbs-up"></i> APPROVED CANVASSED</h4><br>

                        <select class="p-1 mt-1 dropdown mb-3" id="canvas_status">
                                    <option value="Pending" selected=""> Pending </option>
                                    <option value="Submitted"> Submitted </option>
                                    <option value="PreApproved"> Pre-Approved RCA </option>
                                    <option value="FinalFinished"> Finished </option>
                            </select>

                            <button class="btn btn-sm btn-warning" type="button" id="btn_approved"> <label class="text-dark">Pre-Approved Canvas</label> <span style="<?php echo $border_side2; ?>"><?php echo $notifval_side2; ?></span></button>

                            <button class="btn btn-sm btn-warning" type="button" id="btn_rejecteds"> <label class="text-dark">Rejected Canvas</label> <span style="<?php echo $border_sidee; ?>"><?php echo $notifval_sidee; ?></span></button>
                        <table id="Prequest_table" class="table">
                            <thead>
                                <th class="bg-header"></th>
                                <th class="bg-header">Date Approved</th>
                                <th class="bg-header">Status</th>
                                <th class="bg-header">Department</th>
                                <th class="bg-header">Date Prepared</th>
                                <th class="bg-header">Date Needed</th>
                                <th class="bg-header">PR No</th>
                                <th class="bg-header">Purpose</th>
                                <th class="bg-header">Requested By</th>
                                <th class="bg-header">PR Type</th>
                            </thead>
                        </table>
                    </div>

                    <div class="rowx col col-md-12" id="canvas_details_div">

                        <div class="col col-md-12 mb-3">
                            <button class="btn btn-md btn-info" type="button" onclick="btn_cancelCanvas()"><i class="fas fa-sm fa-arrow-left"></i> Back</button>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <h4><i class="fas fa-md fa-poll-h"></i> REQUEST FOR CASH ADVANCE/CHECK ISSUANCE</h4><br>
                        </div>







                        <div class="col col-md-12 mt-2">
                        
                            <input type="hidden" id="pr_id" name="">
                            <input type="hidden" id="cash_id" name="">
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DEPARTMENT</b></span>
                                </div>
<!--                                 <select class="form-control" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    <option disabled="" selected="">-- Select Department --</option>
                                    <option value="Admin"> Admin Department</option>
                                    <option value="IT"> IT Department</option>
                                    <option value="HR">HR Department</option>
                                    <option value="Accounting">Accounting Department</option>
                                    <option value="Finance">Finance Department</option>
                                </select> -->

                                <select class="form-control" name="department" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PAYEE</b></span>
                                </div>
                                <input type="text" class="form-control req" id="payee" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE PREPARED</b></span>
                                </div>
                                <input type="date" class="form-control req" id="date_prepared" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE NEEDED</b></span>
                                </div>
                                <input type="date" class="form-control req" id="date_needed" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PARTICULARS</b></span>
                                </div>
                                <input type="text" class="form-control" id="particulars" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> AMOUNT</b></span>
                                </div>
                                <input type="number" class="form-control req" id="amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PURPOSE</b></span>
                                </div>
                                <textarea class="form-control req" id="purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>REMARKS</b></span>
                                </div>
                                <textarea class="form-control" id="remarks" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>CHARGE TO</b></span>
                                </div>
                                <input type="text" class="form-control" id="charge_to" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>BUDGET</b></span>
                                </div>
                                <input type="text" class="form-control" id="budget" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>TO BE LIQUIDATED ON</b></span>
                                </div>
                                <input type="date" class="form-control" id="liquidated_on" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>



                        <div class="col col-md-12 mt-4 mb-5">

                            <button class="btn btn-md btn-secondary" id="save_cashcheck"><i class="fas fa-sm fa-save"></i> Save</button>

                            <button class="btn btn-md btn-success" id="send_cashcheck"><i class="fas fa-sm fa-paper-plane"></i> Send</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>  



<div class="modal fade mt-5" id="approverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md">
        <div class="modal-content" style="width: 520px">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Submit Request Cash Advance</h5>
            </div>
            <div class="modal-body">

                <div class="col col-md-12 mt-2">
                    <input type="hidden" class="form-control" id="pettyCashId" name="">
                    <input type="hidden" value="Marjorie Barona" class="form-control" id="requested_by" name="">
                    <!-- <div class="input-group mb-3"> -->
                        <!-- <div class="input-group-prepend"> -->
                            <input type="hidden" id="c_id" name="">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>Select Approver</b></span>
                        <!-- </div> -->
                        <select id="approver" class="form-control">
                            <optgroup label="Admin">
                              <option value="one" selected="">Jerome T. Chua Only</option>
                              <option value="oneB">Susan T. Panugayan Only</option>
                              <option value="two">Jerome T. Chua & Homer C. Lim</option>
                            </optgroup>
                            <optgroup label="Others">
                              <option value="twoC">Jovan D. Palma & Jerome T. Chua</option>
                              <option value="twoD">Nancy G. Cortez & Homer C. Lim</option>
                              <option value="twoE">Jasmin Padernal & Jerome T. Chua</option>
                              <option value="twoF">Jocelyn Lagumbayan & Jerome T. Chua</option>
                              <option value="three">Jasmin Padernal & Jerome T. Chua & Homer C. Lim</option>
                            </optgroup>
                        </select>

                    <!-- </div> -->
                </div>

                <div class="col col-md-12 mt-2">
                    <center>
                        <button type="button" id="btn_liquidate" onclick="submitRCA()" class="btn btn-sm btn-success"><i class="fas fa-sm fa-paper-plane"></i> SUBMIT</button>
                    </center>
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
<!-- <script src="services/approvedpr/approvedpr.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
<?php 
    include 'services/approvedpr/approvedpr.js';
    include 'services/index/index.js';
?>
</script>