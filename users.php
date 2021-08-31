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
                    <a class="nav-link" data-toggle="tab" id="newuserTab" href="#home"><i class="fas fa-md fa-user-plus"></i> Add New User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" id="useraccountstab" href="#menu1"><i class="fas fa-md fa-user-cog"></i> User accounts</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>ADD NEW USER</h4><br>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>FULL NAME</b></span>
                                </div>
                                <input type="text" class="form-control" id="full_name" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>


                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>USER NAME</b></span>
                                </div>
                                <input type="text" class="form-control" id="username" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>



                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PASSWORD</b></span>
                                </div>
                                <input type="password" class="form-control" id="password" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                </div>
                                <select class="form-control" name="department" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>USER TYPE</b></span>
                                </div>
                                <select class="form-control" id="user_type" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    <option disabled="" selected="">-- Select User Type --</option>
                                    <option value="Administrator" >Administrator</option>
                                    <option value="Approver" >Approver</option>
                                    <option value="Enduser" >End-User</option>
                                    <option value="Accounting" >Accounting</option>
                                    <option value="Purchaser" >Purchaser</option>
                                    <option value="Logistics" >Logistics</option>
                                </select>
                            </div>
                        </div>


                        <div class="col col-md-12 mt-4">
                            <button type="button" class="btn btn-md btn-secondary mb-5" id="saveUser"><i class="fas fa-sm fa-save"></i> Save User</button>
                        </div>
                                
                    </div>
                            
                </div>

                <div id="menu1" class="tab-pane"><br>

                    

                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>USER ACCOUNTS</h4><br>
                        </div>

                        <div class="input-group mb-4 padded">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary" disabled="" type="button" data-toggle="modal" data-target="#userModal"><i class="fas fa-sm fa-search"></i> Search</button>
                            </div>
                            <input id="dataTableSearch" type="search" class="form-control rounded-0 search-field" placeholder="Search here">
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="usersTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Full Name</th>
                                    <th class="bg-header">User Name</th>
                                    <th class="bg-header">Password</th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">User Type</th>
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



<div class="modal fade mt-5" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

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
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>FULL NAME</b></span>
                        </div>
                        <input type="text" class="form-control" id="efull_name" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>


                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>USER NAME</b></span>
                        </div>
                        <input type="text" class="form-control" id="eusername" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>



                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PASSWORD</b></span>
                        </div>
                        <input type="text" class="form-control" id="epassword" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>

                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                        </div>
                        <select class="form-control" name="edepartment" id="edepartment" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </select>
                    </div>
                </div>


                <div class="col col-md-12 mt-2">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>USER TYPE</b></span>
                        </div>
                        <select class="form-control" id="euser_type" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <option disabled="" selected="">-- Select User Type --</option>
                            <option value="Administrator" >Administrator</option>
                            <option value="Approver" >Approver</option>
                            <option value="Enduser" >End-User</option>
                            <option value="Accounting" >Accounting</option>
                            <option value="Purchaser" >Purchaser</option>
                            <option value="Logistics" >Logistics</option>
                        </select>
                    </div>
                </div>

                

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sm btn-primary" id="updateUser">Save changes</button>
            </div>
        </div>
    </div>

</div>

        

<?php
require_once "component/footer.php";
?>  
<script src="services/users/users.js"></script>
<script src="services/index/index.js"></script>