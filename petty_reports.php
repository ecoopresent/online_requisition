<?php 
date_default_timezone_set("Asia/Manila");
$meta_title = 'RCA REPORTS';

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
                            <h4><i class="fas fa-md fa-file-csv"></i> PETTY CASH VOUCHER REPORTS</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <label>Filter By: Date Prepared</label>
                            <input id="date_prepared" type="date" name="">
                            <input id="date_preparedto" type="date" name="">
                            <label>Department: </label>
                            <select class="p-1" name="department" id="department" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </select>
                            <button type="button" onclick="searchP()">Search</button>
                            <table id="Pettycash_table" class="table mt-2">
                                <thead>
                                    <th class="bg-header">Voucher No</th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">Voucher Date</th>
                                    <th class="bg-header">Particulars</th>
                                    <th class="bg-header">Cash Advance</th>
                                    <th class="bg-header">Actual Amount</th>
                                        
                                </thead>
                            </table>
                            <button type="button" onclick="export_P('pdf')">Export to PDF</button>
                            <button type="button" onclick="export_P('excel')">Export to EXCEL</button>
                        </div>

                    </div>
                        
                </div>

        </div>



<?php
require_once "component/footer.php";
?>  
<script src="services/reports/reports.js"></script>
<script src="services/index/index.js"></script>