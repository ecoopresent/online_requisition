<?php
date_default_timezone_set("Asia/Manila");
class Users extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }



    public function getUsers()
    {
        $query = "SELECT id, full_name, username, password, user_status, user_type, user_dept FROM user_account";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getAllDepartment()
    {
        $query = "SELECT id, department FROM department";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function add_User($full_name,$username,$password,$user_type,$department)
    {   
        $user_status = "active";
        $query = "INSERT INTO user_account(full_name, username, password, user_status, user_type, user_dept) VALUES('$full_name','$username','$password','$user_status','$user_type','$department')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_User($full_name,$username,$password,$user_type,$id,$department)
    {
        $user_status = "active";
        $query = "UPDATE user_account SET full_name = '$full_name', username = '$username', password = '$password', user_type = '$user_type', user_dept = '$department' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM user_account WHERE id= '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function getEmailAcct(){

        $query = "SELECT payee_email FROM payee";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

  

}