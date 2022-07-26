<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' );    // creating CSRF token

//Get input
$name= htmlspecialchars( $_GET[ 'name' ] );  //this function will convert special characters to HTML entity

// Feedback for end user
    echo "<pre>Hello ${name}</pre>";
}

generateSessionToken(); // generate CSRF token

?> 
