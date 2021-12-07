<?php
date_default_timezone_set("Asia/Manila");
class Payee extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }



    public function getPayee()
    {
        $query = "SELECT id, payee_name, payee_email, payee_dept FROM payee";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getAudit()
    {
        $query = "SELECT id, audit_action, audit_date, audit_user FROM audit_trail";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getPCadmin()
    {
        $query = "SELECT id, voucher_date, voucher_no, particulars, pettycash_status FROM pettycash ORDER BY voucher_date";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getRCAadmin()
    {
        $query = "SELECT id, date_prepared, particulars, cash_status FROM cashcheck ORDER BY date_prepared";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function add_Payee($payee_name,$payee_email,$payee_dept)
    {   
        $query = "INSERT INTO payee (payee_name, payee_email, payee_dept) VALUES ('$payee_name','$payee_email','$payee_dept')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function updatePayee($id,$payee_name,$payee_email,$payee_dept)
    {
        $query = "UPDATE payee SET payee_name = '$payee_name',payee_email= '$payee_email',payee_dept='$payee_dept' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deletePayee($id)
    {
        $query = "DELETE FROM payee WHERE id= '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deletePCadmin($id)
    {   

        $qry = "SELECT voucher_no FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $voucher_no = $row[0];

        $query = "DELETE FROM pettycash WHERE id= '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $date_today = date('Y-m-d');
        $audit_action = "A Deleted pettycash with voucher number - ".$voucher_no;
        $audit_user = $user_dept.' Department';
        $qryy = "INSERT INTO audit_trail SET audit_action = '$audit_action', audit_date = '$date_today', audit_user = '$audit_user'";
        $stmt = $this->prepareQuery($this->conn, $qryy);
        return $this->execute($stmt);

    }

    public function deleteRCAadmin($id)
    {
        $qry = "SELECT date_prepared FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $date_prepared = $row[0];

        $yearprepared = date('Y', strtotime($date_prepared));
        $rca_no = 'RCA'.$yearprepared.'-'.$id;

        $query = "DELETE FROM cashcheck WHERE id= '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        $date_today = date('Y-m-d');
        $audit_action = "A Deleted RCA with rca number - ".$rca_no;
        $audit_user = $user_dept.' Department';
        $qryy = "INSERT INTO audit_trail SET audit_action = '$audit_action', audit_date = '$date_today', audit_user = '$audit_user'";
        $stmt = $this->prepareQuery($this->conn, $qryy);
        return $this->execute($stmt);
    }

    public function getAllDepartment()
    {
        $query = "SELECT id, department FROM department";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

  

}