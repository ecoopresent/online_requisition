var errorToast = {'position':'bottom','align':'left', 'duration': 1000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 1000, 'class': "bg-success"}
$(document).ready(function(){

    $('#tab_approvedPR').addClass('active-module');
    $('#canvas_details_div').hide();
    var canvas_status = $('#canvas_status').val();
    load_Purchasing(canvas_status);

    $('#canvas_status').on('click', function(){
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

      confirmed("save",send_cashcheck_callback, "Do you really want to submit this?", "Yes", "No");

    });

    $('#btn_rejecteds').on('click',function(){
        var canvas_status = "Rejected";
        load_Purchasing(canvas_status);
    });

    $('#btn_pre_apps').on('click',function(){
        var canvas_status = "PreFinished";
        load_Purchasing(canvas_status);
    });

    $('#btn_reload').on('click',function(){
      window.location.href="approvedPr.php";
    });

    generateDepartmentSelect();
           
});

function resendCanvas(pr_id){
  toggleLoad();
  window.location.href="tcpdf/examples/pr_list_email_FinalResend.php?id="+pr_id;
}

function send_cashcheck_callback(){
  var id = $('#cash_id').val();
  var c = post_Data('controller.approvedpr.php?mode=send',{
    id: $('#cash_id').val()
  })
  // alert("Cash Request Sent");
  toggleLoad();
  window.location.href="tcpdf/examples/cashcheck_emailHead.php?id="+id;
}

function view_RCA(id){
  window.open("tcpdf/examples/cashcheck.php?id="+id);
}

function resendRCA(id){

  confirmed("save",resendRCA_callback, "Do you really want to resend this?", "Yes", "No", id);

}

function resendRCA_callback(id){
  toggleLoad();
  window.location.href="tcpdf/examples/cashcheck_emailFinalResend.php?id="+id;
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
       // {"data":"date_approved"},
       // {"data":"status"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"},
    ],10);

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

function approve_RCA(id){
  
  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var apprver_type = $('#apprver_type').val();
    var cash_status = "";
    if(apprver_type=="one"){
        cash_status = "Finished";
    }else if(apprver_type=="three"){
        cash_status = "Submitted";
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
    if(apprver_type=="one"){
      window.location.href="tcpdf/examples/accounting_notifyhead.php?id="+id;
    }else if(apprver_type=="twoB" || apprver_type=="twoC" || apprver_type=="three"){
      window.location.href="tcpdf/examples/rca_finalB.php?id="+id+"&at="+apprver_type;
    }else{
      window.location.href="tcpdf/examples/rca_final.php?id="+id+"&at="+apprver_type;
    }

  }
  
}

function F_approve_RCA(id){

  var apprver_type = $('#apprver_type').val();
  
  if(apprver_type=="three"){

    var r = confirm("Are you sure you want to approve this?");
    if(r==true){
      var c = post_Data('controller.approvedpr.php?mode=finalrespond',{
          id: id,
          remarks: $('#remarks').val(),
          approver: $('#approver').val(),
          cash_status: "PreApproveds"
      });

       toggleLoad();
       window.location.href="tcpdf/examples/rca_final.php?id="+id+"&at="+apprver_type;
    }

  }else if(apprver_type=="triple"){

    var r = confirm("Are you sure you want to approve this?");
    if(r==true){
      var c = post_Data('controller.approvedpr.php?mode=finalrespond',{
          id: id,
          remarks: $('#remarks').val(),
          approver: $('#approver').val(),
          cash_status: "Finisheds"
      });

       toggleLoad();
      window.location.href="tcpdf/examples/accounting_notifyfinal.php?id="+id;
    }


  }else{

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


  
  

}

function F_disapprove_RCA(id){

  var r = confirm("Do you really want to disapprove this?");
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

  var r = confirm("Do you really want to disapprove this?");
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
  window.location.href="approvalCashCheckHead.php?id="+id+"&approver=";
}