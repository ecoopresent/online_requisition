<?php
date_default_timezone_set("Asia/Manila");
class Pr extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getPRDetails($pr_id)
    {
        $query = "SELECT id, pr_id, item_code, stock, rqmt, uom, item_description FROM pr_details WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getPRInfo($id)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status, remarks, pr_type FROM pr WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchRow($stmt);
    }

    public function countPurchase($user_dept,$pr_status)
    {
        $query = "SELECT COUNT(id) FROM pr WHERE pr_status = '$pr_status' AND department = '$user_dept'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getPRlist($full_name)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status, pr_type FROM pr WHERE pr_status = 'Submitted' AND requested_by = '$full_name' OR pr_status = 'Pending' AND requested_by = '$full_name'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getPRlistdone($status,$full_name)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status, pr_type,remarks FROM pr WHERE pr_status = '$status' AND requested_by = '$full_name'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }
 
    public function addPRequest($department,$date_prepared,$date_needed,$pr_no,$purpose,$full_name,$pr_type)
    {

        $query = "INSERT INTO pr(department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status, pr_type) VALUES('$department','$date_prepared','$date_needed','$pr_no','$purpose','$full_name','','Pending','$pr_type')";
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

    public function update_PR($id,$department,$date_prepared,$date_needed,$pr_no,$purpose,$pr_pr_type)
    {
        $query = "UPDATE pr SET department = '$department', date_prepared = '$date_prepared', date_needed = '$date_needed', pr_no = '$pr_no', purpose = '$purpose', pr_type = '$pr_pr_type' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deletePRdetails($id)
    {
        $query = "DELETE FROM pr_details WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);

    }

    public function delete_PR($id,$user_dept)
    {

        $qry = "SELECT pr_no FROM pr WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $pr_no = $row[0];

        $date_today = date('Y-m-d');
        $audit_action = $user_dept." Department deleted PR with pr number - ".$pr_no;
        $audit_user = $user_dept.' Department';
        $qryy = "INSERT INTO audit_trail SET audit_action = '$audit_action', audit_date = '$date_today', audit_user = '$audit_user'";
        $stmt = $this->prepareQuery($this->conn, $qryy);
        $this->execute($stmt);

        $query = "DELETE FROM pr WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function submitPR($pr_id){
        $pr_status = "Submitted";
        $query = "UPDATE pr SET pr_status = '$pr_status' WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function submitPRTrade($pr_id){
        $pr_status = "Approved";
        $approver = "Susan T. Panugayan";
        $query = "UPDATE pr SET pr_status = '$pr_status', approved_by = '$approver' WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function getPRno()
    {
        $query = "SELECT id FROM pr ORDER BY id DESC LIMIT 1";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $id = $row[0];
        if($id==""){
            $id = 0;
        }
        $id++;
        $pr_no = 'PRCHS'.date('Y').'-'.$id;

        return array("pr_no"=>$pr_no);
    }

    public function count_Pr($pr_id)
    {
        $query = "SELECT count(id) FROM pr_details WHERE pr_id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $countPr = $row[0];

        return array("countPr"=>$countPr);
    }

    public function checkStatus($id){
        
        $query = "SELECT approved_by FROM pr WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function checkCStatus($id){
        
        $query = "SELECT approved_by FROM canvas WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

}