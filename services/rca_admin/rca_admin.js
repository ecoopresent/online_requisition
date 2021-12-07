var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_rcaadmin();
    
    $('#tab_rcaadmin').addClass('active-module');
    $('#Tabtab').addClass('active');


});

function load_rcaadmin(){
    $('#rcaadminTable').DataTable().destroy();
    dataTable_load('#rcaadminTable','controller.payee.php?mode=tableRCAadmin',[
       {"data":"action"},
       {"data":"cash_status"},
       {"data":"rca_no"},
       {"data":"date_prepared"},
       {"data":"particulars"}
       
    ],10);

}

function openRCA(id){
    window.location.href="tcpdf/examples/cashcheck.php?id="+id;
}

function deleteRCA(id){
    var r = confirm("Do you really want to delete this?");
    if(r==true){

        var c = post_Data('controller.payee.php?mode=deleteRCAadmin',{
            id: id
        });
        $.Toast("Successfully Deleted", errorToast);
        window.location.href="rca_admin.php";

    }
}