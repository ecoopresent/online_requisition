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

    public function getAllDepartment()
    {
        $query = "SELECT id, department FROM department";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

  

}