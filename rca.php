<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'Purchase Request';

require_once "controller/controller.auth.php";

$auth = new Auth();
$full_name = $auth->getSession("full_name");

if(!$full_name){
    header('Location: login.php');
    exit;
}

require_once "component/header.php";

require_once "controller/controller.db.php";
require_once "model/model.rca.php";

$user_dept = $auth->getSession("user_dept");
$rca = new Rca();


$notifval = $rca->countPurchase($user_dept,'');
if($notifval > 0){
    $border = "background-color: #ff3333;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $border = "";
    $notifval = "";
}

$notifval_pending = $rca->countPurchase($user_dept,'Submitted');
$border_pending = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notifval_preapp = $rca->countPurchase($user_dept,'PreApproved');
$borderpreapp = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notifval_preapproved = $rca->countPurchase($user_dept,'Finished');
$borderpreapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notifval_disapproved = $rca->countPurchase($user_dept,'Disapproved');
$borderdisapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

 ?>

        <?php include 'component/sidenavPr.php'; ?>

    <div class="content">

        <div class="rowx">
            
        
        <div class="col col-md-12">


            <div class="tab_container">
                
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="rcatab" href="#home"><i class="fas fa-md fa-shopping-basket"></i> Request Cash Advance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="rcalist_tab" href="#menu1"><i class="fas fa-md fa-list"></i> RCA List  <span style="<?php echo $border; ?>"><?php echo $notifval; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="pendingrca_tab" href="#menu2"><i class="fas fa-md fa-list"></i> Pending RCA <span style="<?php echo $border_pending; ?>"><?php echo $notifval_pending; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="pre_approvedrca_tab" href="#menu2"><i class="fas fa-md fa-list"></i> Pre-Approved RCA <span style="<?php echo $borderpreapp; ?>"><?php echo $notifval_preapp; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="approvedrca_tab" href="#menu2"><i class="fas fa-md fa-list"></i> Approved RCA <span style="<?php echo $borderpreapproved; ?>"><?php echo $notifval_preapproved; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="disapprovedrca_tab" href="#menu2"><i class="fas fa-md fa-list"></i> Disapproved RCA <span style="<?php echo $borderdisapproved; ?>"><?php echo $notifval_disapproved; ?></span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    
                    <div id="home" class="tab-pane active"><br>
                        

                        <div class="rowx">

                            <div class="col col-md-12 mt-2">
                                <h4>REQUEST FOR CASH ADVANCE/CHECK ISSUANCE</h4><br>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                    </div>
                                    <input type="text" class="form-control" disabled="" id="department" value="<?php echo $user_dept ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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
                                    <input type="date" class="form-control req" id="date_prepared" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE NEEDED</b></span>
                                    </div>
                                    <input type="date" class="form-control req" id="date_needed" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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
                                    <input type="date" class="form-control" id="liquidated_on" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PREPARED BY:</b></span>
                                    </div>
                                    <input type="text" class="form-control req" id="prepared_by" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>



                            <div class="col col-md-12 mt-4 mb-5">

                                <button class="btn btn-sm btn-secondary" id="save_cashcheck"><i class="fas fa-sm fa-save"></i> Save RCA</button>

                            </div>
                            
                        </div>
                        
                    </div>

                    <div id="menu1" class="tab-pane fade"><br>
                        
                        <div class="rowx">

                            <div class="col col-md-12 mt-2">
                                <h4>REQUEST CASH ADVANCE LIST</h4><br>
                            </div>

                            <div class="responsive-table mt-2" id="PR_table_div">
                                <table id="RCAList_table" class="table" width="100%">
                                    <thead>
                                        <th class="bg-header"></th>
                                        <th class="bg-header">RCA No</th>
                                        <th class="bg-header">Department</th>
                                        <th class="bg-header">Payee</th>
                                        <th class="bg-header">Date Prepared</th>
                                        <th class="bg-header">Particulars</th>
                                        <th class="bg-header">Amount</th>
                                        <th class="bg-header">Purpose</th>
                                        
                                    </thead>
                                </table>
                            </div>    
                        </div>
                            
                    </div>

                    <div id="menu2" class="tab-pane fade"><br>
                        <div class="rowx">

                                <div class="col col-md-12 mt-2">
                                    <h4>PURCHASE REQUISITION LIST</h4><br>
                                </div>

                                <div class="responsive-table mt-2">
                                    <table id="RCAList_tableDone" class="table" width="100%">
                                        <thead>
                                            <th class="bg-header"></th>
                                            <th class="bg-header">RCA No</th>
                                            <th class="bg-header">Department</th>
                                            <th class="bg-header">Payee</th>
                                            <th class="bg-header">Date Prepared</th>
                                            <th class="bg-header">Particulars</th>
                                            <th class="bg-header">Amount</th>
                                            <th class="bg-header">Purpose</th>
                                            <th class="bg-header">Approver</th>
                                            
                                        </thead>
                                    </table>
                                </div>    

                        </div>
                    </div>    

                    

                </div>

            </div>

        </div>

        </div>
                    


    </div>

         <div class="modal fade mt-5" id="RCAmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Request Cash Advance Details</h5>
               </div>
               <div class="modal-body">

                    <div class="col col-md-12 mt-2">
                        <input type="hidden" class="form-control" id="cash_id" name="">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                            </div>
                            <input type="text" class="form-control" disabled="" id="r_department" value="<?php echo $user_dept ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PAYEE</b></span>
                            </div>
                            <input type="text" class="form-control req2" id="r_payee" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE PREPARED</b></span>
                            </div>
                            <input type="date" class="form-control req2" id="r_date_prepared" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE NEEDED</b></span>
                            </div>
                            <input type="date" class="form-control req2" id="r_date_needed" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PARTICULARS</b></span>
                            </div>
                            <input type="text" class="form-control" id="r_particulars" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> AMOUNT</b></span>
                            </div>
                            <input type="number" class="form-control req2" id="r_amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PURPOSE</b></span>
                            </div>
                            <textarea class="form-control req2" id="r_purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>REMARKS</b></span>
                            </div>
                            <textarea class="form-control" id="r_remarks" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>CHARGE TO</b></span>
                            </div>
                            <input type="text" class="form-control" id="r_charge_to" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>BUDGET</b></span>
                            </div>
                            <input type="text" class="form-control" id="r_budget" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>TO BE LIQUIDATED ON</b></span>
                            </div>
                            <input type="date" class="form-control" id="r_liquidated_on" value="<?php echo date('Y-m-d') ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PREPARED BY:</b></span>
                            </div>
                            <input type="text" class="form-control req2" id="r_prepared_by" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-sm btn-primary" id="save_editRCA">Save changes</button>
               </div>
             </div>
           </div>
         </div>
        

<div class="modal fade mt-5" id="ReportsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md">
        <div class="modal-content" style="width: 520px">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Submit Request Cash Advance</h5>
            </div>
            <div class="modal-body">

                <div class="col col-md-12 mt-2">
                    <input type="hidden" class="form-control" id="pettyCashId" name="">
                    <input type="hidden" class="form-control" id="requested_by" name="">
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

<div class="modal fade mt-5" id="attachmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Attach Files</h5>
            </div>
            <div class="modal-body">
                <form action="controller/controller.rca.php?mode=upload" method="post" enctype="multipart/form-data">
                    <div class="col col-md-12 mt-2">
                        <input type="hidden" id="cashcheck_id" name="cashcheck_id">
                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>Select Attachment</b></span>
                        <input type="file" class="form-control" name="rca_attachment">
                    </div>
                    <div class="col col-md-12 mt-2">
                        <center>
                            <button type="submit" class="btn btn-sm btn-info"><i class="fas fa-sm fa-upload"></i> UPLOAD</button>
                        </center>
                    </div>
                </form>
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
<script src="services/rca/rca.js"></script>
<script src="services/index/index.js"></script>