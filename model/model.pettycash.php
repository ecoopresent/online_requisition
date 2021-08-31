<?php
date_default_timezone_set("Asia/Manila");
class Pettycash extends DBHandler {
    
    private $conn;

    public function __construct()
    {
        $this->conn = $this->connectDB();
    }

    public function addPettyCash($department,$voucher_date,$voucher_no,$particulars,$cash_advance,$actual_amount,$charge_to,$liquidated_on,$requested_by,$payee,$name_ApproverWL)
    {

        $qry = "SELECT COUNT(id) FROM pettycash WHERE voucher_no = '$voucher_no'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $roww = $this->fetchRow($stmt);
        $rCount =  $roww[0];

        if($rCount > 0){

            $query = "SELECT voucher_no FROM pettycash WHERE voucher_no like '%VHER%' ORDER BY id DESC LIMIT 1";
            $stmt = $this->prepareQuery($this->conn, $query);
            $row = $this->fetchRow($stmt);
            $vcher = $row[0];
            $vcher = explode("-", $vcher);
            $vcher_id = $vcher[1];
            if($vcher_id==""){
                $vcher_id = 0;
            }
            $vcher_id++;
            $voucher_no = 'VHER'.date('Y').'-'.$vcher_id;
        }

        $query = "INSERT INTO pettycash(department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, payee_id) VALUES('$department', '$voucher_date', '$voucher_no', '$particulars', '$cash_advance', '$actual_amount', '$charge_to', '$liquidated_on', '$requested_by', '', '$payee')";
        $stmt = $this->prepareQuery($this->conn, $query);
        $this->execute($stmt);

        return $voucher_no;

    }

