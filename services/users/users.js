var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    load_PettycashList();
    
    $('#tab_users').addClass('active-module');
    $('#newuserTab').addClass('active');

    $('#saveUser').on('click',function(){

      var c = post_Data('controller.users.php?mode=add',{
        full_name: $('#full_name').val(),
        username: $('#username').val(),
        password: $('#password').val(),
        user_type: $('#user_type').val(),
        department: $('#department').val()
      });

      alert("Successfully Saved");
      window.location.href="users.php";

    });

    $('#updateUser').on('click',function(){

        var c = post_Data('controller.users.php?mode=update',{
          id: $('#eid').val(),
          full_name: $('#efull_name').val(),
          username: $('#eusername').val(),
          password: $('#epassword').val(),
          user_type: $('#euser_type').val(),
          department: $('#edepartment').val()
        });

        alert("Successfully Saved");
        window.location.href="users.php";

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
            $("select[name='department']").empty();
            $("select[name='department']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#department').append(data.html);

            $("select[name='edepartment']").empty();
            $("select[name='edepartment']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#edepartment').append(data.html);
        }
    })
}

function load_PettycashList(){
    $('#usersTable').DataTable().destroy();
    dataTable_load('#usersTable','controller.users.php?mode=tableList',[
       {"data":"action"},
       {"data":"full_name"},
       {"data":"username"},
       {"data":"passwords"},
       {"data":"user_dept"},
       {"data":"user_type"}
       
    ],10);

    $('#dataTableSearch').on('keyup', function(){
        $('#userTable').DataTable().search($(this).val()).draw();
    })

}

function deleteUser(id){
  var r = confirm("Delete?");
  if(r==true){
    var c = post_Data('controller.users.php?mode=delete',{
      id: id
    });
    alert("Successfully Deleted");
    window.location.href="users.php";
  }
}

function editUser(id,full_name,username,password,user_type,user_dept){
    $('#eid').val(id);
    $('#efull_name').val(full_name);
    $('#eusername').val(username);
    $('#epassword').val(password);
    $('#euser_type').val(user_type);
    $('#edepartment').val(user_dept);
    $('#userModal').modal('show');
}



