<?php
session_start(); 

include 'connection.php';

$newidnum = $_POST['idnum'];
$newpasswords = $_POST['passwords']; 



$sql = "SELECT * FROM users as s WHERE s.idnum = '$newidnum' AND s.passwords='$newpasswords' AND s.usertype='volnteer'";
$result = sqlsrv_query( $conn , $sql, array(), array("Scrollable" => 'static'));
$my_array = sqlsrv_fetch_array($result); //key:value [username:'u1']

$actual_idnum = $my_array["idnum"];
	$actual_passwords = $my_array["passwords"];


	if(sqlsrv_num_rows($result) == 1){ // If query returned 1 row exactly => There is a user with the entered ID 
	
		
		if(isset($_POST["idnum"])&& isset($_POST["passwords"])) { // If username and password is checked
	
			// Actual authentication
			if($actual_idnum==$newidnum && $actual_passwords==$newpasswords){ // If the actual id and password are suitable to the enetered id and password
				
				session_destroy(); // Destroy previous session
				session_start(); // Start a new session


				$sql = "INSERT INTO signin (idnum,passwords) VALUES ( '$newidnum,'$newpasswords);";
				$params = array( $newidnum,$newpasswords);
				$options =  array('Scrollable' => SQLSRV_CURSOR_FORWARD);
				$result = sqlsrv_query( $conn , $sql, $params, $options);

				// If query is successfull 
				if( $sql ) {
					sqlsrv_commit( $conn );
				}
                // Redirect to "customer_page.pnp"
				echo "<script> window.open('home.html', '_self');</script>";

			}
			else{ // The actual id and password are NOT identical to the enetered id and password
				

				session_start(); // Start a new session
				header('location:notsucsesspage1.html'); // Redirect to "customer_page.pnp" with failure message

			}

		}

	}
	else{ // If query returned no rows =? There is no user registered with the given ID at all 
		header('location:notsucsesspage1.html'); // Redirect to "customer_page.pnp" with failure message
	}
?>
