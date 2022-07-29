<?php

if( isset( $_POST[ 'Login' ] ) ) {
checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'index.php');
	// Get username
	$user = $_POST[ 'username' ];

	// Get password
	$pass = $_POST[ 'password' ];
	$pass = md5( $pass );

	// Check the database
	$query  = "SELECT * FROM `users` WHERE user = '$user' AND password = '$pass';";
	$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );

	if( $result && mysqli_num_rows( $result ) == 1 ) {
		// Get users details
		$row    = mysqli_fetch_assoc( $result );
		$avatar = $row["avatar"];

		// Login successful
		echo "<p>Welcome to the password protected area {$user}</p>";
		echo "<img src=\"{$avatar}\" />";
	}
	else {
		// Login failed
		sleep(3);
		echo "<pre><br />Username and/or password incorrect.</pre>";
	}

	((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
}
generateSessionToken();
?>
