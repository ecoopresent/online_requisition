var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_accounting').addClass('active-module');
    var cash_status = $('#cash_status').val();
    load_Purchasing(cash_status);
    
    $('#cash_status').on('change', function(){
        var cash_status = $('#cash_status').val();
        load_Purchasing(cash_status);
    });
});

function load_Purchasing(cash_status){
    $('#Cashrequest_table').DataTable().destroy();
    dataTable_load('#Cashrequest_table','controller.accounting.php?mode=table&cash_status='+cash_status,[
       {"data":"action"},
       {"data":"rca"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"cashstatus"}
       
    ],10);

}

function open_Cash(id){
  // window.open("tcpdf/examples/cashcheck.php?id="+id);
  alert("w");
}

function approve_Cash(id){
  var r = confirm("Approve Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.accounting.php?mode=status',{
      id: id,
      cash_status: "Approved2"
    });
    alert("Approved");
    $('#cash_status').val("Approved");
    load_Purchasing("Approved");
  }
  
}
function disapprove_Cash(id){
  var r = confirm("Disapprove Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.accounting.php?mode=status',{
      id: id,
      cash_status: "Disapproved2"
    });
    alert("Disapproved");
    $('#cash_status').val("Approved");
    load_Purchasing("Approved");
  }
}

function undo_Cash(id){
  var r = confirm("Undo Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.accounting.php?mode=status',{
      id: id,
      cash_status: "Approved"
    });
    alert("Undo");
    $('#cash_status').val("Approved");
    load_Purchasing("Approved");
  }
}
function send_Cash(cash_id){
  var r = confirm("send to accounting?");
  if(r==true){
    var c = post_Data('controller.accounting.php?mode=status',{
      id: cash_id,
      cash_status: "Finished"
    });
    alert("Successfully sent");
    // $('#cash_status').val("Approved2");
    // load_Purchasing("Approved");
    window.location.href="accounting.php";
  }

}