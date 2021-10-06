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

        <?php include 'component/sidenavPr.php'; ?>

        <div class="content">

                <div class="tab_container">
                    
                    <div class="rowx">

                        <div class="col-md-12">
                            <h4><i class="fas fa-md fa-file-csv"></i> RCA REPORTS</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <label>Filter By: Date Prepared</label>
                            <input id="date_prepared" type="date" name="">
                            <input id="date_preparedto" type="date" name="">
                            <button type="button" onclick="search()">Search</button>
                            <table id="Cashrequest_table" class="table mt-2">
                                <thead>
                                    <th class="bg-header">RCA Id</th>
                                    <th class="bg-header">Department</th>
                                    <th class="bg-header">Payee</th>
                                    <th class="bg-header">Date Prepared</th>
                                    <th class="bg-header">Date Needed</th>
                                    <th class="bg-header">Amount</th>
                                        
                                </thead>
                            </table>
                            <button type="button" onclick="export_('pdf')">Export to PDF</button>
                            <button type="button" onclick="export_('excel')">Export to EXCEL</button>
                        </div>

                    </div>
                        
                </div>

        </div>



<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/reports/reports.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
    <?php 
        include 'services/reports/reports.js';
        include 'services/index/index.js';
    ?>
</script>