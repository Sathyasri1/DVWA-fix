<?php

if( isset( $_POST[ 'Submit' ] ) ) {
	// Check Anti-CSRF token
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'index.php' ); //change
	// Get input
	$id = $_POST[ 'id' ];

	// Was a number entered?
	if(is_numeric( $id ) == true) { //change
		$id = intval ($id);

	switch ($_DVWA['SQLI_DB']) {
		case MYSQL:
			// Check database
			/*$query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id' LIMIT 1;";
			$result = mysqli_query($GLOBALS["___mysqli_ston"],  $query ) or die( '<pre>' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) . '</pre>' );*/
			$data = $db->prepare( 'SELECT first_name, last_name FROM users WHERE user_id = (:id) LIMIT 1;' ); //change
			$data->bindParam( ':id', $id, PDO::PARAM_INT );
			$data->execute();
			$row = $data->fetch();

			// Get results
			//while( $row = mysqli_fetch_assoc( $result ) ) 
			if( $data->rowCount() == 1 ){
				// Get values
				$first = $row["first_name"];
				$last  = $row["last_name"];

				// Feedback for end user
				echo "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
			}

			//mysqli_close($GLOBALS["___mysqli_ston"]);
			break;
		case SQLITE:
			global $sqlite_db_connection;

			#$sqlite_db_connection = new SQLite3($_DVWA['SQLITE_DB']);
			#$sqlite_db_connection->enableExceptions(true);

			//$query  = "SELECT first_name, last_name FROM users WHERE user_id = '$id';";
			$stmt = $sqlite_db_connection->prepare('SELECT first_name, last_name FROM users WHERE user_id = :id LIMIT 1;' ); //change
			$stmt->bindValue(':id',$id,SQLITE3_INTEGER);
			$result = $stmt->execute();
			$result->finalize();
			#print $query;
			/*try {
				$results = $sqlite_db_connection->query($query);
			} catch (Exception $e) {
				echo 'Caught exception: ' . $e->getMessage();
				exit();
			}*/

			if ($results !== false) {
				//while ($row = $results->fetchArray()) 
				$num_columns = $result->numColumns();
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
 else {
	echo "Invalid User Id";
}
}
//Generate Anti-CSRF Token
generateSessionToken(); //change
?>
