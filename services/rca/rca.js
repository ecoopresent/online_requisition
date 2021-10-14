var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $('#tab_rca').addClass('active-module');

    $('#rcatab').addClass('active');

    $('#save_cashcheck').on('click',function(){
        var inputs = $(".req");
        var a = 0;
        for(var i = 0; i < inputs.length; i++){
            var inp = $(inputs[i]).val();
            if(inp=="" || inp==null){
              a += 1;
            }
        }
        if(a > 0){
          $.Toast("Please fill in all the required fields", errorToast);
        }else{
          $('#PRModal').modal('hide');
          confirmed("save",save_cashcheck_callback, "Do you really want to save this?", "Yes", "No");
        }

    });
    load_RCA();

    $('#save_editRCA').on('click',function(){

        var inputs = $(".req2");
        var a = 0;
        for(var i = 0; i < inputs.length; i++){
            var inp = $(inputs[i]).val();
            if(inp=="" || inp==null){
              a += 1;
            }
        }
        if(a > 0){
          $.Toast("Please fill in all the required fields", errorToast);
        }else{
          $('#RCAmodal').modal('hide');
          confirmed("save",save_editRCA_callback, "Do you really want to save this?", "Yes", "No");
        }

        
    });

    $('#approvedrca_tab').on('click', function(){
        var status = "Finished";
        load_RCAdone(status);
    });

    $('#pendingrca_tab').on('click', function(){
        var status = "Submitted";
        load_RCAdone(status);
    });

    $('#pre_approvedrca_tab').on('click', function(){
        var status = "PreApproved";
        load_RCAdone(status);
    });



    $('#disapprovedrca_tab').on('click', function(){
        var status = "Disapproved";
        load_RCAdone(status);
    });
           
});

function save_editRCA_callback(){
    var c = post_Data('controller.rca.php?mode=update',{
        cash_id: $('#cash_id').val(),
        department: $('#r_department').val(),
        payee: $('#r_payee').val(),
        date_prepared: $('#r_date_prepared').val(),
        date_needed: $('#r_date_needed').val(),
        particulars: $('#r_particulars').val(),
        amount: $('#r_amount').val(),
        purpose: $('#r_purpose').val(),
        remarks: $('#r_remarks').val(),
        charge_to: $('#r_charge_to').val(),
        budget: $('#r_budget').val(),
        liquidated_on: $('#r_liquidated_on').val(),
        prepared_by: $('#r_prepared_by').val()
    });
    window.location.href="rca.php";
}

function save_cashcheck_callback(){

    var c = post_Data('controller.rca.php?mode=add',{
        department: $('#department').val(),
        payee: $('#payee').val(),
        date_prepared: $('#date_prepared').val(),
        date_needed: $('#date_needed').val(),
        particulars: $('#particulars').val(),
        amount: $('#amount').val(),
        purpose: $('#purpose').val(),
        remarks: $('#remarks').val(),
        charge_to: $('#charge_to').val(),
        budget: $('#budget').val(),
        liquidated_on: $('#liquidated_on').val(),
        prepared_by: $('#prepared_by').val()
    });
    window.location.href="rca.php";

}

function load_attachments(id){
    $('#attachmentTable').DataTable().destroy();
    dataTable_load('#attachmentTable','controller.rca.php?mode=tableAttach&cashcheck_id='+id,[
       {"data":"action"},
       {"data":"attachment"}
       
    ],10);
}

function load_RCAdone(status){
    $('#RCAList_tableDone').DataTable().destroy();
    dataTable_load('#RCAList_tableDone','controller.rca.php?mode=tableDone&status='+status,[
       {"data":"action"},
       {"data":"rca_no"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"particulars"},
       {"data":"amount"},
       {"data":"purpose"},
       {"data":"approvers"}
       
    ],10);

}

function load_RCA(){
    $('#RCAList_table').DataTable().destroy();
    dataTable_load('#RCAList_table','controller.rca.php?mode=table',[
       {"data":"action"},
       {"data":"rca_no"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"particulars"},
       {"data":"amount"},
       {"data":"purpose"}
       
    ],10);

}

