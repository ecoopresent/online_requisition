var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_pr_approval').addClass('active-module');
    var pr_status = $('#pr_status').val();
    load_Purchasing(pr_status);

    $('#pr_status').on('change', function(){
      var pr_status = $('#pr_status').val();
      load_Purchasing(pr_status);
    });
           
});

function load_Purchasing(pr_status){
    $('#Prequest_table').DataTable().destroy();
    dataTable_load('#Prequest_table','controller.pr_approval.php?mode=table&status='+pr_status,[
       {"data":"action"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"},
       {"data":"pr_status"}
       
    ],10);

}

function open_PR(id){
  window.open("tcpdf/examples/pr_list.php?id="+id);
}

function approve_PR(id){
  var r = confirm("Approve PR?");
  if(r==true){
    var c = post_Data('controller.pr_approval.php?mode=status',{
      id: id,
      pr_status: "Approved",
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
      
    });
    alert("Approved");
    window.location.href="approvalPRHead.php?id="+id+"&approver=";  
  }
  
}

function disapprove_PR(id){
  var r = confirm("Disapprove PR?");
  if(r==true){
    var c = post_Data('controller.pr_approval.php?mode=status',{
      id: id,
      pr_status: "Disapproved",
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });
    alert("Disapproved");
    window.location.href="approvalPRHead.php?id="+id+"&approver=";  
  }
}

function approve_Canvas(id){
  var r = confirm("Approve Canvas?");
  if(r==true){
    var c = post_Data('controller.canvasing.php?mode=UpdateCanvas',{
      id: id,
      canvas_status: "Finished",
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
      
    });
    toggleLoad();
    window.location.href="tcpdf/examples/pr_notif.php?id="+id; 
  }
  
}

function approve_CanvasLocal(id){
  var r = confirm("Approve Canvas?");
  if(r==true){
    var c = post_Data('controller.canvasing.php?mode=UpdateCanvas',{
      id: id,
      canvas_status: "Finished",
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
      
    });
    toggleLoad();
    window.location.href="tcpdf/examples/pr_list_emailnotif.php?id="+id; 
  }
  
}

function disapprove_Canvas(id){
  var r = confirm("Disapprove Canvas?");
  if(r==true){
    var c = post_Data('controller.canvasing.php?mode=UpdateCanvas',{
      id: id,
      canvas_status: "Rejected",
      remarks: $('#remarks').val(),
      approver: $('#approver').val()
    });
    alert("Disapproved");
    window.location.href="approvalPRHead.php?id="+id+"&approver=";  
  }
}

function undo_PR(id){
  var r = confirm("Undo PR?");
  if(r==true){
    var c = post_Data('controller.pr_approval.php?mode=status',{
      id: id,
      pr_status: "Submitted"
    });
    alert("Undo");
    var status = "Submitted";
    $('#pr_status').val(status);
    load_Purchasing(status);
  }
}