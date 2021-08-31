<?php
date_default_timezone_set("Asia/Manila");
class ApprovedCash extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getCashlist($cash_status)
    {
        $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting, cash_status FROM cashcheck WHERE cash_status = '$cash_status'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function UpdateStatus($id,$cash_status,$full_name)
    {
        if($cash_status=="Disapproved2" || $cash_status=="Approved"){
            $full_name = "";
        }
        $query = "UPDATE cashcheck SET cash_status = '$cash_status', accounting = '$full_name' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function getAttachments($cashcheck_id)
    {
        $query = "SELECT id, cashcheck_id, attachment FROM rca_attachments WHERE cashcheck_id = '$cashcheck_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }
 

    public function getCashadvance($id){

        $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting,cash_status FROM cashcheck WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $id = $row[0];
        $department = $row[2];
        $payee = $row[3];
        $date_prepared = $row[4];
        $date_needed = $row[5];
        $particulars = $row[6];
        $amount = $row[7];
        $purpose = $row[8];
        $remarks = $row[9];
        $charge_to = $row[10];
        $budget = $row[11];
        $liquidated_on = $row[12];
        $prepared_by = $row[13];
        $department_head = $row[14];
        $president = $row[15];
        $accounting = $row[16];
        $cash_status = $row[17];


        return array("id"=>$id,"department"=>$department,"payee"=>$payee,"date_prepared"=>$date_prepared,"date_needed"=>$date_needed,"particulars"=>$particulars,"amount"=>$amount,"purpose"=>$purpose,"remarks"=>$remarks,"charge_to"=>$charge_to,"budget"=>$budget,"liquidated_on"=>$liquidated_on,"prepared_by"=>$prepared_by,"cash_status"=>$cash_status,"president"=>$president,"accounting"=>$accounting,"department_head"=>$department_head);

        

    }

    public function Update_Cashadvance($type,$cash_id)
    {   
        $cash_status = "";
        $president = "";
        if($type=="Approve"){
            $cash_status = "Finished";
            $president = "Homer C. Lim";
        }else{
            $cash_status = "Rejected";
        }
        $query = "UPDATE cashcheck SET president = '$president' ,cash_status = '$cash_status' WHERE id = '$cash_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);


    }

    public function declineRCA($id)
    {
        $query = "UPDATE cashcheck SET department_head = '.', president = '.', head_approver = '.', cash_status = 'Disapproved' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

}