<?php 
require_once "controller.sanitizer.php";
require_once "controller.db.php";
require_once "../model/model.canvasing.php";

$canvasing = new Canvasing();
$mode = Sanitizer::filter('mode', 'get');

switch($mode) {
	
    case "table";
        $canvas_id = Sanitizer::filter('canvas_id', 'get');
        $canvasing = $canvasing->getCanvasDetails($canvas_id);
        foreach($canvasing as $k=>$v) {
            $canvasing[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='editCanvasDetails(".$v['id'].",".$v['qty'].",\"".$v['uom']."\",\"".$v['product_desc']."\",\"".$v['price1']."\",\"".$v['price2']."\",\"".$v['price3']."\",\"".$v['price4']."\",\"".$v['price5']."\")'><i class='fas fa-sm fa-edit'></i> Edit</button>
            <button class='btn btn-danger btn-sm' onclick='deleteCanvasDetails(".$v['id'].")'><i class='fas fa-sm fa-trash'></i> Delete</button>";
            $canvasing[$k]['Price1'] = number_format($v['price1'],2);
            $canvasing[$k]['Price2'] = number_format($v['price2'],2);
            $canvasing[$k]['Price3'] = number_format($v['price3'],2);
            $canvasing[$k]['Price4'] = number_format($v['price4'],2);
            $canvasing[$k]['Price5'] = number_format($v['price5'],2);
        }
        $response = array("data" => $canvasing);
        break;

    case "updateCanvasDet";
        $c_details_id = Sanitizer::filter('c_details_id', 'post');
        $qty = Sanitizer::filter('qty', 'post');
        $uom = Sanitizer::filter('uom', 'post');
        $product_desc = Sanitizer::filter('product_desc', 'post');
        $price1 = Sanitizer::filter('price1', 'post');
        $price2 = Sanitizer::filter('price2', 'post');
        $price3 = Sanitizer::filter('price3', 'post');
        $price4 = Sanitizer::filter('price4', 'post');
        $price5 = Sanitizer::filter('price5', 'post');

        $canvasing->update_CanvasDetails($c_details_id,$qty,$uom,$product_desc,$price1,$price2,$price3,$price4,$price5);

        $response = array("code"=>1,"message"=>"Canvas details Updated");
        break;

    case "addCanvasDet";
        $qty = Sanitizer::filter('qty', 'post');
        $uom = Sanitizer::filter('uom', 'post');
        $product_desc = Sanitizer::filter('product_desc', 'post');
        $price1 = Sanitizer::filter('price1', 'post');
        $price2 = Sanitizer::filter('price2', 'post');
        $price3 = Sanitizer::filter('price3', 'post');
        $price4 = Sanitizer::filter('price4', 'post');
        $price5 = Sanitizer::filter('price5', 'post');
        $canvas_id = Sanitizer::filter('canvas_id', 'post');

        $canvasing->add_CanvasDetails($qty,$uom,$product_desc,$price1,$price2,$price3,$price4,$price5,$canvas_id);

        $response = array("code"=>1,"message"=>"Canvas details Added");
        break;

    case "tableAttach";
        $preq_id = Sanitizer::filter('preq_id', 'get');
        $canvasing = $canvasing->getAttachments($preq_id);
        foreach($canvasing as $k=>$v) {
            $newFolder = "CANVAS".date('Y')."(".$preq_id.")";
            $canvasing[$k]['action'] = "<button class='btn btn-primary btn-sm' onclick='openAttachment(\"".$v['attachment']."\",\"".$newFolder."\")'><i class='fas fa-sm fa-eye'></i> Open</button> 
            <button class='btn btn-danger btn-sm' onclick='deleteAttachment(".$v['id'].",\"".$v['attachment']."\",".$v['preq_id'].")'><i class='fas fa-sm fa-trash-alt'></i> Delete</button>";
        }
        $response = array("data" => $canvasing);
        break;

    case "deleteAttach";
        $id = Sanitizer::filter('id', 'post');
        $attachment = Sanitizer::filter('attachment', 'post');
        $preq_id = Sanitizer::filter('preq_id', 'post');
        $canvasing->deleteAttche($id,$attachment,$preq_id);
        $response = array("code"=>1, "message"=>"Data Deleted");
        break;

    case "UpdateCanvas";
        $id = Sanitizer::filter('id', 'post');
        $canvas_status = Sanitizer::filter('canvas_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $canvasing->Update_Canvas($id,$canvas_status,$remarks,$approver);

        $response = array("code"=>1,"message"=>"Canvas Status Updated");
        break;

    case "UpdateCanvasIT";
        $id = Sanitizer::filter('id', 'post');
        $canvas_status = Sanitizer::filter('canvas_status', 'post');
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $canvasing->Update_CanvasIT($id,$canvas_status,$remarks,$approver);

        $response = array("code"=>1,"message"=>"Canvas Status Updated");
        break;

    case "UpdateCanvasLocal";
        $id = Sanitizer::filter('id', 'post');
        $canvas_status = "Submitted";
        $remarks = Sanitizer::filter('remarks', 'post');
        $approver = Sanitizer::filter('approver', 'post');
        $canvasing->Update_CanvasLocal($id,$canvas_status,$remarks,$approver);

        $response = array("code"=>1,"message"=>"Canvas Status Updated");
        break;

    case "updateStatus";
        $pr_id = Sanitizer::filter('id', 'post');
        $canvas_status = "Submitted";
        $depts = $canvasing->update_Status($pr_id,$canvas_status);
        $response = array("code"=>1,"message"=>"Canvas Status Updated","department"=>$depts);
        break;

    case "updateStatusimport";
        $pr_id = Sanitizer::filter('id', 'post');
        $canvas_status = "Submitted";
        $canvasing->update_Statusimport($pr_id,$canvas_status);
        $response = array("code"=>1,"message"=>"Canvas Status Updated");
        break;

    case "deleteCanvasDetails";
        $id = Sanitizer::filter('id', 'post');
        $canvasing->delete_CanvasDetails($id);

        $response = array("code"=>1, "message"=>"Canvas details Deleted");
        break;

    case "upload";

        $preq_id = Sanitizer::filter('preq_id', 'post');
        $canvass_id = Sanitizer::filter('canvass_id', 'post');
        $newFolder = "CANVAS".date('Y')."(".$preq_id.")";
        mkdir("../attachments/".$newFolder);
        $target_dir = "../attachments/".$newFolder."/";
        $file = $_FILES['pr_attachment']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $attachfile = $filename.".".$ext;
        $temp_name = $_FILES['pr_attachment']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        $attachment_name = $filename.".".$ext;
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            $response = array('code'=>0,'message'=>'Upload failed. File already exists.');
        } else {
            move_uploaded_file($temp_name,$path_filename_ext);
            $canvasing->saveCanvas_Attachment($preq_id,$attachment_name);
            header('location: ../canvas.php?id='.$canvass_id);
            // $response = array('code'=>1,'message'=>$cashcheck_id);
        }
        
        
        break;

}


echo json_encode($response);



 ?>