<?php
date_default_timezone_set("Asia/Manila");
class Pr_approval extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getPRlist($status,$user_dept)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status FROM pr WHERE pr_status = '$status' AND department = '$user_dept'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function UpdateStatus($id,$pr_status,$approver,$remarks)
    {   
        

        if($pr_status=="Approved"){

            $date_today = date('Y-m-d');
            $query = "UPDATE pr SET pr_status = '$pr_status', f_approved_by = '$approver', remarks = '$remarks', f_date_approved = '$date_today' WHERE id = '$id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->execute($stmt);

        }else{

            $date_today = date('Y-m-d');
            if($pr_status=="Disapproved" || $pr_status=="Submitted"){
                $full_name = "";
                $date_today = "";
            }

            $query = "UPDATE pr SET pr_status = '$pr_status', approved_by = '$approver', remarks = '$remarks', date_approve = '$date_today' WHERE id = '$id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->execute($stmt);
        }
        
    }
 
    public function addPRequest($department,$date_prepared,$date_needed,$pr_no,$purpose)
    {

        $query = "INSERT INTO pr(department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status) VALUES('$department','$date_prepared','$date_needed','$pr_no','$purpose','','','Pending')";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        return $lastid = $stmt->insert_id;

    }

    public function addPRdetails($item_code,$stock,$rqmt,$uom,$item_description,$pr_id)
    {
        $query = "INSERT INTO pr_details(pr_id, item_code, stock, rqmt, uom, item_description) VALUES('$pr_id','$item_code','$stock','$rqmt','$uom','$item_description')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function updatePRdetails($item_code,$stock,$rqmt,$uom,$item_description,$id)
    {
        $query = "UPDATE pr_details SET item_code = '$item_code', stock = '$stock', rqmt = '$rqmt', uom = '$uom', item_description = '$item_description' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deletePRdetails($id)
    {
        $query = "DELETE FROM pr_details WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);

    }

    public function submitPR($pr_id){
        $pr_status = "Sumitted";
        $query = "UPDATE pr SET pr_status = '$pr_status' WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

}