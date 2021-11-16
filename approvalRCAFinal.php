<?php 

date_default_timezone_set("Asia/Manila");
$meta_title = 'Request Cash Advance';

require_once "component/approvalheader.php";

require_once "controller/controller.db.php";
require_once "model/model.approvedpr.php";

$approvedpr = new Approvedpr();
$id = $_GET['id'];
$approver = $_GET['approver'];
$approver_type = $_GET['at'];
if($approver_type=="twoA"){
    $approver = "Mary Ann Miranda";
}
if($approver_type=="three"){
    $approver = "Mary Ann Miranda";
}
$status = $approvedpr->checkStatusRCAfinal($id);
$rca_info = $approvedpr->getRCAinfo($id);
$rca_status = $rca_info[1];
$alert_color = "success";
if($rca_status=="Finished" || $rca_status=="PreApproved" || $rca_status=="Approved"){
    $rca_status = "approved";
}
if($rca_status=="Disapproved"){
    $rca_status = "disapproved";
    $alert_color = "danger";
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <title>Progressive Medical Corporation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>

        html, body {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }

        .wrapper {
            max-width: 600px;
            background: #ffffff;
        }
        ul.timeline {
            list-style-type: none;
            position: relative;
        }
        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
            z-index: 1;
        }
        ul.timeline > li {
            margin: 20px 0;
            padding-left: 20px;
            z-index: 2;
        }
        ul.timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #ddd;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }

        ul.timeline > li.done:before {
            border: 3px solid #85c232;
            background: #a7e156;
        }

        .btn-success {
            border-color: #85c232;
            background: #85c232;
        }


    </style>
</head>

<body style="background: #f5f5f5;">
    <div class="wrapper d-block position-relative w-100 mx-auto p-5 my-5">
        <div class="row">
            <div class="col col-12">
                <img src="https://pmc.ph/assets/logo.png" alt="Progressive Medical Corporation's Logo" width="180" class="d-block mx-auto mb-5" />
            </div>

            <!-- start timeline -->

            <div class="row">
                <div class="col col-12">
                    <h5 class="text-start fw-bold">
                        <span class="fw-bold">Request Cash Advance</span>
                        <span class="float-end fw-normal text-secondary"><small>RCA<?php echo date('Y').'-'.$id ?></small></span>
                    </h5>
                    <?php if ($status=="") { ?>
                    <!-- -->
                    <ul class="timeline mt-5">

                        <li class="done">
                            <span class="fw-bold"><?php echo $rca_info[0]; ?></span>
                            <span class="float-end text-secondary">Signed</span>
                            <p class="text-secondary">Requestor</p>
                        </li>

                        <?php if ($approver_type=="twoB"): ?>
                            <li class="done">
                                <span class="fw-bold">Nancy G. Cortez</span>
                                <span class="float-end text-secondary">Signed</span>
                                <p class="text-secondary">Department Head</p>
                            </li>
                        <?php elseif($approver_type=="twoC"): ?>
                            <li class="done">
                                <span class="fw-bold">Mary Ann Miranda</span>
                                <span class="float-end text-secondary">Signed</span>
                                <p class="text-secondary">Product Sourcing Specialist</p>
                            </li>
                        <?php else: ?>
                            <li class="done">
                                <span class="fw-bold">Susan T. Panugayan</span>
                                <span class="float-end text-secondary">Signed</span>
                                <p class="text-secondary">General Manager</p>
                            </li>
                        <?php endif ?>

                        <?php if ($approver_type=="three"): ?>

                            <li>
                                <span class="fw-bold">Mary Ann Miranda</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Product Sourcing Specialist</p>
                            </li>

                            
                        <?php endif ?>

                        <?php if ($approver_type=="triple"): ?>

                            <li class="done">
                                <span class="fw-bold">Mary Ann Miranda</span>
                                <span class="float-end text-secondary">Signed</span>
                                <p class="text-secondary">Product Sourcing Specialist</p>
                            </li>

                            
                        <?php endif ?>
                        

                        <?php if ($approver_type=="twoA"): ?>

                            <li>
                                <span class="fw-bold">Mary Ann Miranda</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Product Sourcing Specialist</p>
                            </li>

                        <?php else: ?>

                            <li>
                                <span class="fw-bold">Homer C. Lim</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Chief Product Developer</p>
                            </li>

                            
                        <?php endif ?>
                        
                    </ul>
                    <?php } ?>
                </div>
                <?php if ($status=="") { ?>
                
                <div class="col col-12">
                    <div class="my-3">
                        <h5 class="text-start mb-3 fw-bold">Remarks <small class="fw-normal">(optional)</small></h5>
                        <textarea class="form-control" id="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="col col-12">
                    <div class="my-3 text-end">

                        <input type="hidden" id="approver" value="<?php echo $approver ?>" name="">
                        <input type="hidden" id="apprver_type" value="<?php echo $approver_type ?>" name="">
                        <button type="submit" class="btn btn-success mb-3" onclick="F_approve_RCA(<?= $id ?>)">Approve</button>
                        <button type="submit" class="btn btn-danger mb-3" onclick="F_disapprove_RCA(<?= $id ?>)">Disapprove</button>
                    </div>
                </div>

                <?php } else { ?>
                    
                <!-- success message  -->
                <div class="col col-12">
                    <div class="my-3 text-start">
                        <div class="alert alert-<?= $alert_color ?>" role="alert">
                            This request was <?= $rca_status ?>. Thank You.
                        </div>
                    </div>
                </div>

                <?php } ?>
            </div>

            <!-- end timeline -->


        </div>
    </div>
    <!-- <script src="services/approvedpr/approvedpr.js"></script> -->
</body>
<script type="text/javascript">
    <?php 
        include 'services/approvedpr/approvedpr.js';
    ?>
</script>
</html>