jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'img/loading.gif',
        closeImage   : 'img/closelabel.png'
      })
    })
$(document).ready(function() { 
     
    $('#bt_submit').attr("disabled",true);
     
      $('.cbox').change(function() {
        $('#bt_submit').attr('disabled', $('.cbox:checked').length == 0);
    });
     
  });
  function mail(fi)
    {
      var email = prompt("Please enter email_id", "");
       if (email != null) {
        window.location.href ="space.php?email="+email+"&fi="+fi;
       }
    }
    if($("#down").slideUp())
		$(document).ready(function(){
		    $("#ac").click(function(){
		        $("#down").slideDown("slow");
		    });
		});
		$(document).ready(function(){
		    $("#down").click(function(){
		        $("#down").slideUp("slow");
		    });
		});
		$(document).ready(function(){
				$('#confirmation').click(function () {
		        return confirm('Are you sure?');
		    });
		  });

function validateForm()
{
var x=document.forms["myform"]["user"].value;
if (x==null || x=="")
  {
  alert("Email id must be filled out");
  return false;
  }
  
var x=document.forms["myform"]["password"].value;
if (x==null || x=="")
  {
  alert("Password must be filled out");
  return false;
  }
}
function checkEmail() 
{
    var email = document.forms["save"]["email"];
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    alert('Please provide a valid email address');
    email.focus;
    return false;
  }
  validateSign();
}
function validateSign()
{
  var x=document.forms["save"]["email"].value;
  if (x==null || x=="")
  {
    alert("Invalid Email ID");
    return false;
  }
  
  var x=document.forms["save"]["name"].value;
  if (x==null || x=="")
  {
    alert("Name must be filled out");
    return false;
  }
  var x=document.forms["save"]["place"].value;
  if (x==null || x=="")
  {
    alert("Place must be filled out");
    return false;
  }
  var x=document.forms["save"]["city"].value;
  if (x==null || x=="")
  {
    alert("City must be filled out");
    return false;
  }
  var x=document.forms["save"]["job"].value;
  if (x==null || x=="Select Job")
  {
    alert("Select a Job");
    return false;
  }
  var x=document.forms["save"]["pass1"].value;
  if (x==null || x=="Select Job")
  {
    alert("Provide password");
    return false;
  }
  var x2=document.forms["save"]["pass2"].value;
  if (x2==null || x2=="Select Job")
  {
    alert("Please Confirm password");
    return false;
  }
  if(x!=x2)
  {
    alert("Password donot match!");
    return false;
  }
}