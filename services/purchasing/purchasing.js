var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $('#tab_purchasing').addClass('active-module');
    $('#canvas_details_div').hide();
    load_Purchasing();
    var id = 0;
    load_Pr_details(id);

    $('#save_canvas').on('click',function(){
      confirmed("save",save_canvas_callback, "Do you really want to save this?", "Yes", "No");
    });
           
});

function save_canvas_callback(){
    var pr_id = $('#pr_id').val();
      var canvas_id = $('#canvas_id').val();
      var mode = '';
      if(pr_id==""){
        $.Toast("Please Select PR first", errorToast);
      }else{
        if(canvas_id==0){
          mode = "AddCanvas";
        }else{
          mode = "UpdateCanvas";
        }
        var c = post_Data('controller.purchasing.php?mode='+mode,{
            pr_id: pr_id,
            canvas_date: $('#canvas_date').val(),
            supplier1: $('#supplier1').val(),
            supplier2: $('#supplier2').val(),
            supplier3: $('#supplier3').val(),
            supplier4: $('#supplier4').val(),
            supplier5: $('#supplier5').val(),
            remarks: $('#remarks').val(),
            canvas_id: canvas_id
        });
        // $.Toast("Successfully Saved", successToast);
        window.location.href="purchasing.php";

    }
}

function load_Purchasing(){
    $('#Prequest_table').DataTable().destroy();
    dataTable_load('#Prequest_table','controller.purchasing.php?mode=table',[
       {"data":"action"},
       {"data":"canvas_statuss"},
       {"data":"prtype"},
       {"data":"status"},
       {"data":"department"},
       {"data":"date_prepared"},
       {"data":"date_needed"},
       {"data":"pr_no"},
       {"data":"purpose"},
       {"data":"requested_by"},
    ],10);

}

function load_Pr_details(id){
    $('#Pr_details_table').DataTable().destroy();
    dataTable_load('#Pr_details_table','controller.purchasing.php?mode=tablePRDetails&pr_id='+id,[
       {"data":"item_code"},
       {"data":"stock"},
       {"data":"rqmt"},
       {"data":"uom"},
       {"data":"item_description"}
    ],10);
}

function open_PR(id,department,date_prepared,date_needed,pr_no,purpose,canvas_id,supplier1,supplier2,supplier3,supplier4,supplier5,canvas_date,remarks){
    $('#department').val(department);
    $('#date_prepared').val(date_prepared);
    $('#date_needed').val(date_needed);
    $('#pr_no').val(pr_no);
    $('#purpose').val(purpose);
    $('#pr_id').val(id);
    load_Pr_details(id);
    $('#canvas_id').val(canvas_id);
    $('#canvas_date').val(canvas_date);
    $('#supplier1').val(supplier1);
    $('#supplier2').val(supplier2);
    $('#supplier3').val(supplier3);
    $('#supplier4').val(supplier4);
    $('#supplier5').val(supplier5);
    $('#remarks').val(remarks);
    $('#canvas_div').hide();
    $('#canvas_details_div').slideDown();
}

function btn_cancelCanvas(){
    $('#canvas_div').slideDown();
    $('#canvas_details_div').hide();
    $('#department').val("");
    $('#date_prepared').val("");
    $('#date_needed').val("");
    $('#pr_no').val("");
    $('#purpose').val("");
    $('#pr_id').val("");
    load_Pr_details(id);
}

function view_PR(id){
  window.location.href="canvas.php?id="+id;
}