<?php
date_default_timezone_set("Asia/Manila");
class Reports extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getCashlist($date_prepared,$date_preparedto)
    {   

        $WHERE = "WHERE cash_status = 'Finished' OR cash_status = 'checked'";
        if($date_prepared != ""){
            $WHERE = "WHERE cash_status = 'Finished' AND date_prepared BETWEEN '$date_prepared' AND '$date_preparedto' OR cash_status = 'checked' AND date_prepared BETWEEN '$date_prepared' AND '$date_preparedto'";
        }
        $query = "SELECT id, pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by, department_head, president, accounting, cash_status FROM cashcheck ".$WHERE;
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getPettylist($date_prepared,$date_preparedto,$department)
    {   

        $WHERE = "WHERE pettycash_status = 'Finished' OR pettycash_status = 'Approved1'";
        if($date_prepared != ""){

            $WHERE = "WHERE pettycash_status = 'Finished' AND voucher_date BETWEEN '$date_prepared' AND '$date_preparedto' OR pettycash_status = 'Approved1' AND voucher_date BETWEEN '$date_prepared' AND '$date_preparedto'";
            if($department != null OR $department != ""){
                $WHERE = "WHERE pettycash_status = 'Finished' AND department = '$department' AND voucher_date BETWEEN '$date_prepared' AND '$date_preparedto' OR pettycash_status = 'Approved1' AND department = '$department' AND voucher_date BETWEEN '$date_prepared' AND '$date_preparedto'";
            }
                
            
            
        }

        $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status, liquidation, remarks, payee_id FROM pettycash ".$WHERE;
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }


}