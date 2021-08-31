var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-primary"}

$(document).ready(function(){

    
    $('#Pettydetails_div').hide();
    $('#saveType').hide();
    $('#email_Approver').hide();
    $('#name_Approver').hide();
    $('#super_actual_amount').hide();
    // $('#liquidated_div').hide();

    $('#tab_pettycash').addClass('active-module');
    $('#pettycashtab').addClass('active');

    $('#pettycashlisttab').on('click',function(){
      btn_cancelPetty();
      var statuss = "";
      load_PettycashList(statuss);
    });

    $('#pettyPreapproved').on('click',function(){
      btn_cancelPetty();
      var statuss = "Pending";
      load_PettycashList(statuss);
    });

    $('#pettyApproved').on('click',function(){
      var statuss = "Approved";
      load_DonePetty(statuss);
    });

    $('#pettyDispproved').on('click',function(){
      var statuss = "Disapproved";
      load_DonePetty(statuss);
    });

    $('#pettyFinalApproved').on('click',function(){
      var statuss = "Approved1";
      load_DonePetty(statuss);
    });

    $('#savePettyCash').on('click',function(){
        
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
          confirmed("save",savePettyCash_callback, "Do you really want to save this?", "Yes", "No");
        }

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
        $.Toast("Please fill in all the required field", errorToast);
      }else{
        $('#PettycashModal').modal('hide');
        confirmed("save",save_editPR_callback, "Do you really want to save this?", "Yes", "No");
      }
      
    });

    $('#LiquiType').on('change',function(){
      var LiquiType = $('#LiquiType').val();
      if(LiquiType=="yes"){
        $('#saveType').hide();
        $('#email_Approver').hide();
        $('#name_Approver').hide();
        $('#liquidated_div').slideDown();
      }else if(LiquiType=="no"){
        $('#saveType').show();
        $('#email_Approver').hide();
        $('#name_Approver').hide();
        // $('#liquidated_div').hide();
      }else{
        $('#saveType').hide();
        $('#email_Approver').hide();
        $('#name_Approver').hide();
        // $('#liquidated_div').hide();
      }
    })

    $('#saveliquidation').on('click',function(){
        var mode = "";
        var liquidation_id = $('#liquidation_id').val();
        if(liquidation_id!=""){
          mode = "updateLiqui";
        }else{
          mode = "addLiqui";
        }
        var c = post_Data('controller.pettycash.php?mode='+mode,{
          pettycash_id : $('#pettycash_id').val(),
          name: $('#name').val(),
          liquidation_date: $('#liquidation_date').val(),
          branch: $('#branch').val(),
          position: $('#position').val(),
          eparticular: $('#eparticular').val(),
          liquidation_id: liquidation_id
        });

        alert("Successfully Saved");
        btn_cancelPetty();
    })

    $('#save_Route').on('click',function(){
      var mode = "";
      var liquiDetailsID = $('#liquiDetailsID').val();
      if(liquiDetailsID!=""){
        mode = "updateRoute";
      }else{
        mode = "addRoute";
      }
      var c = post_Data('controller.pettycash.php?mode='+mode,{
          liquidation_id: $('#liquidation_id').val(),
          l_from: $('#l_from').val(),
          l_to: $('#l_to').val(),
          Vehicle_type: $('#Vehicle_type').val(),
          l_amount: $('#l_amount').val(),
          liquiDetailsID: liquiDetailsID
      });
      var l_id = $('#liquidation_id').val();
      alert("Successfully Saved");
      load_PettyCashDetails(l_id);
      $('#LiquidationModal').modal('hide');

    });

    getVoucherno();
    generateDepartmentSelect();
    generatePayeeSelect();

});

function savePettyCash_callback(){
  var c = post_Data('controller.pettycash.php?mode=addPetty',{
          department: $('#department').val(),
          voucher_date: $('#voucher_date').val(),
          voucher_no: $('#voucher_no').val(),
          particulars: $('#particulars').val(),
          cash_advance: $('#cash_advance').val(),
          actual_amount: $('#actual_amount').val(),
          charge_to: $('#charge_to').val(),
          liquidated_on: $('#liquidated_on').val(),
          requested_by: $('#requested_by').val(),
          payee: $('#payee').val(),
          name_ApproverWL: $('#name_ApproverWL').val()
        });
  $('#pcvv').html(c.pcv);
  
  $('#pcvModal').modal({backdrop: 'static', keyboard: false});
  $('#pcvModal').modal('show');

}

function refreshPC(){
  window.location.href="pettycash.php";
}

function save_editPR_callback(){
  var c = post_Data('controller.pettycash.php?mode=updatePetty',{
       PettyID: $('#PettyID').val(),
       petty_department: $('#petty_department').val(),
       petty_date: $('#petty_date').val(),
       petty_voucherno: $('#petty_voucherno').val(),
       petty_particulars: $('#petty_particulars').val(),
       petty_cash_advance: $('#petty_cash_advance').val(),
       petty_actual_amount: $('#petty_actual_amount').val(),
       petty_charge_to: $('#petty_charge_to').val(),
       petty_liquidated_on: $('#petty_liquidated_on').val(),
       petty_requested_by: $('#petty_requested_by').val()
     });
  // window.location.href="pettycash.php";
  load_PettycashList("");
}

