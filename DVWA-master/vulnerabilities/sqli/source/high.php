<?php

if( isset( $_POST [ 'Submit' ] ) ) { //change

	// Check Anti-CSRF token
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' ); //change

	// Get input
	$id = $_POST[ 'id' ];  //change
	
	if(is_numeric( $id ) == true){    //change
		$id = intval ($id);
	switch ($_DVWA['SQLI_DB']) {
		case MYSQL:
			// Check database
			/* $query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id' LIMIT 1;";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query ) or die( '<pre>Something went wrong.</pre>' ); */
			$data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' ); //change
			$data->bindParam( ':id', $id, PDO::PARAM_INT );
			$data->execute();
			$row = $data->fetch();


			// Get results
			//while( $row = mysqli_fetch_assoc( $result ) ) 
			if( $data->rowCount() == 1 ) {  //change
				// Get values
				$first = $row["first_name"];
				$last  = $row["last_name"];

				// Feedback for end user
				$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
			}

			//((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);		
			break;
		case SQLITE:
			global $sqlite_db_connection;

			//$query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id' LIMIT 1;";
			$stmt = $sqlite_db_connection->prepare('SELECT first_name, last_name FROM users WHERE user_id = :id LIMIT 1;' ); //change
			$stmt->bindValue(':id',$id,SQLITE3_INTEGER);
			$result = $stmt->execute();
			$result->finalize();

			#print $query;
			/* try {
				$results = $sqlite_db_connection->query($query);
			} catch (Exception $e) {
				echo 'Caught exception: ' . $e->getMessage();
				exit();
			} */

			//if ($results) 
			if ($result !== false){  //change

				//while ($row = $results->fetchArray()) 
				$num_columns = $result->numColumns();  //change
					if ($num_columns == 2) {
						$row = $result->fetchArray();
					// Get values
					$first = $row["first_name"];
					$last  = $row["last_name"];

					// Feedback for end user
					$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
				}
			} /*else {
				echo "Error in fetch ".$sqlite_db->lastErrorMsg();
			}*/
			break;
	}
} 
else{
	echo "Invalid User Id"; //change
}
}

//Generate Anti-CSRF Token
generateSessionToken(); //change
?>
