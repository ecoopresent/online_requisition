<?php
date_default_timezone_set("Asia/Manila");
class AccountingLiquidate extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getPettycashlist($status,$user_dept)
    {
        $qry = "SELECT id FROM payee WHERE payee_dept = '$user_dept'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $payee_id = $row[0];
        if($payee_id==1){

            $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE pettycash_status = '$status'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->fetchAssoc($stmt);
        }else{
            
            $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE pettycash_status = '$status' AND payee_id = '$payee_id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->fetchAssoc($stmt);
        }
        
    }

    public function getPettyInfo($voucher_id)
    {
        $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE id = '$voucher_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $department = $row[1];
        $voucher_date = $row[2];
        $voucher_no = $row[3];
        $particulars = $row[4];
        $cash_advance = $row[5];
        $actual_amount = $row[6];
        $charge_to = $row[7];
        $liquidated_on = $row[8];
        $requested_by = $row[9];
        $department_head = $row[10];
        $authorized_signatory = $row[11];

        return array("department"=>$department,"voucher_date"=>$voucher_date,"voucher_no"=>$voucher_no,"particulars"=>$particulars,"cash_advance"=>$cash_advance,"actual_amount"=>$actual_amount,"charge_to"=>$charge_to,"liquidated_on"=>$liquidated_on,"requested_by"=>$requested_by,"department_head"=>$department_head,"authorized_signatory"=>$authorized_signatory);
    }

    public function UpdateStatus($id,$pettycash_status,$full_name)
    {
        if($pettycash_status=="Approved" || $pettycash_status=="Disapproved1"){
            $full_name = "";
        }
        $query = "UPDATE pettycash SET authorized = '$full_name', pettycash_status = '$pettycash_status' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $query = "UPDATE liquidation SET approved_by = '$full_name' WHERE pettycash_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function check_Petty($id)
    {
        $query = "SELECT count(id) FROM liquidation WHERE pettycash_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $countLiquidation = $row[0];

        return array("countLiquidation"=>$countLiquidation);
    }

}