function resendLiquidation(pettycash_id){
  confirmed("save",resendLiquidation_callback,"Do you really want to resend this?", "Yes", "No", pettycash_id);
  
}

function resendLiquidation_callback(pettycash_id){
  var email_Approver = $('#email_ApproverWL').val();
  var name_Approver = $('#name_ApproverWL').val();
  toggleLoad();
  window.location.href="tcpdf/examples/pettywliqui_head.php?id="+pettycash_id+"&e="+email_Approver+"&n="+name_Approver;
}


function generatePayeeSelect(){
    $.ajax({
        url: "controller/controller.pettycash.php?mode=optionPayee",
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) { 
            var data = JSON.parse(data)
            $("select[name='payee']").empty();
            $("select[name='payee']").append("<option value='0' selected='' disabled>-- Select Payee --</option>");
            $('#payee').append(data.html);
        }
    })
}


function generateDepartmentSelect(){
    $.ajax({
        url: "controller/controller.pettycash.php?mode=option",
        type: 'GET',
        processData: false,
        contentType: false,
        success: function(data) { 
            var data = JSON.parse(data)
            $("select[name='department']").empty();
            $("select[name='department']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#department').append(data.html);

            $("select[name='petty_department']").empty();
            $("select[name='petty_department']").append("<option value='0' selected='' disabled>-- Select Department --</option>");
            $('#petty_department').append(data.html);
        }
    })
}

function load_DonePetty(statuss){
    $('#DonePettyTable').DataTable().destroy();
    dataTable_load('#DonePettyTable','controller.pettycash.php?mode=tableListdone&status='+statuss,[
       {"data":"action"},
       {"data":"department"},
       {"data":"voucher_date"},
       {"data":"voucher_no"},
       {"data":"particulars"},
       {"data":"cash_advance"},
       {"data":"actual_amount"},
       {"data":"charge_to"},
       {"data":"liquidated_on"},
       {"data":"remarks"}
       
    ],10);

}


function getVoucherno(){
  var c = get_Data('controller.pettycash.php?mode=getVoucher');
  
  $('#voucher_no').val(c.voucher_no);
}

function load_PettycashList(statuss){
    $('#PettycashlistTable').DataTable().destroy();
    dataTable_load('#PettycashlistTable','controller.pettycash.php?mode=tableList&status='+statuss,[
       {"data":"action"},
       {"data":"pettycashstatus"},
       {"data":"department"},
       {"data":"voucher_date"},
       {"data":"voucher_no"},
       {"data":"particulars"},
       {"data":"cash_advance"},
       {"data":"actual_amount"},
       {"data":"charge_to"},
       {"data":"liquidated_on"}
       
    ],10);

}

function load_PettyCashDetails(liquidation_id){
  $('#LiquidationDetails_table').DataTable().destroy();
    dataTable_load('#LiquidationDetails_table','controller.pettycash.php?mode=tableDetails&id='+liquidation_id,[
       {"data":"action"},
       {"data":"l_from"},
       {"data":"l_to"},
       {"data":"vehicle_type"},
       {"data":"amount"}
       
  ],10);

  var c = post_Data('controller.pettycash.php?mode=countRoute',{
      liquidation_id: liquidation_id
  });

  if(c.countRoute > 0){
    $('#super_actual_amount').val(c.actual_amount);
    $('#saveTypewithLiqui').show();
    $('#name_ApproverWL').hide();
    $('#email_ApproverWL').hide();
  }else{
    $('#saveTypewithLiqui').hide();
    $('#name_ApproverWL').hide();
    $('#email_ApproverWL').hide();
    $('#super_actual_amount').val("");
  }

}

function editPetty(id,department,voucher_date,voucher_no,particulars,cash_advance,actual_amount,charge_to,liquidated_on,requested_by){
  $('#PettyID').val(id);
  $('#petty_department').val(department);
  $('#petty_date').val(voucher_date);
  $('#petty_voucherno').val(voucher_no);
  $('#petty_particulars').val(particulars);
  $('#petty_cash_advance').val(cash_advance);
  $('#petty_actual_amount').val(actual_amount);
  $('#petty_charge_to').val(charge_to);
  $('#petty_liquidated_on').val(liquidated_on);
  $('#petty_requested_by').val(requested_by);
  $('#PettycashModal').modal('show');
}

function deletePetty(id){
  confirmed("delete",deletePetty_callback, "Do you really want to delete this?", "Yes", "No", id);
}

function deletePetty_callback(id){
  var c = post_Data('controller.pettycash.php?mode=Delete',{
      id: id
    });
  load_PettycashList("");
}

function sendPetty(id){

  confirmed("save",sendPetty_callback, "Do you really want submit this?", "Yes", "No", id);

}

function sendPetty_callback(id){
    var petty_Status = "Pending";
    var c = post_Data('controller.petty_approval.php?mode=UpdateStatcash',{
      id:id,
      pettycash_status:petty_Status,
      remarks: "",
      approver: ""
    });
    toggleLoad();
    window.location.href="tcpdf/examples/pettycash_notify.php?id="+id;
}

function viewPettyC(id){
  window.open("tcpdf/examples/pettycash.php?id="+id);
}

function addLiquidation(id,pettycash_status,department,particulars,liquidated_on){

  if(pettycash_status=="Submitted"){
    $('#LiquiType').hide();
    $('#LiquiType').val("");
    $('#pettycash_id').val("");
    $('#Petty_table_div').hide();
    $('#labelSubmitted').show();
    $('#Pettydetails_div').slideDown();
    $('#branch').val("");
    $('#liquidation_date').val("");
    $('#eparticular').val("");
    $('#name').val("");
    $('#position').val("");
    $('#liquidation_id').val("");
    $('#LiquiType').prop('disabled',false);
    $('#btnRouteid').prop('disabled', true);
  }else{

    $('#LiquiType').hide();
    var c = post_Data('controller.pettycash.php?mode=CheckPetty',{
      id: id
    });
    if(c.id!=null){
      $('#liquidation_id').val(c.id);
      $('#labelSubmitted').hide();
      // $('#LiquiType').show();
      $('#LiquiType').val("yes");
      $('#saveType').hide();
      $('#pettycash_id').val(id);
      $('#name').val(c.name);
      $('#liquidation_date').val(c.liquidation_date);
      $('#branch').val(c.branch);
      $('#position').val(c.position);
      $('#eparticular').val(c.particulars);
      $('#Petty_table_div').hide();
      $('#Pettydetails_div').slideDown();
      $('#liquidated_div').show();
      $('#LiquiType').prop('disabled',true);
      var liquidation_id = $('#liquidation_id').val();
      load_PettyCashDetails(liquidation_id);
      $('#btnRouteid').prop('disabled', false);
    }else{

      $('#btnRouteid').prop('disabled', true);
      $('#labelSubmitted').hide();
      // $('#LiquiType').show();
      $('#pettycash_id').val(id);
      $('#Petty_table_div').hide();
      $('#Pettydetails_div').slideDown();
      $('#branch').val(department);
      $('#liquidation_date').val(liquidated_on);
      $('#eparticular').val(particulars);
      $('#name').val("");
      $('#position').val("");
      $('#LiquiType').val("");
      $('#liquidation_id').val("");
      $('#LiquiType').prop('disabled',false);
      var liquidation_id = $('#liquidation_id').val();
      load_PettyCashDetails(liquidation_id);
    }

    
  }

  
  
}

function btn_cancelPetty(){
  $('#Petty_table_div').slideDown();
  $('#Pettydetails_div').hide();
  $('#LiquiType').val("");
  $('#saveType').hide();
  // $('#liquidated_div').hide();
}

function saveType(){
  confirmed("save",saveType_callback,"Do you really want to submit this?", "Yes", "No");
}

function saveType_callback(){

    var LiquiType = $('#LiquiType').val();
    var pettycash_id = $('#pettycash_id').val();
    var actual_amount = $('#super_actual_amount').val();

    var c = post_Data('controller.pettycash.php?mode=Submit',{
      LiquiType: LiquiType,
      pettycash_id: pettycash_id,
      actual_amount: actual_amount
    });

    var email_Approver = "";
    var name_Approver = "";

    if(LiquiType=="yes"){
      email_Approver = $('#email_ApproverWL').val();
      name_Approver = $('#name_ApproverWL').val();
    }else{
      email_Approver = $('#email_Approver').val();
      name_Approver = $('#name_Approver').val();
    }

    toggleLoad();
    window.location.href="tcpdf/examples/pettywliqui_head.php?id="+pettycash_id+"&e="+email_Approver+"&n="+name_Approver;

}

function resendPetty(id){
   toggleLoad();
   window.location.href="tcpdf/examples/pettycashresend.php?id="+id;
}

function openPetty(id){
  window.open("tcpdf/examples/pettycash.php?id="+id);
}

function openLiqui(id){
  window.open("tcpdf/examples/liquidation.php?id="+id);
}

function btnRoute(){

  $('#liquiDetailsID').val("");
  $('#l_from').val("");
  $('#l_to').val("");
  $('#Vehicle_type').val("");
  $('#l_amount').val("");
  $('#LiquidationModal').modal('show');
}

function editRoute(id,l_from,l_to,vehicle_type,amount){

  $('#liquiDetailsID').val(id);
  $('#l_from').val(l_from);
  $('#l_to').val(l_to);
  $('#Vehicle_type').val(vehicle_type);
  $('#l_amount').val(amount);
  $('#LiquidationModal').modal('show');

}
function deleteRoute(id){
  var r = confirm("delete?");
  if(r==true){
    var c = post_Data('controller.pettycash.php?mode=DeleteRoute',{
      id: id
    });
    var liquidation_id = $('#liquidation_id').val();
    load_PettyCashDetails(liquidation_id);
    alert("Successfully Deleted");
  }
}
