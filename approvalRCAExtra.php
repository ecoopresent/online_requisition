<?php 

date_default_timezone_set("Asia/Manila");
$meta_title = 'Request Cash Advance';

require_once "component/approvalheader.php";

require_once "controller/controller.db.php";
require_once "model/model.approvedpr.php";

$approvedpr = new Approvedpr();
$id = $_GET['id'];
$approver = $_GET['approver'];
$apprver_type = $_GET['at'];
$status = $approvedpr->checkStatusRCAextra($id);
$rca_info = $approvedpr->getRCAinfo($id);

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
                        <span class="fw-bold">Request Cash Advance</span>
                        <span class="float-end fw-normal text-secondary"><small>RCA<?php echo date('Y').'-'.$id ?></small></span>
                    </h5>
                    <?php if ($status=="") { ?>
                    <!-- -->
                    <ul class="timeline mt-5">

                        <?php if ($apprver_type=="twoC" || $apprver_type=="twoE"): ?>
                            <li class="done">
                                <span class="fw-bold"><?php echo $rca_info[0]; ?></span>
                                <span class="float-end text-secondary">Singed</span>
                                <p class="text-secondary">Requestor</p>
                            </li>
                        <?php else: ?>
                            <li>
                                <span class="fw-bold">Jasmin Padernal</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Department Head</p>
                            </li>
                        <?php endif ?>

                        <?php if ($apprver_type=="three"): ?>
                            <li class="">
                                <span class="fw-bold">Jerome T. Chua</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Operation Incharge</p>
                            </li>

                        <?php elseif($apprver_type=="twoE"): ?>

                            <li class="done">
                                <span class="fw-bold">Jasmin C. Padernal</span>
                                <span class="float-end text-secondary">Signed</span>
                                <p class="text-secondary">Department Head</p>
                            </li>

                        <?php else: ?>
                            <li class="done">
                                <span class="fw-bold">Jovan D. Palma</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Logistic Manager</p>
                            </li>
                        <?php endif ?>
                        
                        

                        <?php if ($apprver_type=="twoC" || $apprver_type=="twoE"): ?>

                            <li>
                                <span class="fw-bold">Jerome T. Chua</span>
                                <span class="float-end text-secondary">Pending</span>
                                <p class="text-secondary">Operation Incharge</p>
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
                        <input type="hidden" id="apprver_type" value="<?php echo $apprver_type ?>" name="">
                        <?php if ($apprver_type=="twoC" || $apprver_type=="twoE"): ?>
                            <button type="submit" class="btn btn-success mb-3" onclick="approve_RCAExtrafinal(<?= $id ?>)">Approve</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success mb-3" onclick="approve_RCAExtra(<?= $id ?>)">Approve</button>
                        <?php endif ?>
                        <button type="submit" class="btn btn-danger mb-3" onclick="disapprove_RCAExtra(<?= $id ?>)">Disapprove</button>
                    </div>
                </div>

                <?php } else { ?>
                    
                <!-- success message  -->
                <div class="col col-12">
                    <div class="my-3 text-start">
                        <div class="alert alert-success" role="alert">
                            Thank You.
                        </div>
                    </div>
                </div>

                <?php } ?>
            </div>

            <!-- end timeline -->


        </div>
    </div>
    <script src="services/approvedpr/approvedpr.js"></script>
</body>

</html>