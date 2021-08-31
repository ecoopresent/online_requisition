var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){
    $('#tab_rcareports').addClass('active-module');
    $('#tab_pettyreports').addClass('active-module');
    var date_prepared = "";
    var date_preparedto = "";
    var department = "";
    load_Purchasing(date_prepared,date_preparedto);

    load_pettylist(date_prepared,date_preparedto,department);

    generateDepartmentSelect();
     
});


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
        }
    })
}

function load_Purchasing(date_prepared,date_preparedto){
    $('#Cashrequest_table').DataTable().destroy();
    dataTable_load('#Cashrequest_table','controller.reports.php?mode=table&date='+date_prepared+"&dateto="+date_preparedto,[
       {"data":"voucher_id"},
       {"data":"department"},
       {"data":"payee"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"amounts"}
       
    ],10);

}

function load_pettylist(date_prepared,date_preparedto,department){
    $('#Pettycash_table').DataTable().destroy();
    dataTable_load('#Pettycash_table','controller.reports.php?mode=tablePetty&date='+date_prepared+"&dateto="+date_preparedto+"&department="+department,[
       {"data":"voucher_no"},
       {"data":"department"},
       {"data":"voucher_date"},
       {"data":"particulars"},
       {"data":"cash_advances"},
       {"data":"actual_amounts"}
    ],10);
}


function export_(s){
  var date_prepared = $('#date_prepared').val();
  var date_preparedto = $('#date_preparedto').val();

  window.open('tcpdf/examples/rca_list.php?action='+s+'&date='+date_prepared+'&dateto='+date_preparedto);

  
}

function export_P(s){
  var date_prepared = $('#date_prepared').val();
  var date_preparedto = $('#date_preparedto').val();
  var department = $('#department').val();

  window.open('tcpdf/examples/pettycashs.php?action='+s+'&date='+date_prepared+'&dateto='+date_preparedto+'&department='+department);

  
}

function search(){
  var date_prepared = $('#date_prepared').val();
  var date_preparedto = $('#date_preparedto').val();
  if(date_prepared==""){
    alert("please select Date from");
  }else if(date_preparedto==""){
    alert("please select Date to");
  }else{
    load_Purchasing(date_prepared,date_preparedto);
  }
  

}

function searchP(){
  var date_prepared = $('#date_prepared').val();
  var date_preparedto = $('#date_preparedto').val();
  var department = $('#department').val();
  if(date_prepared==""){
    alert("please select Date from");
  }else if(date_preparedto==""){
    alert("please select Date to");
  }else{

    load_pettylist(date_prepared,date_preparedto,department);
  }
  

}