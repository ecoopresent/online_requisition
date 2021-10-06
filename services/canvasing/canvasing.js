var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    var canvas_id = $('#canvas_id').val();
    load_CanvasDetails(canvas_id);
    
    $('#save_editCanvas').on('click',function(){
        var canvas_id = $('#canvas_id').val();
        var c_details_id = $('#c_details_id').val();
        if(c_details_id <=0){
            $mode = "addCanvasDet";
        }else{
            $mode = "updateCanvasDet";
        }
        var c = post_Data('controller.canvasing.php?mode='+$mode,{
            c_details_id: $('#c_details_id').val(),
            qty: $('#qty').val(),
            uom: $('#uom').val(),
            product_desc: $('#product_desc').val(),
            price1: $('#price1').val(),
            price2: $('#price2').val(),
            price3: $('#price3').val(),
            price4: $('#price4').val(),
            price5: $('#price5').val(),
            canvas_id: $('#canvas_id').val()
        });

        $.Toast("Successfully Saved", successToast);
        load_CanvasDetails(canvas_id);
        $('#CanvasSheetModal').modal('hide');
        // window.location.href="canvas.php?id="+canvas_id;
    })

});

function addAttach(preq_id){
    
    $('#preq_id').val(preq_id);
    $('#attachmentModal').modal('show');
    load_attachments(preq_id);
}

function openAttachment(attachment,newFolder){

    window.open("attachments/"+newFolder+"/"+attachment);
}

function deleteAttachment(id,attachment,preq_id){
    var datas = [id, attachment,preq_id];
    confirmed("delete",deleteAttachment_callback, "Do you really want to delete this?", "Yes", "No", datas);
}

function deleteAttachment_callback(datas){

    var preq_id = $('#preq_id').val();
    var c = post_Data('controller.canvasing.php?mode=deleteAttach',{
        id: datas[0],
        attachment: datas[1],
        preq_id: datas[2]
    });
    $.Toast("Successfully Deleted", successToast);
    load_attachments(preq_id);
}

function load_attachments(preq_id){
    $('#attachmentTable').DataTable().destroy();
    dataTable_load('#attachmentTable','controller.canvasing.php?mode=tableAttach&preq_id='+preq_id,[
       {"data":"action"},
       {"data":"attachment"}
       
    ],10);
}

function clear_details(){
    $('#qty').val("");
    $('#uom').val("");
    $('#product_desc').val("");
    $('#price1').val("");
    $('#price2').val("");
    $('#price3').val("");
    $('#price4').val("");
    $('#price5').val("");
}

function viewCanvas(id){
    window.open("tcpdf/examples/pr_list.php?id="+id);
}

function btn_cancelCanvas(){
    window.location.href="purchasing.php";
}

function load_CanvasDetails(canvas_id){

    $('#canvas_details_table').DataTable().destroy();
    dataTable_load('#canvas_details_table','controller.canvasing.php?mode=table&canvas_id='+canvas_id,[
       {"data":"action"},
       {"data":"qty"},
       {"data":"uom"},
       {"data":"product_desc"},
       {"data":"Price1"},
       {"data":"Price2"},
       {"data":"Price3"},
       {"data":"Price4"},
       {"data":"Price5"}
    ],10);
}

function editCanvasDetails(id,qty,uom,product_desc,price1,price2,price3,price4,price5){

    $('#c_details_id').val(id);
    $('#qty').val(qty);
    $('#uom').val(uom);
    $('#product_desc').val(product_desc);
    $('#price1').val(price1);
    $('#price2').val(price2);
    $('#price3').val(price3);
    $('#price4').val(price4);
    $('#price5').val(price5);


    $('#CanvasSheetModal').modal('show');
}

function sendCanvas(){

    confirmed("save",sendCanvas_callback, "Do you really want to send this?", "Yes", "No");
    
}

function sendCanvas_callback(){
    var pr_id = $('#pr_id').val();
    var c = post_Data('controller.canvasing.php?mode=updateStatus',{
        id: pr_id
    });

    if(c.department=="IT"){
        toggleLoad();
        window.location.href="tcpdf/examples/pr_list_email_IT.php?id="+pr_id;
    }else{
        toggleLoad();
        window.location.href="tcpdf/examples/pr_list_email.php?id="+pr_id;
    }
    
}

function sendCanvaslocal(){

    confirmed("save",sendCanvaslocal_callback, "Do you really want to send this?", "Yes", "No");

}

function sendCanvaslocal_callback(){
    var pr_id = $('#pr_id').val();
    var c = post_Data('controller.canvasing.php?mode=UpdateCanvasLocal',{
        id: pr_id
    });
    // alert("sending.....");
    toggleLoad();
    window.location.href="tcpdf/examples/pr_list_emailLocal.php?id="+pr_id;
}

function sendCanvasimport(){
    confirmed("save",sendCanvasimport_callback, "Do you really want to submit this?", "Yes", "No");
}

function sendCanvasimport_callback(){
    var pr_id = $('#pr_id').val();
    var c = post_Data('controller.canvasing.php?mode=updateStatusimport',{
        id: pr_id
    });
    toggleLoad();
    window.location.href="tcpdf/examples/pr_list_emailimport.php?id="+pr_id;
}

function addnewCanvas(){
    $('#CanvasSheetModal').modal('show');
    $('#c_details_id').val(0);
    clear_details();
}

function deleteCanvasDetails(id){
    confirmed("delete",deleteCanvasDetails_callback, "Do you really want to delete this?", "Yes", "No", id);
}

function deleteCanvasDetails_callback(id){
    var c = post_Data('controller.canvasing.php?mode=deleteCanvasDetails',{
        id: id
    });

    var canvas_id = $('#canvas_id').val();
    window.location.href="canvas.php?id="+canvas_id;
}