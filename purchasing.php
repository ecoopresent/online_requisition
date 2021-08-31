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

                    

                    <div class="responsive-table mt-2" id="canvas_div">

                        <h4><i class="fas fa-md fa-poll-h"></i> PR TO BE CANVASSED</h4><br>


                        <table id="Prequest_table" class="table">
                            <thead>
                                <th class="bg-header"></th>
                                <th class="bg-header"></th>
                                <th class="bg-header">PR Type</th>
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

                    <div class="rowx col col-md-12" id="canvas_details_div">

                        <div class="col col-md-12 mb-3">
                            <button class="btn btn-md btn-info" type="button" onclick="btn_cancelCanvas()"><i class="fas fa-sm fa-arrow-left"></i> Back</button>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <h4><i class="fas fa-md fa-poll-h"></i> CANVAS SHEET DETAILS</h4><br>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DEPARTMENT</b></span>
                                </div>
                                <input type="text" class="form-control" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text labellgroup" id="inputGroup-sizing-sm"><b>DATE PREPARED</b></span>
                                </div>
                                <input type="date" class="form-control" id="date_prepared" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DATE NEEDED</b></span>
                                </div>
                                <input type="date" class="form-control" id="date_needed" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PR NUMBER</b></span>
                                </div>
                                <input type="text" class="form-control" id="pr_no" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>PURPOSE</b></span>
                                </div>
                                <textarea class="form-control" id="purpose" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
                            </div>
                        </div>


                        <div class="responsive-table mt-4">
                            <table id="Pr_details_table" class="table">
                                <thead>
                                    <th class="bg-header">Item Code</th>
                                    <th class="bg-header">Stock on Hand</th>
                                    <th class="bg-header">RQMT</th>
                                    <th class="bg-header">UOM</th>
                                    <th class="bg-header">Item Description</th>
                                </thead>
                            </table>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <h1>Set Canvas Details</h1>
                            <input type="hidden" id="pr_id" name="">
                            <input type="hidden" id="canvas_id" name="">
                        </div>


                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>DATE</b></span>
                                </div>
                                <input type="date" value="<?php echo date('Y-m-d') ?>" class="form-control" id="canvas_date" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>SUPPLIER 1</b></span>
                                </div>
                                <input type="text" class="form-control" id="supplier1" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>SUPPLIER 2</b></span>
                                </div>
                                <input type="text" class="form-control" id="supplier2" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>SUPPLIER 3</b></span>
                                </div>
                                <input type="text" class="form-control" id="supplier3" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>SUPPLIER 4</b></span>
                                </div>
                                <input type="text" class="form-control" id="supplier4" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-6 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>SUPPLIER 5</b></span>
                                </div>
                                <input type="text" class="form-control" id="supplier5" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-2">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>REMARKS</b></span>
                                </div>
                                <input type="text" class="form-control" id="remarks" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>

                        <div class="col col-md-12 mt-4 mb-5">

                            <button class="btn btn-md btn-secondary" id="save_canvas"><i class="fas fa-sm fa-save"></i> Save</button>

                        </div>

                    </div>

                </div>

            </div>

        </div>    


            
                



<?php
require_once "component/footer.php";
?>  
<script src="services/purchasing/purchasing.js"></script>
<script src="services/index/index.js"></script>