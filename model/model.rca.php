<?php
date_default_timezone_set("Asia/Manila");
class Rca extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getRCAList($user_dept)
    {
        $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting, cash_status FROM cashcheck WHERE department = '$user_dept' AND pr_id = 0 AND cash_status = ''";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getRCAListdone($user_dept,$status)
    {
        if($status=="Finished"){
            $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting, cash_status,approver_type FROM cashcheck WHERE department = '$user_dept' AND pr_id = 0 AND cash_status = '$status' OR department = '$user_dept' AND pr_id = 0 AND cash_status = 'Checked'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->fetchAssoc($stmt);
        }else{
            $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting, cash_status,approver_type FROM cashcheck WHERE department = '$user_dept' AND pr_id = 0 AND cash_status = '$status'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->fetchAssoc($stmt);
        }

    }

    public function getAttachments($cashcheck_id)
    {
        $query = "SELECT id, cashcheck_id, attachment FROM rca_attachments WHERE cashcheck_id = '$cashcheck_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function deleteAttche($id,$attachment,$cashcheck_id)
    {   
        $newFolder = "RCA".date('Y')."-".$cashcheck_id;
        unlink("../attachments/".$newFolder."/".$attachment);

        $query = "DELETE FROM rca_attachments WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function addRCA($department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$prepared_by)
    {
        $query = "INSERT INTO cashcheck SET department = '$department', payee = '$payee', date_prepared = '$date_prepared', date_needed = '$date_needed', particulars = '$particulars', amount = '$amount', purpose = '$purpose', remarks = '$remarks', charge_to = '$charge_to', budget = '$budget', liquidated_on = '$liquidated_on', prepared_by = '$prepared_by'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);

    }

    public function updateRCA($cash_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$prepared_by)
    {
        $query = "UPDATE cashcheck SET department = '$department', payee = '$payee', date_prepared = '$date_prepared', date_needed = '$date_needed', particulars = '$particulars', amount = '$amount', purpose = '$purpose', remarks = '$remarks', charge_to = '$charge_to', budget = '$budget', liquidated_on = '$liquidated_on', prepared_by = '$prepared_by' WHERE id = '$cash_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deleteRCA($id,$user_dept)
    {
        
        $qry = "SELECT amount FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $amount = $row[0];

        $date_today = date('Y-m-d');
        $audit_action = $user_dept." Department deleted RCA with amount of P".number_format($amount,2);
        $audit_user = $user_dept.' Department';
        $qryy = "INSERT INTO audit_trail SET audit_action = '$audit_action', audit_date = '$date_today', audit_user = '$audit_user'";
        $stmt = $this->prepareQuery($this->conn, $qryy);
        $this->execute($stmt);

        $query = "DELETE FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function countPurchase($user_dept,$cash_status)
    {

        if($cash_status=="Finished"){
            $query = "SELECT COUNT(id) FROM cashcheck WHERE department = '$user_dept' AND pr_id = 0 AND cash_status = '$cash_status' OR department = '$user_dept' AND pr_id = 0 AND cash_status = 'Checked'";
            $stmt = $this->prepareQuery($this->conn, $query);
            $row = $this->fetchRow($stmt);
            return $row[0];
        }else{
            $query = "SELECT COUNT(id) FROM cashcheck WHERE department = '$user_dept' AND pr_id = 0 AND cash_status = '$cash_status'";
            $stmt = $this->prepareQuery($this->conn, $query);
            $row = $this->fetchRow($stmt);
            return $row[0];
        }
    }

    public function submitRCA($id,$approver)
    {   
        $cash_status = "Submitted";
        $query = "UPDATE cashcheck SET cash_status = '$cash_status', approver_type = '$approver', department_head = '', date_preapproved = '0000-00-00' WHERE id = '$id' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function saveRCA_Attachment($cashcheck_id,$attachment_name)
    {
        $query = "INSERT INTO rca_attachments SET cashcheck_id = '$cashcheck_id', attachment = '$attachment_name' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    

}