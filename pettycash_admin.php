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
                    <a class="nav-link" data-toggle="tab" id="Tabtab" href="#home"><i class="fas fa-md fa-user-plus"></i> Petty Cash Requests</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>List</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="pcadminTable" class="table" width="100%">
                                <thead>
                                    <th></th>
                                    <th class="bg-header">Status</th>
                                    <th class="bg-header">Voucher No.</th>
                                    <th class="bg-header">Date</th>
                                    <th class="bg-header">Particulars</th>
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


<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/audit/audit.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
    <?php 
        include 'services/pettycash_admin/pettycash_admin.js';
        include 'services/index/index.js';
    ?>
</script>