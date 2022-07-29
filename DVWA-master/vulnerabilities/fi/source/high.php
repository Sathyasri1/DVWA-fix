<?php

// The page we wish to display
$file = $_GET[ 'page' ];

// Input validation
if( $file != "include.php" && $file != "file1.php" && $file != "file2.php" && $file != "file2.php" ) {
	// This isn't the page we want!
	echo "ERROR: File not found!";
	exit;
}

?>
