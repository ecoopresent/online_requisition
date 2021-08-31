var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_approvedCash').addClass('active-module');
    var cash_status = $('#cash_status').val();
    load_Purchasing(cash_status);

    $('#cash_status').on('change', function(){
      var cash_status = $('#cash_status').val();
      load_Purchasing(cash_status);
    });
           
});

function load_Purchasing(cash_status){
    $('#Cashrequest_table').DataTable().destroy();
    dataTable_load('#Cashrequest_table','controller.approvedCash.php?mode=table&cash_status='+cash_status,[
       {"data":"action"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"cashstatus"}
       
    ],10);

}

function openAttachment(attachment,newFolder){

  window.open("attachments/"+newFolder+"/"+encodeURIComponent(attachment));
}

function attach_RCA(id){
  $('#attachmentModal').modal('show');
  load_attachments(id);
}

function load_attachments(id){
  $('#attachmentTable').DataTable().destroy();
  dataTable_load('#attachmentTable','controller.approvedCash.php?mode=tableAttach&cashcheck_id='+id,[
     {"data":"action"},
     {"data":"attachment"}
     
  ],10);
}

function open_Cash(id){
  window.open("tcpdf/examples/cashcheck.php?id="+id);
}

function decline_RCA(id){
  confirmed("delete",decline_RCA_callback, "Do you really want to decline this?", "Yes", "No", id);
}

function decline_RCA_callback(id){
  var c = post_Data('controller.approvedCash.php?mode=declineRCA',{
    id: id
  });
  window.location.href="approvedCash.php";
}

function check_Cash(id){
  confirmed("save",check_Cash_callback, "Do you really want to end this transaction?", "Yes", "No", id);
}

function check_Cash_callback(id){
    var c = post_Data('controller.approvedCash.php?mode=status',{
      id: id,
      cash_status: "Checked"
    });
    $.Toast("Transaction Finished", successToast);
    var cash_status = $('#cash_status').val();
    load_Purchasing(cash_status);
}

function undo_Cash(id){
  confirmed("save",undo_Cash_callback, "Do you really want to undo this transaction?", "Yes", "No", id);
}

function undo_Cash_callback(id){
    var c = post_Data('controller.approvedCash.php?mode=status',{
      id: id,
      cash_status: "Finished"
    });
    $.Toast("Undo Transaction", successToast);
    var cash_status = $('#cash_status').val();
    load_Purchasing(cash_status);
}


function send_Cash(id){
  alert("sending...");
  window.location.href="tcpdf/examples/cashcheck_email.php?id="+id;
}