
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

<?php include 'component/sidenavIndex.php'; ?>

<div class="content">

    <div class="rowx">
            
    <div class="col col-md-12">

        <div class="tab_container">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="newpayeeTab" href="#home"><i class="fas fa-md fa-user-plus"></i> Add New Payee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="payeetab" href="#menu1"><i class="fas fa-md fa-user-cog"></i> Payee</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>ADD NEW PAYEE</h4><br>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE NAME</b></span>
                                </div>
                                <input type="text" class="form-control" id="payee_name" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE EMAIL</b></span>
                                </div>
                                <input type="text" class="form-control" id="payee_email" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE DEPARTMENT</b></span>
                                </div>
                                <select class="form-control" name="payee_dept" id="payee_dept" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-12 mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-5" id="savePayee"><i class="fas fa-sm fa-save"></i> Save Department</button>
                        </div>
                                
                    </div>
                            
                </div>

                <div id="menu1" class="tab-pane"><br>

                    

                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>PAYEE</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="payeeTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Payee Name</th>
                                    <th class="bg-header">Payee Email</th>
                                    <th class="bg-header">Payee Department</th>
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



<div class="modal fade mt-5" id="payeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Payee Details</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eid" name="">
                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE NAME</b></span>
                        </div>
                        <input type="text" class="form-control" id="epayee_name" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE EMAIL</b></span>
                        </div>
                        <input type="text" class="form-control" id="epayee_email" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>PAYEE DEPARTMENT</b></span>
                        </div>
                        <select class="form-control" name="epayee_dept" id="epayee_dept" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </select>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-primary" id="updatePayee">Save changes</button>
            </div>
        </div>
    </div>

</div>

        

<?php
require_once "component/footer.php";
?>  
<script src="services/payee/payee.js"></script>
<script src="services/index/index.js"></script>