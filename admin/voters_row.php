<?php 
	// include 'includes/session.php';

	// if(isset($_POST['id'])){
	// 	$id = $_POST['id'];
	// 	$sql = "SELECT *,
	// 			years.description AS year_des,
	// 			course.description AS course_des 
	// 			FROM voters 
	// 			JOIN years ON years.id = voters.year 
	// 			JOIN course ON course.id = voters.course 
	// 			WHERE id = '$id'";
	// 	$query = $conn->query($sql);
	// 	$row = $query->fetch_assoc();

	// 	echo json_encode($row);
	// }

	
	
	include 'includes/session.php';

	if (isset($_POST['id'])) {
		$id = $_POST['id'];

		// Prepare the SQL query
		$sql = "SELECT voters.*, 
				years.description AS year_des, 
				course.description AS course_des 
				FROM voters 
				JOIN years ON years.id = voters.year 
				JOIN course ON course.id = voters.course 
				WHERE voters.id = ?";

		// Prepare and execute the statement
		if ($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				echo json_encode($row);
			} else {
				// Handle the case where no results are found
				echo json_encode(["error" => "No records found for the given ID."]);
			}
		} else {
			// Handle errors with the prepared statement
			echo json_encode(["error" => "Failed to prepare SQL statement."]);
		}

		$stmt->close();
	} else {
		// Handle the case where ID is not set in the POST request
		echo json_encode(["error" => "ID not set in POST request."]);
	}

	



?>