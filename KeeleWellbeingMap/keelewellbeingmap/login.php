<?php
	session_start();
	
	// Retrieve login credentials from CSV file
	if (($handle = fopen("users.csv","r"))!== FALSE){
		while (($data = fgetcsv($handle, 1000, ","))!== FALSE){
			$users [$data[0]] = array("password" => $data[1]);
		}
		fclose($handle);
	}

	$u = $_POST['username'];
	$p = $_POST['password'];

	if (isset($users[$u]) and $users[$u]['password'] == $p){
		$_SESSION['loggedin'] = TRUE;
		echo "true";
	} else {
		echo "false";
	}
?>
