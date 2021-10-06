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
                    <a class="nav-link" data-toggle="tab" id="Tabtab" href="#home"><i class="fas fa-md fa-user-plus"></i> Logs</a>
                </li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane active"><br>

                    
                    <div class="rowx">

                        <div class="col col-md-12 mt-2">
                            <h4>LOGS</h4><br>
                        </div>

                        <div class="responsive-table mt-2">
                            <table id="auditTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header">Action</th>
                                    <th class="bg-header">Date</th>
                                    <th class="bg-header">User</th>
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
    include 'services/audit/audit.js';
    include 'services/index/index.js';
?>
</script>