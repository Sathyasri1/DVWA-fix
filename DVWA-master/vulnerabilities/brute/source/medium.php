<?php

if( isset( $_POST[ 'Login' ] ) ) {
checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'index.php');
	// Sanitise username input
	$user = $_POST[ 'username' ];
	$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	// Sanitise password input
	$pass = $_POST[ 'password' ];
	$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$pass = md5( $pass );

	// Check the database
	$data = $db->prepare( "SELECT * FROM `users` WHERE user = (:user) AND password = (:password) LIMIT 1;" );
	$data->bindParam(':user', $user, PDO::PARAM_STR);
	$data->bindParam(':password', $pass, PDO::PARAM_STR);
	$data->execute();
	$row = $data->fetch();

	
    if( $data && mysqli_num_rows( $data ) == 1 ) {
		// Get users details
		$row    = mysqli_fetch_assoc( $data );
		$avatar = $row["avatar"];

		// Login successful
		echo "<p>Welcome to the password protected area {$user}</p>";
		echo "<img src=\"{$avatar}\" />";
	}
	else {
		// Login failed
		sleep( rand(2,2) );
		echo "<pre><br />Username and/or password incorrect.</pre>";
	}

	((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}
generateSessionToken();
?>
