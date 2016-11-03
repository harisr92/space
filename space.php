<html>
<?php
	include_once "connect.php";
	if(!$conn)
		die(mysqli_connect_error());
	if(isset($_POST['signin']))
	{
		$user=$_POST['user'];
		$pass=$_POST['password'];
		$pass1='';
		$auth=mysqli_query($conn,"select password from user_login where EMAIL_ID='$user'");
		foreach($auth as $sub)
			foreach($sub as $s)
				$pass1=$s;
		if($pass==$pass1)
		{
			session_start();
			$_SESSION["user"]=$user;
			setcookie("user","$user");
			$name=mysqli_query($conn,"select USER_NAME from user_det where EMAIL_ID='$user'")or die(mysqli_error($conn));
			foreach($name as $na)
				foreach($na as $n)
					$us=$n;
			setcookie("name","$us");
			$query="update user_login set LAST_LOGIN=CURRENT_TIMESTAMP where EMAIL_ID='$user'";
			$fo=mysqli_query($conn,$query);
			if(!$fo)
			{
				die(mysqli_connect_error());
			}
			header("Location:start.php");
		}
		else
		{
			header("Location:index.php?value=0");
		}
	}
	else if(isset($_POST['signup']))
	{
		$email=$_POST['email'];
		$name=$_POST['name'];
		$place=$_POST['place'];
		$city=$_POST['city'];
		$job=$_POST['job'];
		$pass=$_POST['pass1'];
		if($email=='' || empty($name))
		{
			header("Location:index.php?value=3");
			die();
		}
		else if( empty($place)|| empty($city) )
		{
			header("Location:index.php?value=3");
			die();
		}
		else if($job=='Select Job' || empty($pass))
		{
			header("Location:index.php?value=3");
			die();
		}
		else if($pass!=$_POST['pass2'])
		{
			header("Location:index.php?value=3");
			die();
		}
		$save=mysqli_query($conn,"insert into user_det values('$email','$name','$place','$city','$job')")or die(header("Location:index.php?value=2"));
		$save2=mysqli_query($conn,"insert into user_login(EMAIL_ID,PASSWORD) values('$email','$pass')")or die(header("Location:index.php?value=2"));
		$folder=mysqli_query($conn,"insert into folder_det values('$email','500','500','uploads')")or die(header("Location:index.php?value=2"));
		header("Location:index.php?value=2");
	}
	else if(isset($_POST['upload']))
	{
		$user=$_COOKIE['user'];
		$file = rand(1000,100000)."-".$_FILES['file']['name'];
	  $file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$file_type = $_FILES['file']['type'];
		$folder="uploads/";
		$new_size = $file_size/(1024*1024);
		$new_file_name = strtolower($file);

		$final_file=str_replace(' ','-',$new_file_name);

		if(move_uploaded_file($file_loc,$folder.$final_file))
		{
			$sql="INSERT INTO tbl_uploads(email_id,file,type,size,owner) VALUES('$user','$final_file','$file_type','$new_size','$user')";
			$rs=mysqli_query($conn,$sql)or die(mysqli_error($conn));
			$em=$_COOKIE['user'];
			$avail=mysqli_query($conn,"select AVAILABLE_MEM from folder_det where EMAIL_ID='$em'")or die(mysqli_error($conn));
			foreach($avail as $a)
				foreach($a as $b)
					$as=$b;
			$size=$as-$new_size;
			$fo=mysqli_query($conn,"update folder_det set AVAILABLE_MEM='$size' where EMAIL_ID='$em'")or die(mysqli_error($conn));
			?>
			<script>
			alert('successfully uploaded');
		window.location.href='start.php?success';
		</script>
			<?php
		}
		else
		{
			?>
			<script>
			alert('error while uploading file');
		window.location.href='start.php?fail';
		</script>
			<?php
		}
	}
	else  if(isset($_GET['val']))
	{
		session_start();
		$val=$_GET['val'];
		if($val=='ch')
		{
			$user=$_SESSION['user'];
			$query="update user_login set LAST_LOGOUT=CURRENT_TIMESTAMP where EMAIL_ID='$user'";
			$fo=mysqli_query($conn,$query);
			session_destroy();
			unset($_COOKIE['user']);
			unset($_COOKIE['name']);
		}
		else if($val=='rm')
		{
			$em=$_COOKIE['user'];
			$s=mysqli_query($conn,"select file from tbl_uploads where email_id='$em'")or die(mysqli_error($conn));
			while($row=mysqli_fetch_row($s))
			{
				$nw="uploads/".$row[0];
				unlink($nw);
			}
			session_destroy();
			unset($_COOKIE['user']);
			unset($_COOKIE['name']);
			$rm=mysqli_query($conn,"delete from folder_det where EMAIL_ID='$em'") or die(mysqli_error($conn));
			$rm=mysqli_query($conn,"delete from user_det where EMAIL_ID='$em'") or die(mysqli_error($conn));
			$rm=mysqli_query($conn,"delete from user_login where EMAIL_ID='$em'") or die(mysqli_error($conn));
			$del=mysqli_query($conn,"delete from tbl_uploads where owner='$em'")or die(mysqli_error($conn));
		}
		header("Location:index.php");
	}
	else if(isset($_POST['delete']))
	{
		$em=$_COOKIE['user'];
		$avail=mysqli_query($conn,"select AVAILABLE_MEM from folder_det where EMAIL_ID='$em'")or die(mysqli_error($conn));
		foreach($avail as $a)
			foreach($a as $b)
				$as=$b;
		$size=0;
		foreach($_POST['files'] as $fi)
		{
			$nw="uploads/".$fi;
			$s=mysqli_query($conn,"select size,owner from tbl_uploads where file='$fi'")or die(mysqli_error($conn));
			$row=mysqli_fetch_row($s);
			$size=$size+$row[0];
			if($row[1]==$em)
			{
				unlink($nw);
				$del=mysqli_query($conn,"delete from tbl_uploads where file='$fi'")or die(mysqli_error($conn));
				$as=$as+$size;
				$s=mysqli_query($conn,"update folder_det set AVAILABLE_MEM='$as' where EMAIL_ID='$em'") or die(mysqli_error($conn));
			}
			else
				$del=mysqli_query($conn,"delete from tbl_uploads where file='$fi' and email_id='$em'")or die(mysqli_error($conn));
		}
		?>
		<script>
			alert('successfully deleted');
			window.location.href='start.php';
		</script>
		<?php
	}
	else  if(isset($_GET['email']) && isset($_GET['fi']))
	{
		$file=$_GET['fi'];
		$id=$_GET['email'];
		$ow=$_COOKIE['user'];
		$sq=mysqli_query($conn,"select * from user_det where EMAIL_ID='$id'")or die(mysqli_error($conn));
		if(mysqli_num_rows($sq)==0)
		{
		?>
			<script>
			alert('Email_Id not found');
			window.location.href='start.php';
			</script>
		<?php
			die();
		}
		$ret=mysqli_query($conn,"select * from tbl_uploads where file='$file'")or die(mysqli_error($conn));
		$row=mysqli_fetch_row($ret);
		$sql="INSERT INTO tbl_uploads(email_id,file,type,size,owner) VALUES('$id','$file','$row[3]','$row[4]','$ow')";
		$ch=mysqli_query($conn,$sql)or die(mysqli_error($conn));
		?>
		<script>
			alert('file shared');
			window.location.href='start.php?success=0';
		</script>
		<?php
	}
?>
