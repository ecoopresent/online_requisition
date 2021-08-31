var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_cashadvance_approval').addClass('active-module');
    var cash_status = $('#cash_status').val();
    load_Purchasing(cash_status);

    $('#cash_status').on('change', function(){
      var cash_status = $('#cash_status').val();
      load_Purchasing(cash_status);
    });
           
});

function load_Purchasing(cash_status){
    $('#Cashrequest_table').DataTable().destroy();
    dataTable_load('#Cashrequest_table','controller.cash_approval.php?mode=table&cash_status='+cash_status,[
       {"data":"action"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"cash_status"}
       
    ],10);

}

function open_Cash(id){
  window.open("tcpdf/examples/cashcheck.php?id="+id);
}

function approve_Cash(id){
  var r = confirm("Approve Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.cash_approval.php?mode=status',{
      id: id,
      cash_status: "Approved"
    });
    alert("Approved");
    $('#cash_status').val("Submitted");
    load_Purchasing("Submitted");
  }
  
}
function disapprove_Cash(id){
  var r = confirm("Disapprove Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.cash_approval.php?mode=status',{
      id: id,
      cash_status: "Disapproved"
    });
    alert("Disapproved");
    $('#cash_status').val("Submitted");
    load_Purchasing("Submitted");
  }
}

function undo_Cash(id){
  var r = confirm("Undo Cash Advance/Check Issuance?");
  if(r==true){
    var c = post_Data('controller.cash_approval.php?mode=status',{
      id: id,
      cash_status: "Submitted"
    });
    alert("Undo");
    $('#cash_status').val("Submitted");
    load_Purchasing("Submitted");
  }
}