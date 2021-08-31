var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $('#tab_pr').addClass('active-module');

    $('#prlisttab').on('click',function(){
        btn_cancelPR();
    });

    $('#prtab').addClass('active');
    $('#PRdetails_div').hide();
    load_PR();
    load_PRList();

    $('#savePR').on('click',function(){

        var inputs = $(".req");
        var a = 0;
        for(var i = 0; i < inputs.length; i++){
            var inp = $(inputs[i]).val();
            if(inp=="" || inp==null){
              a += 1;
            }
        }
        if(a > 0){
          $.Toast("Please fill in all the required fields", errorToast);
        }else{
          confirmed("save",savePR_callback, "Do you really want to save this?", "Yes", "No");
        }

       

    });

    $('#savePR_details').on('click',function(){
        var id = $('#pr_details_id').val();
        var mode = "";
        if(id==null || id==""){
            mode="addPR_details";
        }else{
            mode="UpdatePR_details"
        }
        var c = post_Data('controller.pr.php?mode='+mode,{
            item_code: $('#item_code').val(),
            stock: $('#stock').val(),
            rqmt: $('#rqmt').val(),
            uom: $('#uom').val(),
            item_description: $('#item_description').val(),
            pr_id: $('#pr_id').val(),
            id: id
        });

        $.Toast("Successfully Added", successToast);
        ClearTbox();
        $('#RequestModal').modal('hide');
        load_PR();
    });

    $('#submitPR').on('click',function(){

        confirmed("save",submitPR_callback, "Do you really want to save this?", "Yes", "No");
        
    });

    $('#submitPRtrade').on('click',function(){

        confirmed("save",submitPRtrade_callback, "Do you really want to save this?", "Yes", "No");

    });

    $('#save_editPR').on('click',function(){

        var inputs = $(".req2");
        var a = 0;
        for(var i = 0; i < inputs.length; i++){
            var inp = $(inputs[i]).val();
            if(inp=="" || inp==null){
              a += 1;
            }
        }
        if(a > 0){
          $.Toast("Please fill in all the required fields", errorToast);
        }else{
          $('#PRModal').modal('hide');
          confirmed("save",save_editPR_callback, "Do you really want to save this?", "Yes", "No");
        }

    });

    getPRno();

    $('#prapprovedtab').on('click',function(){
        var status = "Approved";
        load_PRListdone(status);
    });

    $('#prdisapprovedtab').on('click',function(){
        var status = "Disapproved";
        load_PRListdone(status);
    });
    

    
           
});

function submitPRtrade_callback(){
    var c = post_Data('controller.pr.php?mode=submitTrade',{
        pr_id: $('#pr_id').val()
    });
    $.Toast("Successfully Saved", successToast);
    var pr_id = $('#pr_id').val();
    var email_Approver = $('#email_Approver').val();
    var name_Approver = $('#name_Approver').val();
    window.location.href="pr.php";
}

function submitPR_callback(){
    var c = post_Data('controller.pr.php?mode=submit',{
        pr_id: $('#pr_id').val()
    });

    var pr_id = $('#pr_id').val();
    var email_Approver = $('#email_Approver').val();
    var name_Approver = $('#name_Approver').val();
    toggleLoad();
    window.location.href="tcpdf/examples/pr_list_email_head.php?id="+pr_id+"&e="+email_Approver+"&n="+name_Approver;
}

function save_editPR_callback(){
    var c = post_Data('controller.pr.php?mode=updatePR',{
            id: $('#PRid').val(),
            department: $('#pr_department').val(),
            date_prepared: $('#pr_date_prepared').val(),
            date_needed: $('#pr_date_needed').val(),
            pr_no: $('#pr_pr_number').val(),
            purpose: $('#pr_purpose').val(),
            pr_pr_type: $('#pr_pr_type').val()
    });
    $.Toast("Successfully Saved", successToast);
    load_PRList();
}

function savePR_callback(){
     var c = post_Data('controller.pr.php?mode=addPR',{
            department: $('#department').val(),
            date_prepared: $('#date_prepared').val(),
            date_needed: $('#date_needed').val(),
            pr_no: $('#pr_no').val(),
            purpose: $('#purpose').val(),
            pr_type: $('#pr_type').val()
        });
        window.location.href="pr.php";
}

