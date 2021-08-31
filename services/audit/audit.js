var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_audit();
    
    $('#tab_audit').addClass('active-module');
    $('#Tabtab').addClass('active');


});

function load_audit(){
    $('#auditTable').DataTable().destroy();
    dataTable_load('#auditTable','controller.payee.php?mode=tableAudit',[
       {"data":"audit_action"},
       {"data":"audit_date"},
       {"data":"audit_user"}
       
    ],10);

}