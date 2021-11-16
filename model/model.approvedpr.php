<?php
date_default_timezone_set("Asia/Manila");
class Approvedpr extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function getPRlist($canvas_status)
    {
        $WHERE = "";
        if($canvas_status=="Pending"){
            $WHERE = "a.pr_status = 'Finished' AND b.cash_status = '$canvas_status' OR a.pr_status = 'Finished' AND b.cash_status IS NULL";
        }else if($canvas_status=="Rejected"){
            $WHERE = "a.pr_status = 'Rejected'";
        }
        else if($canvas_status=="PreFinished"){
            $WHERE = "a.pr_status = 'PreFinished'";
        }else{
            $WHERE = "a.pr_status = 'Finished' AND b.cash_status = '$canvas_status'";
        }
        $query = "SELECT b.cash_status,a.id, a.department, a.date_prepared, a.date_needed, a.pr_no, a.purpose, a.requested_by, a.approved_by, a.pr_status,c.date_approved,a.pr_type,b.id AS idRCA FROM pr a
                  LEFT JOIN cashcheck b ON a.id = b.pr_id 
                  LEFT JOIN canvas c ON a.id = c.pr_id
                  WHERE ".$WHERE;
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function countCanvasapproved()
    {
        $query = "SELECT COUNT(a.id) FROM pr a
                  LEFT JOIN cashcheck b ON a.id = b.pr_id
                  WHERE a.pr_status = 'Finished' AND b.cash_status = 'Pending' OR a.pr_status = 'Finished' AND b.cash_status IS NULL OR a.pr_status = 'Finished' AND b.cash_status = 'Submitted' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function countCanvasrejected(){
        $query = "SELECT COUNT(id) FROM pr WHERE pr_status = 'Rejected' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function countCanvasprefinished(){
        $query = "SELECT COUNT(id) FROM pr WHERE pr_status = 'PreFinished' ";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function countApprovedRCA(){
        
        $query = "SELECT COUNT(id) FROM cashcheck WHERE cash_status = 'Approved2'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getPRInfo($pr_id)
    {
        $query = "SELECT id, department, date_prepared, date_needed, pr_no, purpose, requested_by, approved_by, pr_status FROM pr WHERE id = '$pr_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $department = $row[1];
        $date_prepared = $row[2];
        $date_needed = $row[3];
        $pr_no = $row[4];
        $purpose = $row[5];
        $requested_by = $row[6];
        $approved_by = $row[7];

        return array("department"=>$department,"date_prepared"=>$date_prepared,"date_needed"=>$date_needed,"pr_no"=>$pr_no,"purpose"=>$purpose,"requested_by"=>$requested_by,"approved_by"=>$approved_by);
    }

    public function check_cashReq($id){

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
        $cash_status = $row[17];

        if($id==""){
            return array("id"=>"0","department"=>"","payee"=>"","date_prepared"=>"","date_needed"=>"","particulars"=>"","amount"=>"","purpose"=>"","remarks"=>"","charge_to"=>"","budget"=>"","liquidated_on"=>"","prepared_by"=>"","cash_status"=>"");
        }else{
            return array("id"=>$id,"department"=>$department,"payee"=>$payee,"date_prepared"=>$date_prepared,"date_needed"=>$date_needed,"particulars"=>$particulars,"amount"=>$amount,"purpose"=>$purpose,"remarks"=>$remarks,"charge_to"=>$charge_to,"budget"=>$budget,"liquidated_on"=>$liquidated_on,"prepared_by"=>$prepared_by,"cash_status"=>$cash_status);
        }
        

    }

    public function add_Cash($pr_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$full_name)
    {
        $query = "INSERT INTO cashcheck(pr_id, department, payee, date_prepared, date_needed, particulars, amount, purpose, remarks, charge_to, budget, liquidated_on, prepared_by,cash_status) VALUES('$pr_id','$department','$payee','$date_prepared','$date_needed','$particulars','$amount','$purpose','$remarks','$charge_to','$budget','$liquidated_on','$full_name','Pending')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_Cash($cash_id,$department,$payee,$date_prepared,$date_needed,$particulars,$amount,$purpose,$remarks,$charge_to,$budget,$liquidated_on,$full_name)
    {
        $query = "UPDATE cashcheck SET department = '$department',payee = '$payee', date_prepared = '$date_prepared', date_needed = '$date_needed', particulars = '$particulars', amount  = '$amount', purpose = '$purpose', remarks = '$remarks', charge_to = '$charge_to', budget = '$budget', liquidated_on = '$liquidated_on', prepared_by = '$full_name' WHERE id = '$cash_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }


    public function sendCash($id)
    {
        $cash_status = "Submitted";
        $query = "UPDATE cashcheck SET cash_status = ? WHERE id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "si", array($cash_status,$id));
        return $this->execute($stmt);
    }

    public function getRCAinfo($id)
    {
        
        $query = "SELECT prepared_by, cash_status FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchRow($stmt);
    }

    public function checkStatus($id){
        
        $query = "SELECT department_head FROM cashcheck WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getCashcheckinfo($id)
    {
        $query = "SELECT cash_status FROM cashcheck WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchRow($stmt);
    }
    
    public function checkStatusRCA($id){
        
        $query = "SELECT department_head FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function checkStatusRCAfinal($id){
        
        $query = "SELECT president FROM cashcheck WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function UpdateStatus($id,$cash_status,$remarks,$approver)
    {

        $date_today = date('Y-m-d');
        $query = "UPDATE cashcheck SET cash_status = '$cash_status', department_head = '$approver', remarks = '$remarks', date_preapproved = '$date_today' WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function UpdateFinalStatus($id,$cash_status,$remarks,$approver)
    {
        if($cash_status=="Disapproved"){
            $approver = "";
        }
        $date_today = date('Y-m-d');
        $query = "UPDATE cashcheck SET cash_status = '$cash_status', president = '$approver', remarks = '$remarks', date_approved = '$date_today' WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function checkStatusbyPres($id){
        
        $query = "SELECT president FROM cashcheck WHERE pr_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function respondTo($id,$remarks,$approver,$cash_status)
    {

        $date_today = date('Y-m-d');
        $query = "UPDATE cashcheck SET cash_status = '$cash_status', department_head = '$approver', remarks = '$remarks', date_preapproved = '$date_today' WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function finalrespondTo($id,$remarks,$approver,$cash_status)
    {   
        if($approver=="Mary Ann Miranda"){

            if($cash_status=="PreApproveds"){

                $date_today = date('Y-m-d');
                $query = "UPDATE cashcheck SET cash_status = 'PreApproved', remarks = '$remarks', head_approver='$approver', date_headapproved = '$date_today'  WHERE id = '$id'";
                $stmt = $this->prepareQuery($this->conn, $query);
                return $this->execute($stmt);

            }else{

                $date_today = date('Y-m-d');
                $query = "UPDATE cashcheck SET cash_status = '$cash_status', president = '-', remarks = '$remarks', head_approver='$approver', date_headapproved = '$date_today'  WHERE id = '$id'";
                $stmt = $this->prepareQuery($this->conn, $query);
                return $this->execute($stmt);

            }

            

        }else{

            $date_today = date('Y-m-d');
            $query = "UPDATE cashcheck SET cash_status = '$cash_status', president = '$approver', remarks = '$remarks', date_approved = '$date_today' WHERE id = '$id'";
            $stmt = $this->prepareQuery($this->conn, $query);
            return $this->execute($stmt);

        }
        
    }
 

}