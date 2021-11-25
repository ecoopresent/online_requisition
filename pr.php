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
require_once "model/model.pr.php";

$user_dept = $auth->getSession("user_dept");
$department_head = $auth->getSession("department_head");
$department_email = $auth->getSession("department_email");
$user_type = $auth->getSession("user_type");
$pr = new Pr();


$notifval = $pr->countPurchase($user_dept,'Pending');
if($notifval > 0){
    $border = "background-color: #ff3333;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $border = "";
    $notifval = "";
}

$notifval_preapproved = $pr->countPurchase($user_dept,'Approved');
$borderpreapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notifval_disapproved = $pr->countPurchase($user_dept,'Disapproved');
$borderdisapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

 ?>

        <?php include 'component/sidenavPr.php'; ?>

    <div class="content">

        <div class="rowx">
            
        
        <div class="col col-md-12">


            <div class="tab_container">
                
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="prtab" href="#home"><i class="fas fa-md fa-shopping-basket"></i> Purchase Requisition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="prlisttab" href="#menu1"><i class="fas fa-md fa-list"></i> PR List  <span style="<?php echo $border; ?>"><?php echo $notifval; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="prapprovedtab" href="#menu2"><i class="fas fa-md fa-list"></i> Approved PR <span style="<?php echo $borderpreapproved; ?>"><?php echo $notifval_preapproved; ?></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="prdisapprovedtab" href="#menu2"><i class="fas fa-md fa-list"></i> Disapproved PR <span style="<?php echo $borderdisapproved; ?>"><?php echo $notifval_disapproved; ?></span></a>
                    </li>
                </ul>

                <div class="tab-content">
                    
                    <div id="home" class="tab-pane active"><br>
                        

                        <div class="rowx">

                            <div class="col col-md-12 mt-2">
                                <h4>PURCHASE REQUISITION</h4><br>
                            </div>

                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                    </div>
                                    <!-- <select class="form-control" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        <option disabled="" selected="">-- Select Department --</option>
                                        <option value="Admin"> Admin Department</option>
                                        <option value="IT"> IT Department</option>
                                        <option value="HR">HR Department</option>
                                        <option value="Accounting">Accounting Department</option>
                                        <option value="Finance">Finance Department</option>
                                        <option value="Purchasing">Purchasing Department</option>
                                    </select> -->
                                    <input type="text" class="form-control" disabled="" id="department" value="<?php echo $user_dept ?>" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE PREPARED</b></span>
                                    </div>
                                    <input type="date" class="form-control req" value="<?php echo date('Y-m-d') ?>" id="date_prepared" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>


                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE NEEDED</b></span>
                                    </div>
                                    <input type="date" class="form-control req" id="date_needed" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR NUMBER</b></span>
                                    </div>
                                    <input type="text" class="form-control req" id="pr_no" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>


                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PURPOSE</b></span>
                                    </div>
                                    <textarea class="form-control req" id="purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                                </div>
                            </div>

                            <?php if ($user_type=="Purchaser"): ?>

                                <div class="col col-md-12 mt-2" style="display: none;">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR TYPE</b></span>
                                        </div>
                                        <select class="form-control req" id="pr_type">
                                            <option disabled="">-- Select Pr type --</option>
                                            <option selected value="non">NON TRADE</option>
                                            <option value="local">TRADE LOCAL</option>
                                            <option value="import">TRADE IMPORT</option>
                                        </select>
                                    </div>
                                </div>

                            <?php else: ?>

                                <div class="col col-md-12 mt-2" style="display: none;">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR TYPE</b></span>
                                        </div>
                                        <select class="form-control req" id="pr_type">
                                            <option disabled="">-- Select Pr type --</option>
                                            <option selected value="non">NON TRADE</option>
                                            <option value="local">TRADE</option>
                                            <!-- <option value="import">TRADE IMPORT</option> -->
                                        </select>
                                    </div>
                                </div>
                                
                            <?php endif ?>
                            

                            <div class="col col-md-12 mt-4 mb-5">
                                <button type="button" class="btn btn-sm btn-secondary" id="savePR"><i class="fas fa-sm fa-save"></i> Save PR</button>
                            </div>
                            
                        </div>
                        
                    </div>

                    <div id="menu2" class="tab-pane fade"><br>
                        <div class="rowx">

                                <div class="col col-md-12 mt-2">
                                    <h4>PURCHASE REQUISITION LIST</h4><br>
                                </div>

                                <div class="responsive-table mt-2">
                                    <table id="PRListdone_table" class="table" width="100%">
                                        <thead>
                                            <th class="bg-header"></th>
                                            <th class="bg-header">Department</th>
                                            <th class="bg-header">Date Prepared</th>
                                            <th class="bg-header">Date Needed</th>
                                            <th class="bg-header">PR No</th>
                                            <th class="bg-header">Purpose</th>
                                            <th class="bg-header">Requested By</th>
                                            <th class="bg-header">Remarks</th>
                                            
                                        </thead>
                                    </table>
                                </div>    

                        </div>
                    </div>    

                    <div id="menu1" class="tab-pane fade"><br>
                        
                            <div class="rowx">

                                <div class="col col-md-12 mt-2">
                                    <h4>PURCHASE REQUISITION LIST</h4><br>
                                </div>

                                <div class="responsive-table mt-2" id="PR_table_div">
                                    <table id="PRList_table" class="table" width="100%">
                                        <thead>
                                            <th class="bg-header"></th>
                                            <th class="bg-header">Status</th>
                                            <th class="bg-header">Department</th>
                                            <th class="bg-header">Date Prepared</th>
                                            <th class="bg-header">Date Needed</th>
                                            <th class="bg-header">PR No</th>
                                            <th class="bg-header">Purpose</th>
                                            <th class="bg-header">Requested By</th>
                                            
                                        </thead>
                                    </table>
                                </div>    

                                <div class="rowx col col-md-12" id="PRdetails_div">

                                    <div class="col col-md-12 mb-3">
                                        <button class="btn btn-sm btn-info" type="button" onclick="btn_cancelPR()"><i class="fas fa-sm fa-arrow-left"></i> Back</button>
                                    </div>

                                    <div class="col col-md-12 mb-1">
                                        <input type="hidden" value="" class="form-control" id="pr_id" name="">
                                        <input type="hidden" value="" class="form-control" id="pr_details_id" name="">
                                        <h5 class="modal-title" id="exampleModalLabel">ITEM REQUEST DETAILS</h5><br>
                                    </div>
                                    

                                    <div class="col col-md-12 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>PURPOSE</b></span>
                                            </div>
                                            <input type="text" disabled="" class="form-control" id="view_purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>PR NO</b></span>
                                            </div>
                                            <input type="text" disabled="" class="form-control" id="View_pr_no" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>PR TYPE</b></span>
                                            </div>
                                            <input type="text" disabled="" class="form-control" id="View_pr_type" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>ITEM CODE</b></span>
                                            </div>
                                            <input type="text" class="form-control" id="item_code" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>STOCK ON HAND</b></span>
                                            </div>
                                            <input type="number" class="form-control" id="stock" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>RQMT</b></span>
                                            </div>
                                            <input type="number" class="form-control" id="rqmt" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-6 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text label4group-small" id="inputGroup-sizing-sm"><b>UOM</b></span>
                                            </div>
                                            <input type="text" class="form-control" id="uom" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-12 mt-2">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>ITEM DESCRIPTION</b></span>
                                            </div>
                                            <input type="text" class="form-control" id="item_description" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col col-md-12 mt-1 mb-5">
                                        <button type="button" class="btn btn-sm btn-secondary" id="savePR_details"><i class="fas fa-sm fa-save"></i> Save Entry</button>
                                    </div>

                                    <div class="responsive-table mt-5">
                                        <table id="PR_table" class="table" width="100%">
                                            <thead>
                                                <th class="bg-header">Action</th>
                                                <th class="bg-header">Item Code</th>
                                                <th class="bg-header">Stock on Hand</th>
                                                <th class="bg-header">RQMT</th>
                                                <th class="bg-header">UOM</th>
                                                <th class="bg-header">Item Description</th>
                                                
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="col col-md-12 mt-4 mb-5">
                                        <input type="text" id="name_Approver" value="<?php echo $department_head ?>" placeholder="Head Name" name="">
                                        <input type="text" id="email_Approver" value="<?php echo $department_email ?>" placeholder="Head Email" name="">
                                        <button type="button" class="btn btn-sm btn-success" id="submitPR"><i class="fas fa-sm fa-paper-plane"></i> Submit</button>
                                        <button type="button" class="btn btn-sm btn-success" id="submitPRtrade"><i class="fas fa-sm fa-paper-plane"></i> Submit</button>
                                    </div>
                                    
                                </div>

                            </div>
                            

                    </div>

                </div>

            </div>

        </div>

        </div>
                    


    </div>

         <div class="modal fade mt-5" id="PRModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Purchase Requisition Details</h5>
               </div>
               <div class="modal-body">

                    <div class="col col-md-12 mt-2">
                        <input type="hidden" class="form-control" id="PRid" name="">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                            </div>
                            <!-- <select class="form-control" id="pr_department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                <option disabled="" selected="">-- Select Department --</option>
                                <option value="Admin"> Admin Department</option>
                                <option value="IT"> IT Department</option>
                                <option value="HR">HR Department</option>
                                <option value="Accounting">Accounting Department</option>
                                <option value="Finance">Finance Department</option>
                                <option value="Purchasing">Purchasing Department</option>
                            </select> -->
                            <input type="text" class="form-control" disabled="" id="pr_department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE PREPARED</b></span>
                            </div>
                            <input type="date" class="form-control req2" id="pr_date_prepared" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE NEEDED</b></span>
                            </div>
                            <input type="date" class="form-control req2" id="pr_date_needed" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR NUMBER</b></span>
                            </div>
                            <input type="text" class="form-control req2" id="pr_pr_number" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PURPOSE</b></span>
                            </div>
                            <textarea class="form-control req2" id="pr_purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                        </div>
                    </div>

                    <?php if ($user_type=="Purchaser"): ?>

                        <div class="col col-md-12 mt-2" style="display: none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR TYPE</b></span>
                                </div>
                                <select class="form-control req2" id="pr_pr_type">
                                    <option disabled="">-- Select Pr type --</option>
                                    <option selected value="non">NON TRADE</option>
                                    <option value="local">TRADE LOCAL</option>
                                    <option value="import">TRADE IMPORT</option>
                                </select>
                            </div>
                        </div>

                    <?php else: ?>

                        <div class="col col-md-12 mt-2" style="display: none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PR TYPE</b></span>
                                </div>
                                <select class="form-control req2" id="pr_pr_type">
                                    <option disabled="">-- Select Pr type --</option>
                                    <option selected value="non">NON TRADE</option>
                                    <option value="local">TRADE</option>
                                    <!-- <option value="import">TRADE IMPORT</option> -->
                                </select>
                            </div>
                        </div>
                        
                    <?php endif ?>

                    

                    

               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-sm btn-primary" id="save_editPR">Save changes</button>
               </div>
             </div>
           </div>
         </div>
        

<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/pr/pr.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
    <?php 
        include 'services/pr/pr.js';
        include 'services/index/index.js';
    ?>
</script>