    public function getAllDepartment()
    {
        $query = "SELECT id, department FROM department";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getAllPayee()
    {
        $query = "SELECT id, payee_name, payee_email, payee_dept FROM payee";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }
    

    public function updatePettyCash($PettyID,$petty_department,$petty_date,$petty_voucherno,$petty_particulars,$petty_cash_advance,$petty_actual_amount,$petty_charge_to,$petty_liquidated_on,$petty_requested_by)
    {

        $query = "UPDATE pettycash SET department = '$petty_department', voucher_date = '$petty_date', voucher_no = '$petty_voucherno', particulars = '$petty_particulars', cash_advance = '$petty_cash_advance', actual_amount = '$petty_actual_amount', charge_to = '$petty_charge_to', liquidated_on = '$petty_liquidated_on', requested_by = '$petty_requested_by' WHERE id = '$PettyID'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);

    }

    public function getPettycashlist($user_dept,$status)
    {
        $query = "";
        if($status==""){
            $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE pettycash_status = '$status' AND department = '$user_dept' OR pettycash_status = 'Sent' AND department = '$user_dept' ORDER BY pettycash_status ASC";
        }else if($status=="Pending"){
            $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE pettycash_status = '$status' AND department = '$user_dept' OR pettycash_status = 'Submitted' AND department = '$user_dept' ORDER BY pettycash_status ASC";
        }else{
            $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status FROM pettycash WHERE pettycash_status = '$status' AND department = '$user_dept' ORDER BY pettycash_status ASC";
        }
        
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function countPettycash($user_dept,$pettycash_status)
    {
        $query = "SELECT COUNT(id) FROM pettycash WHERE pettycash_status = '$pettycash_status' AND department = '$user_dept'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getVoucherinfo($id)
    {
        $query = "SELECT voucher_no, requested_by,approved_by, pettycash_status FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchRow($stmt);
    }

    public function countPettycashApproval($pettycash_status)
    {
        $query = "SELECT COUNT(id) FROM pettycash WHERE pettycash_status = '$pettycash_status'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function getPettycashlistdone($status,$user_dept)
    {   
        $WHERE = "pettycash_status = '$status' AND department = '$user_dept'";
        if($status=="Approved1"){
            $WHERE = "pettycash_status = 'Approved1' AND department = '$user_dept' OR pettycash_status = 'Finished' AND department = '$user_dept'";
        }else if($status=="Disapproved"){
            $WHERE = "pettycash_status = 'Disapproved' AND department = '$user_dept' OR pettycash_status = 'Disapproved1' AND department = '$user_dept'";
        }
        $query = "SELECT id, department, voucher_date, voucher_no, particulars, cash_advance, actual_amount, charge_to, liquidated_on, requested_by, approved_by, authorized, pettycash_status,remarks FROM pettycash WHERE ".$WHERE;
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getliquidationdetails($id)
    {
        $query = "SELECT id, liquidation_id, l_from, l_to, vehicle_type, amount FROM liquidation_details WHERE liquidation_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function deletePettyCash($id,$user_dept)
    {
        $qry = "SELECT voucher_no FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $qry);
        $row = $this->fetchRow($stmt);
        $voucher_no = $row[0];

        $date_today = date('Y-m-d');
        $audit_action = $user_dept." Department deleted pettycash with voucher number - ".$voucher_no;
        $audit_user = $user_dept.' Department';
        $qryy = "INSERT INTO audit_trail SET audit_action = '$audit_action', audit_date = '$date_today', audit_user = '$audit_user'";
        $stmt = $this->prepareQuery($this->conn, $qryy);
        $this->execute($stmt);

        $query = "DELETE FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function SubmitPetty($LiquiType,$pettycash_id,$actual_amount)
    {
        $pettycash_status = "Submitted";
        $query = "UPDATE pettycash SET pettycash_status = '$pettycash_status', liquidation = '$LiquiType',actual_amount = '$actual_amount' WHERE id = '$pettycash_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function add_liquidation($pettycash_id,$name,$liquidation_date,$branch,$position,$eparticular,$full_name)
    {
        $query = "INSERT INTO liquidation(pettycash_id, name, liquidation_date, branch, position, prepared_by, checked_by, approved_by, particulars) VALUES('$pettycash_id','$name','$liquidation_date','$branch','$position','$full_name','','','$eparticular')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_liquidation($pettycash_id,$name,$liquidation_date,$branch,$position,$eparticular,$liquidation_id)
    {
        $query = "UPDATE liquidation SET name = '$name', liquidation_date = '$liquidation_date', branch = '$branch', position = '$position', particulars = '$eparticular' WHERE id = '$liquidation_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function check_Petty($id)
    {
        $query = "SELECT id, pettycash_id, name, liquidation_date, branch, position, prepared_by, checked_by, approved_by, particulars FROM liquidation WHERE pettycash_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $id = $row[0];
        $name = $row[2];
        $liquidation_date = $row[3];
        $branch = $row[4];
        $position = $row[5];
        $particulars = $row[9];
        $prepared_by = $row[6];
        $checked_by = $row[7];
        $approved_by = $row[8];
        return array("id"=>$id,"name"=>$name,"liquidation_date"=>$liquidation_date,"branch"=>$branch,"position"=>$position,"particulars"=>$particulars,"prepared_by"=>$prepared_by,"checked_by"=>$checked_by,"approved_by"=>$approved_by);
        
    }

    public function add_Route($liquidation_id,$l_from,$l_to,$Vehicle_type,$l_amount)
    {
        $query = "INSERT INTO liquidation_details(liquidation_id, l_from, l_to, vehicle_type, amount) VALUES('$liquidation_id','$l_from','$l_to','$Vehicle_type','$l_amount')";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function update_Route($liquiDetailsID,$l_from,$l_to,$Vehicle_type,$l_amount)
    {
        $query = "UPDATE liquidation_details SET l_from = '$l_from', l_to = '$l_to', vehicle_type = '$Vehicle_type', amount = '$l_amount' WHERE id = '$liquiDetailsID'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function delete_Route($id)
    {
        $query = "DELETE FROM liquidation_details WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->execute($stmt);
    }

    public function count_Route($liquidation_id)
    {
        $query = "SELECT count(id),SUM(amount) FROM liquidation_details WHERE liquidation_id = '$liquidation_id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $countRoute = $row[0];
        $super_actual_amount = $row[1];

        return array("countRoute"=>$countRoute,"actual_amount"=>$super_actual_amount);
    }

    public function getVoucherno()
    {
        $query = "SELECT voucher_no FROM pettycash WHERE voucher_no like '%VHER%' ORDER BY id DESC LIMIT 1";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        $vcher = $row[0];
        $vcher = explode("-", $vcher);
        $vcher_id = $vcher[1];
        if($vcher_id==""){
            $vcher_id = 0;
        }
        $vcher_id++;
        $voucher_no = 'VHER'.date('Y').'-'.$vcher_id;

        return array("voucher_no"=>$voucher_no);
    }

    public function checkStatus($id){
        
        $query = "SELECT checked_by FROM liquidation WHERE pettycash_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function checkStatusAuthor($id){
        
        $query = "SELECT authorized FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

    public function checkStatusApp($id){
        
        $query = "SELECT approved_by FROM pettycash WHERE id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }
    
    public function checkStatusAuthorFinal($id){
        
        $query = "SELECT approved_by FROM liquidation WHERE pettycash_id = '$id'";
        $stmt = $this->prepareQuery($this->conn, $query);
        $row = $this->fetchRow($stmt);
        return $row[0];
    }

}