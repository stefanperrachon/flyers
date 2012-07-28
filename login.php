<?php
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>member system - login</title>
</head>

<body>

	<?php
	
	if ($username && $userid){
		echo "you are already logged in as <b>$username</b> <a href='member.php'>click here</a> to go to the member page.";
	}
	else{
	
		$form = "<form action='login.php' method='post'>
		<table>
		<tr>
			<td>Username:</td>
			<td><input type='text' name='user'/></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type='password' name='password' /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' name='loginbtn' value='Login' /></td>
		</tr>
		
		<tr>
			<td><a href='register.php'>register</a></td>
			<td><a href='forgotpass.php'>forgot my password</a></td>
		</tr>
		</table>
		</form>";
		
		if ($_POST['loginbtn']){
			$user = $_POST['user'];
			$password = $_POST['password'];
			
			if ($user) {
				if ($password) {
					require("connect.php");
					
					//$password = md5(md5("ikdiImkdik".$password."iidi12E"));
					// make sure login info correct
					
					
			
					$query = mysql_query("SELECT * FROM users WHERE username='$user'");
					$numrows = mysql_num_rows($query);
					if ($numrows == 1) {
						$row = mysql_fetch_assoc($query);
						$dbid = $row['id'];
						$dbuser = $row['username'];
						$dbpass = $row['password'];
						$dbactive = $row['active'];
						
						if($password == $dbpass) {
							if($dbactive == 1){
							
								//set session info
								$_SESSION['userid'] = $dbid;
								$_SESSION['username'] = $dbuser;
								
								echo "you have been logged in as <b>$dbuser</b> <a href='member.php'>click here</a> to go to the member page.";
							}
							else
								echo"you must activate your account to login. $form";
						
						
						}
						else
							echo "you did not enter the correct password. $form";
						
					}
					else
						echo "the username you entered was not found. $form";
					
					
					mysql_close();
				}
				else
					echo "you must enter your password. $form";
			}
			else
				echo "you must enter your username $form";
		}
		else
			echo $form;
		
		}
	?>


</body>

</html>