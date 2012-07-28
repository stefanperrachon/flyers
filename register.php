<?php
error_reporting (E_ALL ^ E_NOTICE);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>member system - register</title>
</head>

<body>
<?php


if ($_POST ['registerbtn']){
	$getuser = $_POST['user'];
	$getemail = $_POST['email'];
	$getpass = $_POST['pass'];
	$getretypepass= $_POST['retypepass'];
		
		if($getuser){
			if ($getemail){
				if ($getpass){
					if ($getretypepass){
						if ($getpass === $getretypepass){
							if ( (strlen($getemail) >= 7) && (strstr($getemail, "@"))  &&(strstr($getemail, "."))  ){
								require("./connect.php");
								
								$query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
								$numrows = mysql_num_rows($query);
								if ($numrows == 0){
									$query = mysql_query("SELECT * FROM users WHERE email='$getemail'");
									$numrows = mysql_num_rows($query);
										if ($numrows == 0){
											
											$password = $getpass;
											$date = date("F d, Y");
											$code = md5(rand());
											
											mysql_query("INSERT INTO users VALUES (
												'', '$getuser', '$password', '$getemail', '0', '$code', '$date'
											)");
											
												$query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
												$numrows = mysql_num_rows($query);
												if ($numrows == 1){
													
														$site = "http://localhost/flyer";
														$webmaster = "admin flyer <stefanperrachon@yahoo.com>";
														$headers = "From: $webmaster";
														$subject = "activate your account";
														$message = "Thanks for registering. click the link below to activate your account.\n";
														$message .= "$site/activate.php?user=$getuser&code=$code\n";
														$message .= "you must activate your account to login.";
														
														if ( mail($getemail, $subject, $message, $headers) ) {
															$errormsg = "you have been registered. you must activate your accout  from the acitvation link sent to <b<$getemail</b>.";
															$getuser = "";
															$getemail = "";
														
														}
														else
															$errormsg = "an error has occured. your activation email not sent.";
														
												
												}
										       else
											       $errormsg = "an error has occured. your account was not created.";
								
										}
										else
											$errormsg = "there is already a user that email.";
								
								}
								else
									$errormsg = "there is already a user that username.";
								
								mysql_close();
							}
							else
								$errormsg = "you must enter a vaild email address to register.";
						
						}
						else
							$errormsg = "your passwords did not match.";
			
			}
			else	
				$errormsg = "you must retype your password to register.";
			
			}
			else	
				$errormsg = "you must enter your password to register.";
			
			}
			else	
				$errormsg = "you must enter your email to register.";
		
		}
		else
			$errormsg = "you must enter your username to register.";
}
 


$form = "<form action='./register.php' method='post'>
<table>
<tr>
	<td></td>
	<td><font color='red'>$errormsg</font></td>
</tr>
<tr>
	<td>username:</td>
	<td><input type='text' name='user' value='$getuser'/></td>
</tr>
<tr>
	<td>email:</td>
	<td><input type='text' name='email' value='$getemail'/></td>
</tr>
<tr>
	<td>password:</td>
	<td><input type='password' name='pass' value=''/></td>
</tr>
<tr>
	<td>retype:</td>
	<td><input type='password' name='retypepass' value=''/></td>
</tr>
<tr>
	<td></td>
	<td><input type='submit' name='registerbtn' value='register'/></td>
</tr>
</table>
</form>";

echo $form;


?>



</body>

</html>