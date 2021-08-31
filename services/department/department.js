var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_dept();
    
    $('#tab_department').addClass('active-module');
    $('#newuserTab').addClass('active');

    $('#saveDepartment').on('click',function(){

      var c = post_Data('controller.department.php?mode=add',{
        department: $('#department').val(),
        department_head: $('#department_head').val(),
        department_email: $('#department_email').val()
      });

      alert("Successfully Saved");
      window.location.href="department.php";

    });

    $('#updateDept').on('click',function(){

        var c = post_Data('controller.department.php?mode=update',{
          id: $('#eid').val(),
          department: $('#edepartment').val(),
          department_head: $('#edepartment_head').val(),
          department_email: $('#edepartment_email').val()
        });

        alert("Successfully Saved");
        window.location.href="department.php";

    });

});

function load_dept(){
    $('#departmentTable').DataTable().destroy();
    dataTable_load('#departmentTable','controller.department.php?mode=tableList',[
       {"data":"action"},
       {"data":"department"},
       {"data":"department_head"},
       {"data":"department_email"}
       
    ],10);

}

function deleteDept(id){
  var r = confirm("Delete?");
  if(r==true){
    var c = post_Data('controller.department.php?mode=delete',{
      id: id
    });
    alert("Successfully Deleted");
    window.location.href="department.php";
  }
}


function editDept(id,department,department_head,department_email){
    $('#eid').val(id);
    $('#edepartment').val(department);
    $('#edepartment_head').val(department_head);
    $('#edepartment_email').val(department_email);
    $('#deptModal').modal('show');
}

