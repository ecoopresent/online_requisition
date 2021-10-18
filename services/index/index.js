var errorToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-danger"}
var successToast = {'position':'bottom','align':'left', 'duration': 4000, 'class': "bg-success"}
$(document).ready(function(){

    $('#logout').on('click', function(){
      confirmed("save",logout_callback, "Do you really want to log-out?", "Yes", "No");
    });

      $('textarea').on('keyup keypress keydown', function(e) {

        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          alert("Enter key is not valid");
          return false;
        }else if(keyCode === 222 || keyCode === 220 || keyCode === 186) {
          e.preventDefault();
          alert("Special character you've input is not valid");
          return false;
        }

      });

      $('textarea').on('paste', function(e){
        e.preventDefault();
        alert("Paste is not valid");
        return false;
      })

      $('input[type=text]').on('paste', function(e){
        e.preventDefault();
        alert("Paste is not valid");
        return false;
      })


      $('input[type=text]').on('keyup keypress keydown', function(e) {
        
        var keyCode = e.keyCode || e.which;
        if(keyCode === 222 || keyCode === 220 || keyCode === 186) {
          e.preventDefault();
          alert("Special character you've input is not valid");
          return false;
        }

      });

    $('#menu_button').on('click',function(){
        $('.sidebar').slideToggle();
    })

           
});

function logout_callback(){
  window.location.href="logout.php";
}