var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_payee();
    
    $('#tab_payee').addClass('active-module');
    $('#newpayeeTab').addClass('active');

    $('#savePayee').on('click',function(){

      var c = post_Data('controller.payee.php?mode=add',{
        payee_name: $('#payee_name').val(),
        payee_email: $('#payee_email').val(),
        payee_dept: $('#payee_dept').val()
      });

      alert("Successfully Saved");
      window.location.href="payee.php";

    });

    $('#updatePayee').on('click',function(){

        var c = post_Data('controller.payee.php?mode=update',{
          id: $('#eid').val(),
          payee_name: $('#epayee_name').val(),
          payee_email: $('#epayee_email').val(),
          payee_dept: $('#epayee_dept').val()
        });

        alert("Successfully Saved");
        window.location.href="payee.php";

    });

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
            $("select[name='payee_dept']").empty();
            $("select[name='payee_dept']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#payee_dept').append(data.html);

            $("select[name='epayee_dept']").empty();
            $("select[name='epayee_dept']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#epayee_dept').append(data.html);
        }
    })
}

function load_payee(){
    $('#payeeTable').DataTable().destroy();
    dataTable_load('#payeeTable','controller.payee.php?mode=tableList',[
       {"data":"action"},
       {"data":"payee_name"},
       {"data":"payee_email"},
       {"data":"payee_dept"}
       
    ],10);

}

function deletePayee(id){
  var r = confirm("Delete?");
  if(r==true){
    var c = post_Data('controller.payee.php?mode=delete',{
      id: id
    });
    alert("Successfully Deleted");
    window.location.href="payee.php";
  }
}

function editPayee(id,payee_name,payee_email,payee_dept){
    $('#eid').val(id);
    $('#epayee_name').val(payee_name);
    $('#epayee_email').val(payee_email);
    $('#epayee_dept').val(payee_dept);
    $('#payeeModal').modal('show');
}

