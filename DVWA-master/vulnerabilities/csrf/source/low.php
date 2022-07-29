<?php

if( isset( $_GET[ 'Change' ] ) ) {
checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'index.php');
	// Get input
	$pass_new  = $_POST[ 'password_new' ];
	$pass_conf = $_POST[ 'password_conf' ];

	// Do the passwords match?
	if( $pass_new == $pass_conf ){
		$pass_new = stripslashes($pass_new);		
		$pass_new = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass_new ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
		$pass_new = md5($pass_new);

		// Update the database
		$data = db->prepare('UPDATE users SET password = (:password) WHERE user = (:user);');
		$data->bindParam(':password', $pass_new, PDO::PARAM_STR);
		$data->bindParam(':user', dvwaCurrentUser(), PDO::PARAM_STR);
		$data->execute();
		// Feedback for the user
		echo "<pre>Password Changed.</pre>";
	}
	else {
		// Issue with passwords matching
		echo "<pre>Passwords did not match.</pre>";
	}

	
}
generateSessionToken();
?>