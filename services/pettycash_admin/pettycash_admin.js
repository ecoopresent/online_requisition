var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_pcadmin();
    
    $('#tab_pettycashadmin').addClass('active-module');
    $('#Tabtab').addClass('active');


});

function load_pcadmin(){
    $('#pcadminTable').DataTable().destroy();
    dataTable_load('#pcadminTable','controller.payee.php?mode=tablePCadmin',[
       {"data":"action"},
       {"data":"voucher_status"},
       {"data":"voucher_no"},
       {"data":"voucher_date"},
       {"data":"particulars"}
       
    ],10);

}

function openPC(id){
    window.location.href="tcpdf/examples/pettycash.php?id="+id;
}

function deletePC(id){
    var r = confirm("Do you really want to delete this?");
    if(r==true){

        var c = post_Data('controller.payee.php?mode=deletePCadmin',{
            id: id
        });
        $.Toast("Successfully Deleted", errorToast);
        window.location.href="pettycash_admin.php";

    }
}