<?php

if( isset( $_POST[ 'Login' ] ) ) {
	// Check Anti-CSRF token
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );

	// Sanitise username input
	$user = $_POST[ 'username' ];
	$user = stripslashes( $user );
	$user = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

	// Sanitise password input
	$pass = $_POST[ 'password' ];
	$pass = stripslashes( $pass );
	$pass = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $pass ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	$pass = md5( $pass );

//Default values
$total_failed_login = 3;
$lockout_time = 15;
$account_locked = false;


	// Check database
	$data = $db->prepare( "SELECT failed_login, last_login FROM users where user = (:user) LIMIT 1;" );
	$data->bindParam(':user', $user, PDO::PARAM_STR);
	$data->execute();
	$row = $data->fetch();


	if(( $data->rowCount() == 1 ) && ( $row[ 'failed_login' ] >= $total_failed_login ) ) {
		// Get users details
		$last_login    = strtotime( $row[ 'last_login'] );
		$timeout = $last_login + ($lockout_time * 60);
		$timenow = time();

//check to see if enough time has passed, if it hasn't locked the accout
if( $timenow < timeout){
$account_locked = true;
}
}
//check the database
$data = $db->prepare( "SELECT * FROM `users` WHERE user = (:user) AND password = (:password) LIMIT 1;" );
	$data->bindParam(':user', $user, PDO::PARAM_STR);
	$data->bindParam(':password', $pass, PDO::PARAM_STR);
	$data->execute();
	$row = $data->fetch();

if(( $data->rowCount() == 1 ) && ( $account_locked == false ) ) {

//get users details
$avatar = $row[ 'avatar' ];
$failed_login = $row[ 'failed_login' ];
$last_login = $row[ 'last_login' ];


		// Login successful
		echo "<p>Welcome to the password protected area {$user}</p>";
		echo "<img src=\"{$avatar}\" />";
	}
	else {
		// Had account been locked out
		if($failed_login >= $total_failed_login) {
		echo "<p><em>Warning</em>: Someone might of been brute forcing your account.</p>";
            	echo "<p>Number of login attempts: <em>{$failed_login}</em>.<br />Last login attempt was at: <em>${last_login}</em>.</p>"; 
}

//reset bad login count
$data = $db->prepare( "UPDATE users SET failed_login = "3" WHERE user = (:user) LIMIT 1;" );
$data->bindParam( ':user', $user, PDO::PARAM_STR );
$data->execute();
} else {
		//login failed
		sleep( rand( 3, 3 ) );
		echo "<pre><br /><br />Username and/or password incorrect.<br /><br/> The account has been locked because of too many failed logins.<br />please try again in {$lockout_time}minutes</pre>";
		
		//update bad login count
		$data = $db->prepare( "UPDATE users SET failed_login = (failed_login + 1) where user = (:user) LIMIT 1;" );
		$data->bindParam( ':user', $user, PDO::PARAM_STR);
		$data->execute();
}

// set the last login time
$data = $db->prepare( "UPDATE users SET last_login = now() where user = (:user) LIMIT 1;");
$data->bindParam( ':user', $user, PDO::PARAM_STR);
$data->execute();	
}

// Generate Anti-CSRF token
generateSessionToken();

?>
