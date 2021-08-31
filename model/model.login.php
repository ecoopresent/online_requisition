<?php
date_default_timezone_set("Asia/Manila");
class Login extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function loginUser($username, $password)
    {

        $query = "SELECT a.id, a.full_name, a.username, a.password, a.user_status, a.user_type, a.user_dept,b.department_head,b.department_email FROM user_account a
                  LEFT JOIN department b ON a.user_dept = b.department 
                  WHERE a.username = '$username' AND a.password = '$password'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        
        $user_id = $row[0];
        $full_name = $row[1];
        $user_type = $row[5];
        $user_dept = $row[6];
        $department_head = $row[7];
        $department_email = $row[8];
        $status = "";
        if($user_id != null || $user_id !=""){
            $status = "FOUND";
        }else{
            $status = "NOTFOUND";
            $full_name = null;
        }
        return array("status"=>$status,"full_name"=>$full_name,"user_type"=>$user_type,"user_dept"=>$user_dept,"department_head"=>$department_head,"department_email"=>$department_email);


    }

}