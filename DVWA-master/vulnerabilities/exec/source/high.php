<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );
	// Get input
	$target = $_POST[ 'ip' ];
	$target = stripslashes( $target );
	
	// To split the IP into 4 octects
	$octet = explode( ".", $target );

//checking each octet is integer
if( ( is_numeric( $octet[0] ) ) && ( is_numeric( $octet[1] ) ) && ( is_numeric( $octet[2] ) ) && ( is_numeric( $octet[3] ) ) ) {

	//if the given input is integer then put it together
	$target = $octet[0] . '.' . $octet[1] . '.' . $octet[2] . '.' . $octet[3];


	// Determine OS and execute the ping command.
	if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
		// Windows
		$cmd = shell_exec( 'ping  ' . $target );
	}
	else {
		// *nix
		$cmd = shell_exec( 'ping  -c 4 ' . $target );
	}

	// Feedback for the end user
	echo "<pre>{$cmd}</pre>";
} else {

echo "<pre> Error: Entered Invalid IP. </pre>";
}
}
generateSessionToken();
?>
