<?php
			 if($_POST)
			{
			 $con = mysql_connect("localhost","root","");

				if (!$con)
				{
					die('Could not connect: ' . mysql_error());
				}

				mysql_select_db("kishaan", $con);

				$users_login = $_POST['login'];			
				$login=$_POST['password'];
				print($users_login);
				$query = "INSERT INTO `kishaan` (`username`, `password`) VALUES ('$users_login','$login');";
  mysql_query($query);
  mysql_close($con);
header("Location: registration.html");
			}
			else{
				echo "error";
				}
		?>
        