function addAttach(id){
    
    $('#cashcheck_id').val(id);
    $('#attachmentModal').modal('show');
    load_attachments(id);
}

function openAttachment(attachment,newFolder){

    window.open("attachments/"+newFolder+"/"+attachment);
}

function deleteAttachment(id,attachment,cashcheck_id){
    var datas = [id, attachment,cashcheck_id];
    confirmed("delete",deleteAttachment_callback, "Do you really want to delete this?", "Yes", "No", datas);
}

function deleteAttachment_callback(datas){

    var cashcheck_id = $('#cashcheck_id').val();
    var c = post_Data('controller.rca.php?mode=deleteAttach',{
        id: datas[0],
        attachment: datas[1],
        cashcheck_id: datas[2]
    });
    $.Toast("Successfully Deleted", successToast);
    load_attachments(cashcheck_id);
}

function editRCA(id,department,payee,date_prepared,date_needed,particulars,amount,purpose,remarks,charge_to,budget,liquidated_on,prepared_by){
    $('#cash_id').val(id);
    $('#r_department').val(department);
    $('#r_payee').val(payee);
    $('#r_date_prepared').val(date_prepared);
    $('#r_date_needed').val(date_needed);
    $('#r_particulars').val(particulars);
    $('#r_amount').val(amount);
    $('#r_purpose').val(purpose);
    $('#r_remarks').val(remarks);
    $('#r_charge_to').val(charge_to);
    $('#r_budget').val(budget);
    $('#r_liquidated_on').val(liquidated_on);
    $('#r_prepared_by').val(prepared_by);

    $('#RCAmodal').modal('show');
}

function deleteRCA(id){

    confirmed("delete",deleteRCA_callback, "Do you really want to delete this?", "Yes", "No", id);
}

function resendRCA(id,approver_type){
    var rca = [id,approver_type];
    confirmed("save",resendRCA_callback, "Do you really want to resend this?", "Yes", "No", rca);
}

function resendRCA_callback(rca){
    var approver_type = rca[1];
    var id = rca[0];
    toggleLoad();
    if(approver_type=="twoD"){
        window.location.href="tcpdf/examples/rca_finalDresend.php?id="+id;
    }
    if(approver_type=="two"){
        window.location.href="tcpdf/examples/rca_finalResend.php?id="+id;
    }

    if(approver_type=="twoC"){
        window.location.href="tcpdf/examples/rca_finalCresend.php?id="+id;
    }
    if(approver_type=="twoE" || approver_type=="twoEE"){
        window.location.href="tcpdf/examples/rca_finalEresend.php?id="+id+"&at="+approver_type;
    }
    if(approver_type=="twoF"){
        window.location.href="tcpdf/examples/rca_finalFresend.php?id="+id;
    }
    if(approver_type=="three"){
        window.location.href="tcpdf/examples/rca_finalResend.php?id="+id;
    }
    
}

function deleteRCA_callback(id){

    var c = post_Data('controller.rca.php?mode=delete',{
        id: id
    });
    $.Toast("Successfully Deleted", successToast);
    load_RCA();
    // window.location.href="rca.php";
}

function sendRCA(id,prepared_by){
    $('#requested_by').val(prepared_by);
    $('#c_id').val(id);
    $('#ReportsModal').modal('show');
}

function submitRCA(){
    $('#ReportsModal').modal('hide');
    confirmed("save", submitRCA_callback, "Do you really want to send this?", "Yes", "No");

}

function submitRCA_callback(){
    var c = post_Data('controller.rca.php?mode=submit',{
        id: $('#c_id').val(),
        approver: $('#approver').val()
    }); 
    var approver = $('#approver').val();
    var requested_by = $('#requested_by').val();
    var id = $('#c_id').val();
    toggleLoad();
    if(approver=="three" || approver=="threeB"){
        window.location.href="tcpdf/examples/rca_extra.php?id="+id+"&r="+requested_by+"&at="+approver;
    }else{
        window.location.href="tcpdf/examples/rca_head.php?id="+id+"&r="+requested_by+"&at="+approver;
    }
    
}

function viewRCA(id){
    window.open("tcpdf/examples/cashcheck.php?id="+id);
}