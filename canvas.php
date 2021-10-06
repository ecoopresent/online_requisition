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
require_once "controller/controller.db.php";
require_once "model/model.canvasing.php";

$canvasing = new Canvasing();
$canvas_info = $canvasing->getCanvasInfos($_GET['id']);
$pr_id = $canvas_info['pr_id'];
$pr_type = $canvasing->getPrtype($pr_id);
 ?>
        <?php include 'component/sidenavPr.php'; ?>

        <div class="content">
            <div class="tab_container">
            
                <div class="rowx">
                    <input type="hidden" value="<?php echo $_GET['id'] ?>" id="canvas_id" name="">
                    <input type="hidden" value="<?php echo $canvas_info['pr_id'] ?>" id="pr_id" name="">
                    <div class="rowx col col-md-12" id="canvas_details_div">
                        <div class="col col-md-12 mb-3">
                            <button class="btn btn-md btn-info" type="button" onclick="btn_cancelCanvas()"><i class="fas fa-sm fa-arrow-left"></i> Back</button>
                        </div>
                        <div class="col col-md-12 mt-2">
                            <h4><i class="fas fa-md fa-poll-h"></i> CANVASS SHEET</h4><br>
                        </div>

                        <div class="responsive-table mt-4">
                            <button class="btn btn-sm btn-primary mb-2" type="button" onclick="addnewCanvas()"><i class="fas fa-sm fa-plus"></i> Add new</button>
                            <table id="canvas_details_table" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">QTY</th>
                                    <th class="bg-header">UOM</th>
                                    <th class="bg-header">PRODUCT DESCRIPTION</th>
                                    <th class="bg-secondary text-light"><?php echo $canvas_info['supplier1']; ?></th>
                                    <th class="bg-secondary text-light"><?php echo $canvas_info['supplier2']; ?></th>
                                    <th class="bg-secondary text-light"><?php echo $canvas_info['supplier3']; ?></th>
                                    <th class="bg-secondary text-light"><?php echo $canvas_info['supplier4']; ?></th>
                                    <th class="bg-secondary text-light"><?php echo $canvas_info['supplier5']; ?></th>
                                </thead>
                            </table>
                        </div>
                        <?php if ($_GET['id'] != 0): ?>
                            
                            <div class="col col-md-12 mb-3">

                                <button class="btn btn-md btn-success" type="button" onclick="addAttach(<?= $pr_id ?>)"><i class="fas fa-sm fa-paperclip"></i> Attach</button>
                                <button class="btn btn-md btn-primary" type="button" onclick="viewCanvas(<?= $pr_id ?>)"><i class="fas fa-sm fa-eye"></i> View</button>
                                <?php if ($pr_type=="non"): ?>
                                    <button class="btn btn-md btn-secondary" type="button" onclick="sendCanvas()"><i class="fas fa-sm fa-paper-plane"></i> Send</button>
                                <?php elseif($pr_type=="local"): ?>
                                    <button class="btn btn-md btn-secondary" type="button" onclick="sendCanvaslocal()"><i class="fas fa-sm fa-paper-plane"></i> Send</button>
                                <?php else: ?>
                                    <button class="btn btn-md btn-secondary" type="button" onclick="sendCanvasimport()"><i class="fas fa-sm fa-paper-plane"></i> Send</button>
                                <?php endif ?>
                                
                            </div>
                                
                        <?php endif ?>

                    </div>

                </div>

            </div>

        </div>  


        <div class="modal fade" id="CanvasSheetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Canvas Sheet Details</h5>
               </div>
               <div class="modal-body">

                    <div class="col col-md-12 mt-2">
                        <input type="hidden" class="form-control" id="c_details_id" name="">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm">QTY</span>
                            </div>
                            <input type="text" class="form-control" id="qty" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm">UOM</span>
                            </div>
                            <input type="text" class="form-control" id="uom" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label4group" id="inputGroup-sizing-sm">PROD DESC</span>
                            </div>
                            <input type="text" class="form-control" id="product_desc" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labelgroup" id="inputGroup-sizing-sm"><?php echo $canvas_info['supplier1']; ?></span>
                            </div>
                            <input type="text" class="form-control" id="pri1" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <input type="text" style="display: none;" class="form-control" id="price1" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labelgroup" id="inputGroup-sizing-sm"><?php echo $canvas_info['supplier2']; ?></span>
                            </div>
                            <input type="text" class="form-control" id="pri2" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <input type="text" style="display: none;" class="form-control" id="price2" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labelgroup" id="inputGroup-sizing-sm"><?php echo $canvas_info['supplier3']; ?></span>
                            </div>
                            <input type="text" class="form-control" id="pri3" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <input type="text" style="display: none;" class="form-control" id="price3" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labelgroup" id="inputGroup-sizing-sm"><?php echo $canvas_info['supplier4']; ?></span>
                            </div>
                            <input type="text" class="form-control" id="pri4" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <input type="text" style="display: none;" class="form-control" id="price4" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

                    <div class="col col-md-12 mt-2">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text labelgroup" id="inputGroup-sizing-sm"><?php echo $canvas_info['supplier5']; ?></span>
                            </div>
                            <input type="text" class="form-control" id="pri5" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            <input type="text" style="display: none;" class="form-control" id="price5" value="0" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        </div>
                    </div>

               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                 <button type="button" class="btn btn-sm btn-primary" id="save_editCanvas">Save changes</button>
               </div>
             </div>
           </div>
        </div>



    <div class="modal fade mt-5" id="attachmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Attach Files</h5>
                </div>
                <div class="modal-body">
                    <form action="controller/controller.canvasing.php?mode=upload" method="post" enctype="multipart/form-data">
                        <div class="col col-md-12 mt-2">
                            <input type="hidden" value="<?php echo $_GET['id'] ?>" id="canvass_id" name="canvass_id">
                            <input type="hidden" id="preq_id" name="preq_id">
                            <span class="input-group-text label4group" id="inputGroup-sizing-sm"><b>Select Attachment</b></span>
                            <input type="file" class="form-control" name="pr_attachment">
                        </div>
                        <div class="col col-md-12 mt-2">
                            <center>
                                <button type="submit" class="btn btn-sm btn-info"><i class="fas fa-sm fa-upload"></i> UPLOAD</button>
                            </center>
                        </div>
                    </form>
                        <div class="col col-md-12 mt-2">
                            <table id="attachmentTable" class="table" width="100%">
                                <thead>
                                    <th class="bg-header"></th>
                                    <th class="bg-header">Attachment</th>
                                </thead>
                            </table>
                        </div>
                        
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>
            
                



<?php
require_once "component/footer.php";
?>  
<!-- <script src="services/canvasing/canvasing.js"></script>
<script src="services/index/index.js"></script> -->

<script type="text/javascript">
<?php 
    include 'services/canvasing/canvasing.js';
    include 'services/index/index.js';
?>
</script>