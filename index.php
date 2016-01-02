<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Space-An online file storage</title>
<link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/facebox.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/start.css">
</head>
<script src="js/start.js"></script>
<body id='index'>
<div id="page-wrap">
<form action="space.php" name="myform" method="post" onsubmit="return validateForm()">
<table width="364" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <td width="97" height="42"><div align="right">EmailID:</div></td>
  <td width="261"><input name="user" type="text" class="txtuser" /></td>
  </tr>
  <tr>
  <td height="37"><div align="right">Password:</div></td>
  <td><input name="password" type="password" class="txtpassword" /></td>
  </tr>
  <tr>
  <td height="20">&nbsp;</td>
  <td>not yet a member? register <a rel="facebox" href="signup.php">here</a></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input name="signin" type="submit" value="login" class="loginbut" /></td>
  </tr>
</table>
	<?php
    session_start();
    if(!empty($_SESSION['user']))
    {
        header("Location:start.php");
    }
		if(isset($_GET['value']))
		{
			$val=$_GET['value'];
			if($val==0)
				echo '<center><p class="error">Invalid email_id or password</p></center>';
			else if($val==1)
				echo '<center><p class="error">Email ID already exist</p></center>';
			else if($val==2)
				echo '<center><p class="error">You are successfully registered</p></center>';
		}
	?>
</form>
</div>
</body>
</html>