function load_PRListdone(status){
    $('#PRListdone_table').DataTable().destroy();
    dataTable_load('#PRListdone_table','controller.pr.php?mode=tableListdone&status='+status,[
       {"data":"action"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"},
       {"data":"remarks"}
       
    ],10);

}

function view_PRequest(id){
    window.open("tcpdf/examples/pr_list.php?id="+id);
}

function getPRno(){
  var c = get_Data('controller.pr.php?mode=getPR');
  
  $('#pr_no').val(c.pr_no);
}

function select_PR(id,pr_no,pr_status,purpose,pr_type){
    if(pr_status=='Pending'){
        $('#savePR_details').show();
        if(pr_type!="non"){
            $('#submitPRtrade').show();
            $('#submitPR').hide();
        }else{
            $('#submitPR').show();
            $('#submitPRtrade').hide();
        }
        
        
        $('#name_Approver').hide();
        $('#email_Approver').hide();
    }else{
        $('#savePR_details').hide();
        $('#submitPR').hide();
        $('#submitPRtrade').hide();
        $('#name_Approver').hide();
        $('#email_Approver').hide();
    }
    $('#view_purpose').val(purpose);
    $('#pr_id').val(id);
    $('#View_pr_no').val(pr_no);
    $('#View_pr_type').val(pr_type+" trading");
    $('#PR_table_div').hide();
    $('#PRdetails_div').slideDown();
    load_PR();

}

function edit_PR(id,department,date_prepared,date_needed,pr_no,purpose,pr_type){
    $('#PRid').val(id);
    $('#pr_department').val(department);
    $('#pr_date_prepared').val(date_prepared);
    $('#pr_date_needed').val(date_needed);
    $('#pr_pr_number').val(pr_no);
    $('#pr_purpose').val(purpose);
    $('#pr_pr_type').val(pr_type);
    $('#PRModal').modal('show');
}

function btn_cancelPR(){
    $('#PR_table_div').slideDown();
    $('#PRdetails_div').hide();
    $('#pr_id').val("");
    $('#View_pr_no').val("");
}

function load_PRList(){
    $('#PRList_table').DataTable().destroy();
    dataTable_load('#PRList_table','controller.pr.php?mode=tableList',[
       {"data":"action"},
       {"data":"pr_status"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"}
       
    ],10);

}

function load_PR(){

    $('#PR_table').DataTable().destroy();
    var pr_id = $('#pr_id').val();
    dataTable_load('#PR_table','controller.pr.php?mode=table&pr_id='+pr_id,[
       {"data":"action"},
       {"data":"item_code"},
       {"data":"stock"},
       {"data":"rqmt"},
       {"data":"uom"},
       {"data":"item_description"}
       
    ],10);

    var c = post_Data('controller.pr.php?mode=countPR',{
      pr_id: pr_id
    });

    if(c.countPr > 0){
      var View_pr_type = $('#View_pr_type').val();
      if(View_pr_type=="non trading"){
        $('#submitPR').show();
        $('#submitPRtrade').hide();
      }else{
        $('#submitPRtrade').show();
        $('#submitPR').hide();
      }
      
      $('#name_Approver').hide();
      $('#email_Approver').hide();
    }else{
      $('#submitPR').hide();
      $('#submitPRtrade').hide();
      $('#name_Approver').hide();
      $('#email_Approver').hide();
    }

}

function delete_PR(id){

    confirmed("delete",delete_PR_callback, "Do you really want to delete this?", "Yes", "No", id);

}

function delete_PR_callback(id){
    var c = post_Data('controller.pr.php?mode=deletePR',{
            id: id
    });
    $.Toast("Successfully Deleted", successToast);
    load_PRList();
}

function deletePR_details(id){

    confirmed("delete",deletePR_details_callback, "Do you really want to delete this?", "Yes", "No", id);
}

function deletePR_details_callback(id){
    var c = post_Data('controller.pr.php?mode=delete_PRdetails',{
        id: id
    });
    $.Toast("Successfully Deleted", successToast);
    load_PR();
}

function editPR_details(id,item_code,stock,rqmt,uom,item_description){
    $('#pr_details_id').val(id);
    $('#item_code').val(item_code);
    $('#stock').val(stock);
    $('#rqmt').val(rqmt);
    $('#uom').val(uom);
    $('#item_description').val(item_description);
    $('#RequestModal').modal('show');
}

function ClearTbox(){
    $('#pr_details_id').val("");
    $('#item_code').val("");
    $('#stock').val("");
    $('#rqmt').val("");
    $('#uom').val("");
    $('#item_description').val("");
}