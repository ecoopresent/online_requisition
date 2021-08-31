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


require_once "controller/controller.db.php";
require_once "model/model.pettycash.php";

$user_dept = $auth->getSession("user_dept");
$department_head = $auth->getSession("department_head");
$department_email = $auth->getSession("department_email");

$pettycash = new Pettycash();

$notifval = $pettycash->countPettycash($user_dept,'');
if($notifval > 0){
    $border = "background-color: #ff3333;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $border = "";
    $notifval = "";
}

$notifvals = $pettycash->countPettycash($user_dept,'Pending');
if($notifvals > 0){
    $borders = "background-color: #ff3333;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $borders = "";
    $notifvals = "";
}

$notifvalsPC = $pettycash->countPettycash($user_dept,'PreApp');
if($notifvalsPC > 0){
    $bordersPC = "background-color: #ff3333;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";
}else{
    $bordersPC = "";
    $notifvalsPC = "";
}

$notifval_preapproved = $pettycash->countPettycash($user_dept,'Approved');
$borderpreapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notifval_dis_A = $pettycash->countPettycash($user_dept,'Disapproved');
$notifval_dis_B = $pettycash->countPettycash($user_dept,'Disapproved1');

$notifval_disapproved = $notifval_dis_A + $notifval_dis_B;
$borderdisapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

$notif_A = $pettycash->countPettycash($user_dept,'Approved1');
$notif_B = $pettycash->countPettycash($user_dept,'Finished');
$notifval_approved = $notif_A + $notif_B;
$borderapproved = "background-color: #00334d;color: white;padding-left: 5px;padding-right: 5px;padding-top: 2px;padding-bottom: 2px;border-radius: 50px";

?>

<?php include 'component/sidenavPetty.php'; ?>

<div class="content">

    <div class="rowx">
            
    <div class="col col-md-12">

        <div class="tab_container">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettycashtab" href="#home"><i class="fas fa-md fa-money-bill-wave"></i> Petty Cash Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettycashlisttab" href="#menu1"><i class="fas fa-md fa-list"></i> Requests <span style="<?php echo $border; ?>"><?php echo $notifval; ?></span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettyPreapprovedPC" href="#menu1"><i class="fas fa-md fa-list"></i> Pre-Approved Petty Cash <span style="<?php echo $bordersPC; ?>"><?php echo $notifvalsPC; ?></span></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettyPreapproved" href="#menu1"><i class="fas fa-md fa-list"></i> Approved Petty Cash <span style="<?php echo $borders; ?>"><?php echo $notifvals; ?></span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettyApproved" href="#menu2"><i class="fas fa-md fa-list"></i> Pre-Approved <span style="<?php echo $borderpreapproved; ?>"><?php echo $notifval_preapproved; ?></span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettyDispproved" href="#menu2"><i class="fas fa-md fa-list"></i> Disapproved <span style="<?php echo $borderdisapproved; ?>"><?php echo $notifval_disapproved; ?></span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="pettyFinalApproved" href="#menu2"><i class="fas fa-md fa-list"></i> Approved <span style="<?php echo $borderapproved; ?>"><?php echo $notifval_approved; ?></span></a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>PETTY CASH VOUCHER</h4><br>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                </div>

                                <!-- <select class="form-control" name="department" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </select> -->
                                <input type="text" class="form-control" disabled="" value="<?php echo $user_dept ?>" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">


                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE</b></span>
                                </div>
                                <input type="date" class="form-control req" value="<?php echo date('Y-m-d') ?>" id="voucher_date" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> VOUCHER NO</b></span>
                                </div>
                                <input type="text" class="form-control req" id="voucher_no" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PARTICULARS</b></span>
                                </div>
                                <textarea class="form-control req" id="particulars" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> CASH ADVANCE</b></span>
                                </div>
                                <input type="number" class="form-control req" id="cash_advance" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2" style="display: none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>ACTUAL AMOUNT</b></span>
                                </div>
                                <input type="number" class="form-control" id="actual_amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> CHARGE TO</b></span>
                                </div>
                                <input type="text" class="form-control req" id="charge_to" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> TO BE LIQUIDATED ON</b></span>
                                </div>
                                <input type="date" class="form-control req" id="liquidated_on" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> REQUESTED BY</b></span>
                                </div>
                                <input type="text" class="form-control req" id="requested_by" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PAYEE</b></span>
                                </div>
                                <select class="form-control req" name="payee" id="payee" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-12 mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-5" id="savePettyCash"><i class="fas fa-sm fa-save"></i> Save Petty Cash</button>
                        </div>
                                
                    </div>
                            
                </div>

                <div id="menu2" class="tab-pane"><br>
                    
                    <div class="rowx">
                        <div class="col col-md-12 mt-2">
                            <h4>PETTY CASH REQUESTS</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="DonePettyTable" class="table" width="100%">
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
                                    <th class="bg-header">Remarks</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>   

                <div id="menu1" class="tab-pane"><br>

                    
                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>PETTY CASH REQUESTS</h4><br>
                        </div>

                        <div class="responsive-table mt-2" id="Petty_table_div">
                            <table id="PettycashlistTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Status</th>
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

                        <div class="rowx col col-md-12" id="Pettydetails_div">

                            <div class="col col-md-12 mb-3">
                                <button class="btn btn-sm btn-info" type="button" onclick="btn_cancelPetty()"><i class="fas fa-sm fa-arrow-left"></i> Back</button>
                            </div>

                            <div class="col col-md-12 mb-1">
                                <input type="hidden" value="" class="form-control" id="pettycash_id" name="">
                                <input type="hidden" value="" class="form-control" id="liquidation_id" name="">
                                <h5 class="modal-title" id="exampleModalLabel">LIQUIDATION DETAILS</h5><br>
                                <h1 class="text-success" id="labelSubmitted">-- SUBMITTED ALREADY --</h1>
                                <select class="p-1 mt-1 dropdown" id="LiquiType">
                                    <option value="">-- Select Type --</option>
                                    <option selected="" value="yes">With Liquidation</option>
                                    <option value="no">Without Liquidation</option>
                                </select>
                                <input type="text" id="name_Approver" value="<?php echo $department_head ?>" placeholder="Head Name" name="">
                                <input type="text" id="email_Approver" value="<?php echo $department_email ?>" placeholder="Head Email" name="">
                                <button class="btn btn-sm btn-success" id="saveType" type="button" onclick="saveType()" ><i class="fas fa-sm fa-paper-plane"></i> Submit</button>
                            </div>
                        <div class="rowx col col-md-12" id="liquidated_div">

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>NAME</b></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DATE</b></span>
                                    </div>
                                    <input type="date" class="form-control" id="liquidation_date" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                    </div>
                                    <input type="textarea" class="form-control" id="branch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-6 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>POSITION</b></span>
                                    </div>
                                    <input type="textarea" class="form-control" id="position" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>

                            <div class="col col-md-12 mt-2">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PARTICULARS</b></span>
                                    </div>
                                    <textarea class="form-control" id="eparticular" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                                </div>
                            </div>


                            <div class="col col-md-1 mt-1 mb-5">
                                <button type="button" class="btn btn-sm btn-secondary" id="saveliquidation"><i class="fas fa-sm fa-save"></i> Save</button>
                            </div>

                            <div class="responsive-table mt-5">
                                <h1>ROUTE</h1>
                                <table id="LiquidationDetails_table" class="table" width="100%">
                                    <thead>
                                        <th class="bg-header"><button type="button" id="btnRouteid" onclick="btnRoute()" class="btn btn-sm btn-success"><i class="fas fa-sm fa-plus"></i></button></th>
                                        <th class="bg-header">From</th>
                                        <th class="bg-header">To</th>
                                        <th class="bg-header">Vehicle</th>
                                        <th class="bg-header">Amount</th>

                                    </thead>
                                </table>    
                            </div>

                            <div class="col col-md-12 mt-1 mb-5">
                                <input type="number" id="super_actual_amount" name="">
                                <input type="text" id="name_ApproverWL" placeholder="Head Name" value="<?php echo $department_head ?>" name="">
                                <input type="text" id="email_ApproverWL" placeholder="Head Email" value="<?php echo $department_email ?>" name="">
                                <button class="btn btn-sm btn-success" id="saveTypewithLiqui" type="button" onclick="saveType()" ><i class="fas fa-sm fa-paper-plane"></i> Submit</button>
                            </div>

                        </div>
                                    
                        </div>                        

                    </div>

                </div>

            </div>

        </div>

    </div>

    </div>
                    
