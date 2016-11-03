<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $_COOKIE['name'] ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="css/facebox.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/start.css">
  <script src="js/facebox.js" type="text/javascript"></script>
</head>
<body>
<script src="js/start.js"></script>
<?php
	include_once "connect.php";
	session_start();
	if(empty($_SESSION["user"]))
		header("location:index.php");
?>
<div id="add">
	<legend>Storage</legend>
	<form method="post" action="space.php" enctype="multipart/form-data">
    	<label for="name">Select file</label>
	    <br><br><input type="file" name="file" /><br>
	    <p id="up"><input type="submit" name="upload" value="Start upload" /></p>
	</form>
	<?php
	    if(isset($_GET['value']))
	    {
	        $val=$_GET['value'];
	        if($val==0)
	        	echo "File uploaded successfully";
	        else if($val==3)
	        	echo "Delete some files to make space";
	        else
	        	echo "File cannot be uploaded";
	    }
	    $us=$_COOKIE['user'];
	    $av=mysqli_query($conn,"select AVAILABLE_MEM from folder_det where EMAIL_ID='$us'")or die(mysqli_error($conn));
	    $row=mysqli_fetch_row($av);
	    echo "<br>Available Memmory :  ".$row[0];
	    echo "<br>Total Memmory     :  500<br>";
	?>
</div>
<div class="container">
  <ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Uploaded Files</a></li>
    <li><a data-toggle="pill" href="#menu1">Shared With Me</a></li>
  </ul>
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3><center>Uploaded Files</center></h3>
      <p><form action="space.php" method="POST">
          <?php
            $us=$_COOKIE['user'];
            include_once "connect.php";
            $sql="SELECT * FROM tbl_uploads where email_id='$us' and owner='$us'";
            $result_set=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result_set)==0)
            {
              echo "<center>Upload Some Files To Show Up Hear</center>";
            }
            else
            {
          ?>
          <table width="100%" border="1">
            <tr>
              <th>Select</th>
              <th>File Name</th>
              <th>File Type</th>
              <th>File Size(MB)</th>
              <th>View</th>
              <th>Share</th>
            </tr>
            <?php
              while($row=mysqli_fetch_array($result_set))
              {
            ?>
              <tr>
                <td><input class='cbox' type="checkbox" name="files[]" id="cbox" value=<?php echo $row['file'] ?>></td>
                <td><?php echo $row['file'] ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo round($row['size'],2) ?></td>
                <td><a href="uploads/<?php echo $row['file'] ?>" target="_blank">view/download file</a></td>
                <td><input type='button' id='share' name='share' value='share' onclick='mail("<?php echo $row['file'] ?>")'></td>
                </tr>
            <?php
              }
            }
            ?>
          </table>
      </p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3><center>Shared With Me</center></h3>
      <p><?php
            $sql="SELECT * FROM tbl_uploads where email_id='$us' and owner!='$us'";
            $result_set=mysqli_query($conn,$sql);
            if(mysqli_num_rows($result_set)===0)
            {
              echo "<center>Ther Is No File To Show Up Hear</center>";
            }
            else
            {
          ?>
          <table width="100%" border="1">
            <tr>
              <th>Select</th>
              <th>File Name</th>
              <th>File Type</th>
              <th>File Size(KB)</th>
              <th>View</th>
              <th>Share</th>
            </tr>
            <?php
              $us=$_COOKIE['user'];
              while($row=mysqli_fetch_array($result_set))
              {
            ?>
              <tr>
                <td><input class='cbox'
                type="checkbox" name="files[]" id="cbox" value=<?php echo $row['file'] ?>></td>
                <td><?php echo $row['file'] ?></td>
                <td><?php echo $row['type'] ?></td>
                <td><?php echo $row['size'] ?></td>
                <td><a href="uploads/<?php echo $row['file'] ?>" target="_blank">view/download file</a></td>
                <td><input type='button' id='share' name='share' value='share' onclick='mail("<?php echo $row['file'] ?>")'></td>
                </tr>
            <?php
              }
             }
            ?>
          </table>
        </p>
    </div>
  </div>
  <br><center><input type="submit" id='bt_submit' name="delete" value="Delete selected"></center>
  </form>
</div>
<div id="ac">Account</div>
    <div id="down">
    	<a rel="facebox" href="change.php">Change Password</a><br>
    	<a href="space.php?val=ch">Logout</a><br>
    	<a href="space.php?val=rm" id="confirmation">Remove my account</a>
</div>
</body>
</html>
