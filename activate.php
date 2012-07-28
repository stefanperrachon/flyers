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
	<title>member system - activate</title>
</head>

<body>
	
	
	<?php
		
		$getuser = $_GET['user'];
		$getcode = $_GET['code'];
		

		
		if ( $_POST['activatebtn'] ) {
			$getuser = $_POST['user'];
			$getcode = $_POST['code'];
			
			if ($getuser){
				if ($getcode){
					require("./connect.php");
					
					$query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
					$numrows = mysql_num_rows($query);
					if ($numrows == 1) {
						$row = mysql_fetch_assoc($query);
						$dbcode = $row['code'];
						$dbactive = $row['active'];
						
						if ($dbactive == 0){
							if ($dbcode == $getcode){
								mysql_query("UPDATE users SET active='1' WHERE username='$getuser'");
								$query = mysql_query("SELECT * FROM users WHERE username='$getuser' AND active='1'");
								$numrows = mysql_num_rows($query);
								if ($numrows == 1){
									$errormsg = "account has been activated. please login";
									$getuser = "";
									$getcode = "";
									
									
								
								}
								else
									$errormsg = "error occured. accoutn not actived.";
							
							}
							else
								$errormsg = "code is incorrect.";
								
						
						}
						else
							$errormsg = "account is already active.";
						
					
					}
					else
						$errormsg = "username not found.";
						
					mysql_close();
			
			}
			else
				$errormsg = "you must enter your code.";
			
			}
			else
				$errormsg = "you must enter your username.";
		
		}
		else
			$errormsg = "";
		
		echo "<form action='activate.php' method='post'>
		<table>
		<tr>
			<td></td>
			<td>$errormsg</td>
		</tr>
		<tr>
			<td>username:</td>
			<td><input type='text' name='user' value='$getuser' /></td>
		</tr>
		<tr>
			<td>code:</td>
			<td><input type='text' name='code' value='$getcode' /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type='submit' name='activatebtn' value='Activate' /></td>
		</tr>
		</table>
		</form>";
		
	
	
	?>


</body>
</html>