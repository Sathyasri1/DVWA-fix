<?php

// The page we wish to display
$file = $_GET[ 'page' ];

//checking the condition if it is include.php or file{1,2,3} only it will allow
if( $file != "include.php" && $file != "file1.php" && $file != "file2.php" ){

echo " Error: File Not Found ";
}
exit;
?>
