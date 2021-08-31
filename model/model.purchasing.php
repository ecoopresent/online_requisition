<?php
date_default_timezone_set("Asia/Manila");
class Purchasing extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getPRlist()
    {
        $query = "SELECT a.id, a.department, a.date_prepared, a.date_needed, a.pr_no, a.purpose, a.requested_by, a.approved_by, a.pr_status,a.pr_type,b.canvas_status FROM pr a 
                 LEFT JOIN canvas b ON a.id = b.pr_id
                 WHERE a.pr_status = 'Approved' || a.pr_status = 'Canvassed' ORDER BY a.pr_status ASC ";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function countPRapproved($pr_status)
    {
        $query = "SELECT COUNT(id) FROM pr WHERE pr_status = '$pr_status'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getPRDetails($pr_id)
    {
        $query = "SELECT id, pr_id, item_code, stock, rqmt, uom, item_description FROM pr_details WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getPRInfo($pr_id)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status, date_approve FROM pr WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $department = $row[1];
        $date_prepared = $row[2];
        $date_needed = $row[3];
        $pr_no = $row[4];
        $purpose = $row[5];
        $requested_by = $row[6];
        $approved_by = $row[7];
        $date_approve = $row[9];

        return array("department"=>$department,"date_prepared"=>$date_prepared,"date_needed"=>$date_needed,"pr_no"=>$pr_no,"purpose"=>$purpose,"requested_by"=>$requested_by,"approved_by"=>$approved_by, "date_approve"=>$date_approve);
    }

    public function check_Canvas($id){
        $query = "SELECT id, pr_id, supplier1, supplier2, supplier3, supplier4, supplier5, remarks, approved_by, canvas_date FROM canvas WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $canvas_id = $row[0];
        $supplier1 = $row[2];
        $supplier2 = $row[3];
        $supplier3 = $row[4];
        $supplier4 = $row[5];
        $supplier5 = $row[6];
        $remarks = $row[7];
        $canvas_date = $row[9];

        if($canvas_id==""){
            $date_today = date('Y-m-d');
            return array("statuss"=>"not_yet","canvas_id"=>0,"supplier1"=>$supplier1,"supplier2"=>$supplier2,"supplier3"=>$supplier3,"supplier4"=>$supplier4,"supplier5"=>$supplier5,"canvas_date"=>$date_today,"remarks"=>$remarks);
        }else{
            $query = "SELECT id FROM canvas_details WHERE canvas_id = '$canvas_id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            $row1 = $this->fetchRow($stmt);
            $c_id = $row1[0];

            if($c_id==""){
                return array("statuss"=>"not_yet","canvas_id"=>$canvas_id,"supplier1"=>$supplier1,"supplier2"=>$supplier2,"supplier3"=>$supplier3,"supplier4"=>$supplier4,"supplier5"=>$supplier5,"canvas_date"=>$canvas_date,"remarks"=>$remarks);
            }else{
                return array("statuss"=>"submitted","canvas_id"=>$canvas_id,"supplier1"=>$supplier1,"supplier2"=>$supplier2,"supplier3"=>$supplier3,"supplier4"=>$supplier4,"supplier5"=>$supplier5,"canvas_date"=>$canvas_date,"remarks"=>$remarks);
            }
        }

        
    }
 

    public function add_canvas($pr_id,$canvas_date,$supplier1,$supplier2,$supplier3,$supplier4,$supplier5,$remarks)
    {   

        $pr_status = "Canvassed";
        $query = "UPDATE pr SET pr_status = '$pr_status' WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt); 

        $query = "INSERT INTO canvas(pr_id, supplier1, supplier2, supplier3, supplier4, supplier5, remarks ,canvas_date) VALUES('$pr_id','$supplier1','$supplier2','$supplier3','$supplier4','$supplier5','$remarks','$canvas_date')";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $canvas_id = $stmt->insert_id;

        $qry = "SELECT id, pr_id, item_code, stock, rqmt, uom, item_description FROM pr_details WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $pr_details = $this->fetchAssoc($stmt);

        foreach($pr_details as $k=>$v) {

            $price = 0;
            $qty = $v['rqmt'];
            $uom = $v['uom'];
            $product_desc = $v['item_description'];
            $query = "INSERT INTO canvas_details(canvas_id, qty, uom, product_desc, price1, price2, price3, price4, price5) VALUES('$canvas_id','$qty','$uom','$product_desc','$price','$price','$price','$price','$price')";
            $stmt = $this->prepareQuery($this->conn, $query);
            $this->execute($stmt);

        }

        return true;


    }

    public function update_canvas($canvas_id,$canvas_date,$supplier1,$supplier2,$supplier3,$supplier4,$supplier5,$remarks)
    {
        $query = "UPDATE canvas SET supplier1 = '$supplier1', supplier2 = '$supplier2', supplier3 = '$supplier3', supplier4 = '$supplier4', supplier5 = '$supplier5', remarks = '$remarks',canvas_date = '$canvas_date' WHERE id = '$canvas_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt); 
    }



}