</div>


<div class="modal fade mt-5" id="PettycashModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Petty Cash Details</h5>
            </div>
            <div class="modal-body">

                <div class="col col-md-12 mt-2">
                    <input type="hidden" class="form-control" id="PettyID" name="">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                        </div>

                        <!-- <select class="form-control" name="petty_department" id="petty_department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </select> -->
                        <input type="text" class="form-control" disabled="" id="petty_department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> DATE</b></span>
                        </div>
                        <input type="date" class="form-control req2" id="petty_date" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> VOUCHER NO</b></span>
                        </div>
                        <input type="text" class="form-control req2" id="petty_voucherno" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> PARTICULARS</b></span>
                        </div>
                        <textarea class="form-control req2" id="petty_particulars" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> CASH ADVANCE</b></span>
                        </div>
                        <input type="text" class="form-control req2" id="petty_cash_advance" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>ACTUAL AMOUNT</b></span>
                        </div>
                        <input type="text" class="form-control" id="petty_actual_amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> CHARGE TO</b></span>
                        </div>
                        <input type="text" class="form-control req2" id="petty_charge_to" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> TO BE LIQUIDATED ON</b></span>
                        </div>
                        <input type="date" class="form-control req2" id="petty_liquidated_on" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b><span class="text-danger">*</span> REQUESTED BY</b></span>
                        </div>
                        <input type="text" class="form-control req2" id="petty_requested_by" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-primary" id="save_editPR">Save changes</button>
            </div>
        </div>
    </div>

</div>







<div class="modal fade mt-5" id="LiquidationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Route Details</h5>
            </div>
            <div class="modal-body">

                <div class="col col-md-12 mt-2">
                    <input type="hidden" class="form-control" id="liquiDetailsID" name="">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>FROM</b></span>
                        </div>
                        <input type="text" class="form-control" id="l_from" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>TO</b></span>
                        </div>
                        <input type="text" class="form-control" id="l_to" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>VEHICLE TYPE</b></span>
                        </div>
                        <input type="text" class="form-control" id="Vehicle_type" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>AMOUNT</b></span>
                        </div>
                        <input type="number" class="form-control" id="l_amount" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-primary" id="save_Route">Save changes</button>
            </div>
        </div>
    </div>

</div>


<div class="modal fade mt-5" id="pcvModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md">
        <div class="modal-content" style="margin-top: 200px">

            <div class="modal-body">
                <p style="text-align: center;font-weight: bold;">
                    <br><br>
                    Successfully Saved! Voucher no - <span style="color: red" id="pcvv"></span><br><br>
                    <button type="button" onclick="refreshPC()" class="btn btn-sm btn-info">OK</button>
                </p>

            </div>

        </div>
    </div>

</div>

        

<?php
require_once "component/footer.php";
?>  
<script src="services/pettycash/pettycash.js"></script>
<script src="services/index/index.js"></script>