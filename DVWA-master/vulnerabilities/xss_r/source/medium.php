<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {

	$name = htmlspecialchars( $_GET[ 'name' ] );

	// Feedback for end user
	echo "<pre>Hello ${name}</pre>";
}

?>
