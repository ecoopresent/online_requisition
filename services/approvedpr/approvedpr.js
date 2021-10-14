var errorToast = {'position':'bottom','align':'left', 'duration': 1000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 1000, 'class': "bg-success"}
$(document).ready(function(){

    $('#tab_approvedPR').addClass('active-module');
    $('#canvas_details_div').hide();
    var canvas_status = $('#canvas_status').val();
    load_Purchasing(canvas_status);

    $('#canvas_status').on('change', function(){
      var canvas_status = $('#canvas_status').val();
      load_Purchasing(canvas_status);
    });

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
        confirmed("save",save_cashcheck_callback, "Do you really want to save this?", "Yes", "No");
      }


      

    });

    $('#send_cashcheck').on('click',function(){

      // confirmed("save",send_cashcheck_callback, "Do you really want to submit this?", "Yes", "No");
      $('#approverModal').modal('show');

    });

    $('#btn_rejecteds').on('click',function(){
        var canvas_status = "Rejected";
        load_Purchasing(canvas_status);
    });

    $('#btn_approved').on('click',function(){
        var canvas_status = "PreFinished";
        load_Purchasing(canvas_status);
    });

    generateDepartmentSelect();
           
});


function submitRCA(){
    $('#approverModal').modal('hide');
    confirmed("save", submitRCA_callback, "Do you really want to send this?", "Yes", "No");

}

function submitRCA_callback(){
    var c = post_Data('controller.rca.php?mode=submit',{
        id: $('#cash_id').val(),
        approver: $('#approver').val()
    }); 
    var approver = $('#approver').val();
    var requested_by = $('#requested_by').val();
    var id = $('#cash_id').val();
    toggleLoad();
    if(approver=="three"){
        window.location.href="tcpdf/examples/rca_extra.php?id="+id+"&r="+requested_by+"&at="+approver;
    }else{
        window.location.href="tcpdf/examples/rca_head.php?id="+id+"&r="+requested_by+"&at="+approver;
    }
    
}


function send_cashcheck_callback(){
  var id = $('#cash_id').val();
  var c = post_Data('controller.approvedpr.php?mode=send',{
    id: $('#cash_id').val()
  })

  toggleLoad();
  window.location.href="tcpdf/examples/cashcheck_emailHead.php?id="+id;


}

function view_RCA(id){
  window.open("tcpdf/examples/cashcheck.php?id="+id);
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
    if(approver_type=="twoE"){
        window.location.href="tcpdf/examples/rca_finalEresend.php?id="+id;
    }
    if(approver_type=="twoF"){
        window.location.href="tcpdf/examples/rca_finalFresend.php?id="+id;
    }
    if(approver_type=="three"){
        window.location.href="tcpdf/examples/rca_finalResend.php?id="+id;
    }
    
}

function save_cashcheck_callback(){
  var cash_id = $('#cash_id').val();
  var mode = "";
  if(cash_id <= 0){
    mode = "addCash";
  }else{
    mode = "updateCash";
  }
  var c = post_Data('controller.approvedpr.php?mode='+mode,{
      pr_id: $('#pr_id').val(),
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
      cash_id: cash_id
  });
  window.location.href="approvedPr.php";
}

