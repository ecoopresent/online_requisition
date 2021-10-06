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
                    <a class="nav-link" data-toggle="tab" id="newuserTab" href="#home"><i class="fas fa-md fa-user-plus"></i> Add New Department</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="useraccountstab" href="#menu1"><i class="fas fa-md fa-user-cog"></i> Departments</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>ADD NEW DEPARTMENT</h4><br>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT NAME</b></span>
                                </div>
                                <input type="text" class="form-control" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT HEAD</b></span>
                                </div>
                                <input type="text" class="form-control" id="department_head" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT EMAIL</b></span>
                                </div>
                                <input type="text" class="form-control" id="department_email" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>



                        <div class="col col-md-12 mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-5" id="saveDepartment"><i class="fas fa-sm fa-save"></i> Save Department</button>
                        </div>
                                
                    </div>
                            
                </div>

                <div id="menu1" class="tab-pane"><br>

                    

                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>DEPARTMENTS</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="departmentTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Department Name</th>
                                    <th class="bg-header">Department Head</th>
                                    <th class="bg-header">Department Email</th>
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



<div class="modal fade mt-5" id="deptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eid" name="">
                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT NAME</b></span>
                        </div>
                        <input type="text" class="form-control" id="edepartment" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT HEAD</b></span>
                        </div>
                        <input type="text" class="form-control" id="edepartment_head" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DEPARTMENT EMAIL</b></span>
                        </div>
                        <input type="text" class="form-control" id="edepartment_email" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-primary" id="updateDept">Save changes</button>
            </div>
        </div>
    </div>

</div>

        

<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/department/department.js"></script>
<script src="services/index/index.js"></script> -->
<script type="text/javascript">
    <?php 
        include 'services/department/department.js';
        include 'services/index/index.js';
    ?>
</script>