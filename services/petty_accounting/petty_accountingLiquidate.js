var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_accountingLiquidate').addClass('active-module');
    var petty_status = $('#petty_status').val();
    load_PettycashApprovalList(petty_status);

    $('#petty_status').on('change', function(){
      var petty_status = $('#petty_status').val();
      load_PettycashApprovalList(petty_status);
    });
});


function load_PettycashApprovalList(petty_status){
    $('#Pettycash_approvalTable').DataTable().destroy();
    dataTable_load('#Pettycash_approvalTable','controller.petty_accountingLiquidate.php?mode=table&status='+petty_status,[
       {"data":"action"},
       {"data":"department"},
       {"data":"voucher_date"},
       {"data":"voucher_no"},
       {"data":"particulars"},
       {"data":"cash_advance"},
       {"data":"actual_amount"},
       {"data":"charge_to"},
       {"data":"liquidated_on"}
       
    ],10);

}


function open_Petty(id){
  var c = post_Data('controller.petty_accountingLiquidate.php?mode=checkPetty',{
    id: id
  });
  if(c.countLiquidation > 0){
      $('#btn_liquidate').prop('disabled', false);
  }else{
      $('#btn_liquidate').prop('disabled', true);
  }
  $('#ReportsModal').modal('show');
  $('#pettyCashId').val(id);
}

function decline_Petty(id){
  confirmed("delete",decline_Petty_callback, "Do you really want decline this?", "Yes", "No", id);
}

function decline_Petty_callback(id){
  var c = post_Data('controller.petty_accounting.php?mode=declinePetty',{
    id: id
  });
  window.location.href="petty_accountingLiquidate.php";
}

function pettycash(){
  var pettyCashId = $('#pettyCashId').val();
  window.open("tcpdf/examples/pettycash.php?id="+pettyCashId);
}
function liquidate(){
  var pettyCashId = $('#pettyCashId').val();
  window.open("tcpdf/examples/liquidation.php?id="+pettyCashId);
}

function finish_Petty(id){

  confirmed("save",finish_Petty_callback, "Do you really want to finish this?", "Yes", "No", id);
  
}


function finish_Petty_callback(id){
    var petty_Status = "Finished";
    var c = get_Data('controller.petty_accountingLiquidate.php?mode=UpdateStat&id='+id+'&pettycash_status='+petty_Status);
    $.Toast("Successfully Finished", successToast);
    // window.location.href="petty_accountingLiquidate.php";  
    var petty_status = $('#petty_status').val();
    load_PettycashApprovalList(petty_status);
}

function undo_Petty(id){
  confirmed("save", undo_Petty_callback, "Do you really want to finish this?", "Yes", "No", id);
}

function undo_Petty_callback(id){
    var petty_Status = "Approved1";
    var c = get_Data('controller.petty_accountingLiquidate.php?mode=UpdateStat&id='+id+'&pettycash_status='+petty_Status);
    $.Toast("Undo Transaction", successToast);
    // window.location.href="petty_accountingLiquidate.php"; 
    var petty_status = $('#petty_status').val();
    load_PettycashApprovalList(petty_status); 
}