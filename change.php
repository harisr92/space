<html>
<script>
function validateForm()
{
var x=document.forms["ch"]["old"].value;
var x1=document.forms["ch"]["new1"].value;
var x2=document.forms["ch"]["new2"].value;
if (x==null || x=="")
  {
  if(x1==null || x=="")
  	if(x2==null || x2=="")
  	{
  	alert("All field must be entered");
  	return false;
  	}
	}
}
</script>
<body>
<?php
	session_start();
	include_once "connect.php";
	if(!$conn)
		die(mysqli_connect_error());
	if(isset($_POST['change']))
	{
		if($_SESSION['user']!="")
		{
			$email=$_SESSION['user'];
			$o=$_POST['old'];
			$n=$_POST['new1'];
			$ch=mysqli_query($conn,"update USER_LOGIN set PASSWORD='$n' where EMAIL_ID='$email'");
			if(!$ch)
				echo "Error". mysqli_connect_error();
			header("Location:start.php");
		}
	}
?>
<form action="change.php" name="ch" method="POST" onsubmit="return validateForm()">

	Current Password<br>
	<input type="password" name="old">
	<br>New Password<br>
	<input type="password" name="new1">
	<br>Conferm Password<br>
	<input type="password" name="new2"><br>
	<input type="submit" name="change" value="pass">
</form>
</body>
<html>
