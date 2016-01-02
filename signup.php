<html>
<script src="js/start.js"></script>
<body>
<form action="space.php" method="POST" name="save" onsubmit="return checkEmail()">
<center><table>
<tr><td>Email ID </td><td><input type="text" value="" name="email"></td></tr>
<tr><td>Full name</td><td><input type="text" name="name"></td></tr>
<tr><td>Place </td><td><input type="text" name="place"></td></tr>
<tr><td>City</td><td><input type="text" name="city"></td></tr>
<tr><td>Job</td><td><select name="job">
		<option>Select Job</option>
		<option value="Student">Student</option>
		<option value="IT">IT</option>
		<option vaue="Business">Business</option>
		<option vaue="Designer">Designer</option>
		<option vaue="Architecture">Architecture</option>
	</select></td></tr>
<tr><td>Password</td><td><input type="password" name="pass1" value=""></td></tr>
<tr><td>Confirm Password</td><td><input type="password" name="pass2"></td></tr>
</table>
<input type="submit" value="SignUp" name="signup" rel="facebox">
</body></html>
