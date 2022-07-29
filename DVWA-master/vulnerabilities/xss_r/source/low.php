<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {


//Get input
$name= htmlspecialchars( $_GET[ 'name' ] );  //this function will convert special characters to HTML entity

// Feedback for end user
    echo "<pre>Hello ${name}</pre>";
}


?> 
