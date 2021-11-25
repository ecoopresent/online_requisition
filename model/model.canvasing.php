<?php
date_default_timezone_set("Asia/Manila");
class Canvasing extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }


    public function getCanvasDetails($canvas_id)
    {
        $query = "SELECT id, canvas_id, qty, uom, product_desc, price1, price2, price3, price4, price5 FROM canvas_details WHERE canvas_id = '$canvas_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getCanvasInfo($pr_id)
    {
        $query = "SELECT id, pr_id, supplier1, supplier2, supplier3, supplier4, supplier5, remarks, approved_by, canvas_date,date_approved,operation_incharge, oi_date_approved FROM canvas WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $canvas_id = $row[0];
        $pr_id = $row[1];
        $supplier1 = $row[2];
        $supplier2 = $row[3];
        $supplier3 = $row[4];
        $supplier4 = $row[5];
        $supplier5 = $row[6];
        $remarks = $row[7];
        $approved_by = $row[8];
        $canvas_date = $row[9];
        $date_approved = $row[10];
        $operation_incharge = $row[11];
        $oi_date_approved = $row[12];

        return array("canvas_id"=>$canvas_id,"supplier1"=>$supplier1,"supplier2"=>$supplier2,"supplier3"=>$supplier3,"supplier4"=>$supplier4,"supplier5"=>$supplier5,"remarks"=>$remarks,"canvas_date"=>$canvas_date,"approved_by"=>$approved_by,"pr_id"=>$pr_id,"date_approved"=>$date_approved,"operation_incharge"=>$operation_incharge,"oi_date_approved"=>$oi_date_approved);
    }

    public function getPrtype($pr_id)
    {
        $query = "SELECT pr_type FROM pr WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getAttachments($preq_id)
    {
        $query = "SELECT id, preq_id, attachment FROM canvas_attachments WHERE preq_id = '$preq_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getCanvasInfos($canvas_id)
    {
        $query = "SELECT id, pr_id, supplier1, supplier2, supplier3, supplier4, supplier5, remarks, approved_by, canvas_date,date_approved,operation_incharge, oi_date_approved FROM canvas WHERE id = '$canvas_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $canvas_id = $row[0];
        $pr_id = $row[1];
        $supplier1 = $row[2];
        $supplier2 = $row[3];
        $supplier3 = $row[4];
        $supplier4 = $row[5];
        $supplier5 = $row[6];
        $remarks = $row[7];
        $approved_by = $row[8];
        $canvas_date = $row[9];
        $date_approved = $row[10];
        $operation_incharge = $row[11];
        $oi_date_approved = $row[12];

        return array("canvas_id"=>$canvas_id,"supplier1"=>$supplier1,"supplier2"=>$supplier2,"supplier3"=>$supplier3,"supplier4"=>$supplier4,"supplier5"=>$supplier5,"remarks"=>$remarks,"canvas_date"=>$canvas_date,"approved_by"=>$approved_by,"pr_id"=>$pr_id,"date_approved"=>$date_approved,"operation_incharge"=>$operation_incharge,"oi_date_approved"=>$oi_date_approved);
    }

    public function deleteAttche($id,$attachment,$preq_id)
    {   
        $newFolder = "CANVAS".date('Y')."(".$preq_id.")";
        unlink("../attachments/".$newFolder."/".$attachment);

        $query = "DELETE FROM canvas_attachments WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_CanvasDetails($c_details_id,$qty,$uom,$product_desc,$price1,$price2,$price3,$price4,$price5)
    {   
        if($price1 <=0){
            $price1 = "0";
        }if($price2 <=0){
            $price2 = "0";
        }if($price3 <=0){
            $price3 = "0";
        }if($price4 <=0){
            $price4 = "0";
        }if($price5 <=0){
            $price5 = "0";
        }
        $query = "UPDATE canvas_details SET qty = '$qty', uom = '$uom', product_desc = '$product_desc', price1 = '$price1', price2 = '$price2', price3 = '$price3', price4 = '$price4', price5 = '$price5' WHERE id = '$c_details_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function add_CanvasDetails($qty,$uom,$product_desc,$price1,$price2,$price3,$price4,$price5,$canvas_id)
    {   
        if($price1 <=0){
            $price1 = "0";
        }if($price2 <=0){
            $price2 = "0";
        }if($price3 <=0){
            $price3 = "0";
        }if($price4 <=0){
            $price4 = "0";
        }if($price5 <=0){
            $price5 = "0";
        }
        $query = "INSERT INTO canvas_details SET canvas_id = '$canvas_id', qty = '$qty', uom = '$uom', product_desc = '$product_desc', price1 = '$price1', price2 = '$price2', price3 = '$price3', price4 = '$price4', price5 = '$price5'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function Update_Canvas($id,$canvas_status,$remarks,$approver)
    {  

        $date_today = date('Y-m-d');
        $query = "UPDATE pr SET pr_status = '$canvas_status' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);
        if($canvas_status=="PreFinished"){

            $query = "UPDATE canvas SET approved_by = '-', remarks = '$remarks', operation_incharge = '$approver', oi_date_approved = '$date_today' WHERE pr_id = '$id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->execute($stmt);

        }else{

            $query = "UPDATE canvas SET approved_by = '$approver',remarks = '$remarks',date_approved = '$date_today' WHERE pr_id = '$id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->execute($stmt);    
        }
        
    }

    public function Update_CanvasIT($id,$canvas_status,$remarks,$approver)
    {  

        $date_today = date('Y-m-d');
        $query = "UPDATE pr SET pr_status = '$canvas_status' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $query = "UPDATE canvas SET operation_incharge = '$approver',remarks = '$remarks',oi_date_approved = '$date_today' WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function Update_CanvasLocal($id,$canvas_status,$remarks,$approver)
    {  

        $date_today = date('Y-m-d');
        $query = "UPDATE pr SET date_approve = '$date_today' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $query = "UPDATE canvas SET canvas_status = '$canvas_status', approved_by = '$approver',remarks = '$remarks',date_approved = '$date_today' WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function delete_CanvasDetails($id)
    {
        $query = "DELETE FROM canvas_details WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_Status($pr_id,$canvas_status)
    {
        $query = "UPDATE canvas SET canvas_status = '$canvas_status' WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $query = "SELECT department FROM pr WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $department = $row[0];

        return $department;
    }

    public function update_Statusimport($pr_id,$canvas_status)
    {
        $approver = "Susan T. Panugayan";
        $date_today = date('Y-m-d');

        $pr_status = "Finished";
        $query = "UPDATE pr SET pr_status = '$pr_status', date_approve = '$date_today' WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $query = "UPDATE canvas SET canvas_status = '$canvas_status', approved_by = '$approver', date_approved = '$date_today' WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);

    }

    public function saveCanvas_Attachment($preq_id,$attachment_name)
    {
        $query = "INSERT INTO canvas_attachments SET preq_id = '$preq_id', attachment = '$attachment_name' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }



}