var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_petty_approval').addClass('active-module');
    var petty_status = $('#petty_status').val();
    load_PettycashApprovalList(petty_status);

    $('#petty_status').on('change', function(){
      var petty_status = $('#petty_status').val();
      load_PettycashApprovalList(petty_status);
    });
});


function load_PettycashApprovalList(petty_status){
    $('#Pettycash_approvalTable').DataTable().destroy();
    dataTable_load('#Pettycash_approvalTable','controller.petty_approval.php?mode=table&status='+petty_status,[
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
  var c = post_Data('controller.petty_approval.php?mode=checkPetty',{
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

function send_Petty(id){
  alert("Sending.....");
  window.location.href="tcpdf/examples/pettywliqui.php?id="+id;
}

function pettycash(){
  var pettyCashId = $('#pettyCashId').val();
  window.open("tcpdf/examples/pettycash.php?id="+pettyCashId);
}
function liquidate(){
  var pettyCashId = $('#pettyCashId').val();
  window.open("tcpdf/examples/liquidation.php?id="+pettyCashId);
}

function finalapprove_Petty(id){

  var r = confirm("approve?");
  if(r==true){
    var petty_Status = "Approved1";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatFinal',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: "Jerome T. Chua"
    });
    // alert("Approved");
    toggleLoad();
    window.location.href="tcpdf/examples/pettycash_notif.php?id="+id;  
  }

}
function finaldisapprove_Petty(id){

  var r = confirm("approve?");
  if(r==true){
    var petty_Status = "Disapproved1";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatFinal',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: "Jerome T. Chua"
    });
    alert("Approved, click OK to send");
    window.location.href="approvalPettyFinal.php?id="+id;  
  }

}


function approve_Petty(id){
  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var petty_Status = "Approved";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStat',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });

    toggleLoad();
    window.location.href="tcpdf/examples/pettywliqui.php?id="+id;
  }
}

function ITapprove_Petty(id){

  var r = confirm("Are you sure you want to approve this?");
  if(r==true){
    var petty_Status = "Approved1";
    var c = post_Data('controller.petty_approval.php?mode=ITUpdateStat',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });

    toggleLoad();
    window.location.href="tcpdf/examples/pettycash_notif.php?id="+id;
  }

}
function disapprove_Petty(id){
  
  var r = confirm("disapprove?");
  if(r==true){
    var petty_Status = "Disapproved";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStat',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });
    alert("Disapproved");
    window.location.href="approvalPettyHead.php?id="+id+"&approver=";  
  }

}

function approve_Pettycash(id){
  var r = confirm("Are you sure want to approve this?");
  if(r==true){
    var petty_Status = "Pending";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });

    toggleLoad();
    window.location.href="tcpdf/examples/pettycash_notify.php?id="+id;
  }
}

function approve_PC(id){
  var r = confirm("Are you sure want to approve this?");
  if(r==true){
    var petty_Status = "PreApp";
    var c = post_Data('controller.petty_approval.php?mode=PCUpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });

    toggleLoad();
    window.location.href="tcpdf/examples/pcFinal.php?id="+id;
  }
}

function approve_FinalPC(id){
  var r = confirm("Are you sure want to approve this?");
  if(r==true){
    var petty_Status = "Pending";
    var c = post_Data('controller.petty_approval.php?mode=PCfinalUpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });

    toggleLoad();
    window.location.href="tcpdf/examples/pettycash_notify.php?id="+id;
  }
}

function disapprove_Pettycash(id){

  var r = confirm("disapprove?");
  if(r==true){
    var petty_Status = "Disapproved";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });
    alert("Disapproved");
    window.location.href="approvalPettycashHead.php?id="+id+"&approver=";  
  }

}

function disapprove_PettycashFinal(id){

  var r = confirm("disapprove?");
  if(r==true){
    var petty_Status = "Disapproved";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });
    alert("Disapproved");
    window.location.href="approvalPettycashFinal.php?id="+id+"&approver=";  
  }

}

function undo_Petty(id){

  var r = confirm("undo?");
  if(r==true){
    var petty_Status = "Submitted";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStat',{
      id:id,
      pettycash_status:petty_Status
    });
    alert("Undo");
    window.location.href="petty_approval.php";  
  }
}