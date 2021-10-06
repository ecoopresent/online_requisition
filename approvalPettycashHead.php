<?php 

date_default_timezone_set("Asia/Manila");
$meta_title = 'Request Cash Advance';

require_once "component/approvalheader.php";

require_once "controller/controller.db.php";
require_once "model/model.pettycash.php";

$pettycash = new Pettycash();
$id = $_GET['id'];
$approver = $_GET['approver'];
$status = $pettycash->checkStatusApp($id);
$voucher_info = $pettycash->getVoucherinfo($id);
$v_status = $voucher_info[3];
$alert_color = "success";
if($v_status=="PreApp" || $v_status=="Pending" || $v_status=="Submitted" || $v_status=="Approved1" || $v_status=="Approved"){
    $v_status = "approved";
}
if($v_status=="Disapproved" || $v_status=="Disapproved1"){
    $v_status = "disapproved";
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
    <title>Panamed Philippines Incorporation</title>
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
            border: 3px solid #0044cc;
            background: #4d88ff;
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
                <img src="https://panamed.com.ph/assets/graphics/logo.jpg" alt="Panamed Philippines Incorporation's Logo" width="180" class="d-block mx-auto mb-5" />
            </div>

            <!-- start timeline -->

            <div class="row">
                <div class="col col-12">
                    <h5 class="text-start fw-bold">
                        <span class="fw-bold">Petty Cash Request</span>
                        <span class="float-end fw-normal text-secondary"><small><?php echo $voucher_info[0] ?></small></span>
                    </h5>
                    <?php if ($status=="") { ?>
                    <!-- -->
                    <ul class="timeline mt-5">

                        <li class="done">
                            <span class="fw-bold"><?php echo $voucher_info[1]; ?></span>
                            <span class="float-end text-secondary">Signed</span>
                            <p class="text-secondary">Requestor</p>
                        </li>

                        <li>
                            <span class="fw-bold"><?php echo $approver; ?></span>
                            <span class="float-end text-secondary">Pending</span>
                            <p class="text-secondary">Approver</p>
                        </li>

                        <li>
                            <span class="fw-bold">Jerome T. Chua</span>
                            <span class="float-end text-secondary">Pending</span>
                            <p class="text-secondary">Logistic Manager</p>
                        </li>
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
                        <input type="hidden" id="apprver_type" value="<?php echo $apprver_type ?>" name="">
                        <button type="submit" class="btn btn-success mb-3" onclick="approve_PC(<?= $id ?>)">Approve</button>
                        <button type="submit" class="btn btn-danger mb-3" onclick="disapprove_Pettycash(<?= $id ?>)">Disapprove</button>
                    </div>
                </div>

                <?php } else { ?>
                    
                <!-- success message  -->
                <div class="col col-12">
                    <div class="my-3 text-start">
                        <div class="alert alert-<?= $alert_color ?>" role="alert">
                            This request was <?= $v_status ?>. Thank You.
                        </div>
                    </div>
                </div>

                <?php } ?>
            </div>

            <!-- end timeline -->


        </div>
    </div>
    <!-- <script src="services/petty_approval/petty_approval.js"></script> -->
</body>
<script type="text/javascript">
<?php 
    include 'services/petty_approval/petty_approval.js';
?>
</script>
</html>