<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['vote'])){
		if(count($_POST) == 1){
			$_SESSION['error'][] = 'Please vote for at least one candidate';
		} else {
			$_SESSION['post'] = $_POST;
			$posstmnt = $conn->prepare("SELECT * FROM positions");
			$posstmnt->execute();
			$query = $posstmnt->get_result();
			$error = false;
			$sql_array = array();

			while($row = $query->fetch_assoc()){
				$position = slugify($row['description']);
				$pos_id = $row['id'];

				if(isset($_POST[$position])){
					// Handle multiple vote case
					if($row['max_vote'] > 1){
						if(count($_POST[$position]) > $row['max_vote']){
							$error = true;
							$_SESSION['error'][] = 'You can only choose '.$row['max_vote'].' candidates for '.$row['description'];
						} else {
							foreach($_POST[$position] as $key => $values){
								// Check for "Prefer Not to Vote"
								if (strpos($values, 'not-vote-') !== false) {
									$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', 0, '$pos_id')";
								} else {
									$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$values', '$pos_id')";
								}
							}
						}
					} else {
						$candidate = $_POST[$position];
						if (strpos($candidate, 'not-vote-') !== false) {
							$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', 0, '$pos_id')";
						} else {
							$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$candidate', '$pos_id')";
						}
					}
				}
			}

			if(!$error){
				foreach($sql_array as $sql_row){
					$conn->query($sql_row);
				}
				$conn->query("UPDATE voters SET voted = true WHERE id='".$voter['id']."'");
				unset($_SESSION['post']);
				$_SESSION['success'] = 'Ballot Submitted';
			}
		}
	} else {
		$_SESSION['error'][] = 'Select candidates to vote first';
	}

	header('location: home.php');
?>
