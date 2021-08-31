<?php
date_default_timezone_set("Asia/Manila");
class Department extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }



    public function getDepartment()
    {
        $query = "SELECT id, department,department_head,department_email FROM department";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function add_Department($department,$department_head,$department_email)
    {   
        $query = "INSERT INTO department (department,department_head,department_email) VALUES ('$department','$department_head','$department_email')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_Department($id,$department,$department_head,$department_email)
    {
        $query = "UPDATE department SET department = '$department',department_head= '$department_head',department_email='$department_email' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deleteDepartment($id)
    {
        $query = "DELETE FROM department WHERE id= '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

  

}