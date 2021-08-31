var errorToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'top','align':'right', 'duration': 4000, 'class': "bg-primary"}

$(document).ready(function(){
            
    $('.content-header').remove();  
    $('#login').on('click',function(){
        var c = post_Data('controller.login.php?mode=login',{
            username: $('#username').val(),
            password: $('#password').val(),
            system_type: $('#system_type').val()
        });
        if(c.status=="FOUND"){
                $('#usertype').val(c.user_type);
                $('#welcome-modal').modal('show');

        }else{

                $.Toast("Invalid Username or Password", errorToast);
        }
                
    });

    $('#welcome-ok').on('click',function(){

        var system_type = $('#system_type').val();
        var usertype = $('#usertype').val();

        if(usertype=="Administrator"){
            window.location.href="index.php";
        }else{
            if(system_type=="petty"){

                if(usertype=="Accounting"){
                    window.location.href="petty_accounting.php";
                }else{
                    window.location.href="pettycash.php";
                }

            }else{

                //  if(usertype=="Purchaser"){
                //     window.location.href="purchasing.php";
                // }else
                if(usertype=="Accounting"){
                    window.location.href="approvedCash.php";
                }else{
                    window.location.href="pr.php";
                }

            }
        }

        

    });
           
});