function generateDepartmentSelect(){
    $.ajax({
        url: "controller/controller.users.php?mode=option",
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) { 
            var data = JSON.parse(data)
            $("select[name='department']").empty();
            $("select[name='department']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#department').append(data.html);

            $("select[name='edepartment']").empty();
            $("select[name='edepartment']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#edepartment').append(data.html);
        }
    })
}

function load_Purchasing(canvas_status){
    $('#Prequest_table').DataTable().destroy();
    dataTable_load('#Prequest_table','controller.approvedpr.php?mode=table&canvas_status='+canvas_status,[
       {"data":"action"},
       {"data":"date_approved"},
       {"data":"status"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"},
       {"data":"pr_type"}
    ],10);

}


function undoStatus_PR(id){
  confirmed("save", undoStatus_PR_callback, "Do you really want to undo this?", "Yes", "No", id);
}

function undoStatus_PR_callback(id){
  var c = post_Data('controller.approvedpr.php?mode=changeStatus',{
      id : id,
      status: "Finished"
  });
  alert("Successfully undo");
  window.location.href="approvedPr.php";
}

function changeStatus_PR(id){
  confirmed("save", changeStatus_PR_callback, "Do you really want to finish this?", "Yes", "No", id);
}

function changeStatus_PR_callback(id){
  var c = post_Data('controller.approvedpr.php?mode=changeStatus',{
      id : id,
      status: "FinalFinished"
  });
  alert("Successfully Finished");
  window.location.href="approvedPr.php";
}
function resend_Canvas(id){
  
  confirmed("save",resend_Canvas_callback, "Do you really want to resend this?", "Yes", "No", id);
}


function resend_Canvas_callback(id){
  toggleLoad();
  window.location.href="tcpdf/examples/pr_emailpresResend.php?id="+id; 
}

function open_PR(id,cash_id,department,payee,date_prepared,date_needed,particulars,amount,purpose,remarks,charge_to,budget,liquidated_on,label){
    

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    

    $('#pr_id').val(id);
    $('#cash_id').val(cash_id);
    $('#department').val(department);
    $('#payee').val(payee);
    if(date_prepared==""){
      $('#date_prepared').val(today);
    }else{
      $('#date_prepared').val(date_prepared);
    }
    
    $('#date_needed').val(date_needed);
    $('#particulars').val(particulars);
    $('#amount').val(amount);
    $('#purpose').val(purpose);
    $('#remarks').val(remarks);
    $('#charge_to').val(charge_to);
    $('#budget').val(budget);
    $('#liquidated_on').val(liquidated_on);

    $('#canvas_div').hide();
    $('#canvas_details_div').slideDown();

    if(label=="PENDING"){
        $('#save_cashcheck').show();
        $('#send_cashcheck').show();
        
        if(cash_id==0){
          $('#send_cashcheck').hide();
        }else{
          $('#send_cashcheck').show();
        }

    }else{
        $('#save_cashcheck').hide();
        $('#send_cashcheck').show();
    }

}

function btn_cancelCanvas(){
    $('#canvas_div').slideDown();
    $('#canvas_details_div').hide();


    $('#pr_id').val("");
}

function view_PR(id){
  window.open("tcpdf/examples/pr_list.php?id="+id);
}

function approve_CashCheck(id){

  var r = confirm("Are you sure you want to approve this?");
  if(r==true){

    var cash_status = "Approved";
    var remarks = $('#remarks').val();
    var approver = $('#approver').val();
    var c = post_Data('controller.approvedpr.php?mode=UpdateStatus',{
      id : id,
      cash_status : cash_status,
      remarks : remarks,
      approver : approver
    });
    toggleLoad();
    window.location.href="tcpdf/examples/cashcheck_emailFinal.php?id="+id;
  }

}
function disapprove_CashCheck(id){
  var r = confirm("Are you sure you want to disapprove this?");
  if(r==true){
    var cash_status = "Disapproved";
    var remarks = $('#remarks').val();
    var approver = $('#approver').val();
    var c = post_Data('controller.approvedpr.php?mode=UpdateStatus',{
      id : id,
      cash_status : cash_status,
      remarks : remarks,
      approver : approver
    });
    alert("Disapproved");
    window.location.href="approvalCashCheckHead.php?id="+id+"&approver=";
  }

}

function approve_RCA(id){
  
  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var apprver_type = $('#apprver_type').val();
    var cash_status = "";
    if(apprver_type=="one" || apprver_type=="oneB"){
        cash_status = "Finished";
    }else{
        cash_status = "PreApproved";
    }
    
    var c = post_Data('controller.approvedpr.php?mode=respond',{
      id: id,
      remarks: $('#remarks').val(),
      approver: $('#approver').val(),
      cash_status: cash_status

    });
    toggleLoad();
    if(apprver_type=="one" || apprver_type=="oneB"){
      window.location.href="tcpdf/examples/accounting_notifyhead.php?id="+id;
    }else if(apprver_type=="two"){
      window.location.href="tcpdf/examples/rca_final.php?id="+id;
    }else if(apprver_type=="twoC"){
      window.location.href="tcpdf/examples/rca_finalC.php?id="+id;
    }else if(apprver_type=="twoE"){
      window.location.href="tcpdf/examples/rca_finalE.php?id="+id;
    }else if(apprver_type=="twoF"){
      window.location.href="tcpdf/examples/rca_finalF.php?id="+id;
    }else if(apprver_type=="twoD"){
      window.location.href="tcpdf/examples/rca_finalD.php?id="+id;
    }else{
      window.location.href="tcpdf/examples/rca_final.php?id="+id;
    }
    
  }
  
}

function approve_RCAExtrafinal(id){
  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var c = post_Data('controller.approvedpr.php?mode=extrarespond',{
        id: id,
        remarks: $('#remarks').val(),
        approver: $('#approver').val(),
        cash_status: "Finished"
    });

    toggleLoad();
    window.location.href="tcpdf/examples/accounting_notifyextrafinal.php?id="+id;
  }
}

function approve_RCAExtra(id){

  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var c = post_Data('controller.approvedpr.php?mode=extrarespond',{
        id: id,
        remarks: $('#remarks').val(),
        approver: $('#approver').val(),
        cash_status: "Submitted"
    });

    toggleLoad();
    var approver = "two";
    var requested_by = "Jasmin Padernal";
    window.location.href="tcpdf/examples/rca_headextra.php?id="+id+"&r="+requested_by+"&at="+approver;
  }

  
}

function disapprove_RCAExtra(id){

  var r = confirm("Are you sure you want to disapprove this?");
  if(r==true){
    var c = post_Data('controller.approvedpr.php?mode=extrarespond',{
        id: id,
        remarks: $('#remarks').val(),
        approver: $('#approver').val(),
        cash_status: "Disapproved"
    });

    alert("Disapproved");
    window.location.href="approvalRCAExtra.php?id="+id+"&approver=&at=";
  }

}

function F_approve_RCA(id){

  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var c = post_Data('controller.approvedpr.php?mode=finalrespond',{
        id: id,
        remarks: $('#remarks').val(),
        approver: $('#approver').val(),
        cash_status: "Finished"
    });

     toggleLoad();
     window.location.href="tcpdf/examples/accounting_notifyfinal.php?id="+id;
  }
  

}

function F_disapprove_RCA(id){

  var r = confirm("Are you sure you want to disapprove this?");
  if(r==true){
    var c = post_Data('controller.approvedpr.php?mode=finalrespond',{
        id: id,
        remarks: $('#remarks').val(),
        approver: $('#approver').val(),
        cash_status: "Disapproved"
    });

    alert("Disapproved");
    window.location.href="approvalRCAFinal.php?id="+id+"&approver=&at=";
  }
  

}

function disapprove_RCA(id){

  var r = confirm("Are you sure you want to disapprove this?");
  if(r==true){

    var cash_status = "Disapproved";
    var c = post_Data('controller.approvedpr.php?mode=respond',{
      id: id,
      remarks: $('#remarks').val(),
      approver: $('#approver').val(),
      cash_status: cash_status

    });
    alert("Disapproved");
    window.location.href="approvalRCAHead.php?id="+id+"&approver=&at=";

  }

}


function finalapprove_CashCheck(id){
  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var cash_status = "Finished";
    var remarks = $('#remarks').val();
    var approver = $('#approver').val();
    var c = post_Data('controller.approvedpr.php?mode=UpdateFinalStatus',{
      id : id,
      cash_status : cash_status,
      remarks : remarks,
      approver : approver
    });
    // alert("Approved");
    toggleLoad();
    window.location.href="tcpdf/examples/accounting_notif.php?id="+id;
  }
  
}
function finaldisapprove_CashCheck(id){ 
  var cash_status = "Disapproved2";
  var remarks = $('#remarks').val();
  var approver = $('#approver').val();
  var c = post_Data('controller.approvedpr.php?mode=UpdateFinalStatus',{
    id : id,
    cash_status : cash_status,
    remarks : remarks,
    approver : approver
  });
  alert("Disapproved");
  window.location.href="approvalCashCheckFinal.php?id="+id+"&approver=";
}