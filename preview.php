<?php
	
	include 'includes/session.php';
	include 'includes/slugify.php';

	$output = array('error'=>false,'list'=>'');

	// Get voter's year level (same logic as in home.php)
	$voter_year_number = ''; 
	if (isset($voter['y_lvl'])) {
		$voter_year_number = $voter['y_lvl']; 
	}

	$sql = "SELECT * FROM positions ORDER BY priority ASC";
	$query = $conn->query($sql);

	while($row = $query->fetch_assoc()){
		// Apply the same filtering logic as in home.php
		if (strpos($row['description'], 'Representative') !== false) {
			$position_year_number = substr($row['description'], 0, strpos($row['description'], ' Representative'));
			// Only process the position if the year level matches the voter's year level
			if ($voter_year_number !== $position_year_number) {
				continue; // Skip this iteration if the years don't match
			}
		}

		$position = slugify($row['description']);
		$pos_id = $row['id'];

		// Check if a vote or "Prefer Not to Vote" option was selected
		if(isset($_POST[$position])){
			$selected_option = $_POST[$position];

			// Handle multiple votes scenario
			if($row['max_vote'] > 1){
				if(count($_POST[$position]) > $row['max_vote']){
					$output['error'] = true;
					$output['message'][] = '<li>You can only choose '.$row['max_vote'].' candidates for '.$row['description'].'</li>';
				} else {
					foreach($_POST[$position] as $key => $values){
						// Check for "Prefer Not to Vote" option
						if (strpos($values, 'not-vote-') !== false) {
							$output['list'] .= "
								<div class='row votelist mb-3'>
									<div class='col-4'>
										<strong>".$row['description'].":</strong>
									</div>
									<div class='col-8'>
										<span class='badge bg-secondary'>Prefer Not to Vote</span>
									</div>
								</div>
							";
						} else {
							$sql = "SELECT * FROM candidates WHERE id = '$values'";
							$cmquery = $conn->query($sql);
							$cmrow = $cmquery->fetch_assoc();
							
							// Get party info
							$party_sql = "SELECT * FROM party WHERE id = '".$cmrow['partylist_id']."'";
							$party_query = $conn->query($party_sql);
							$party_row = $party_query->fetch_assoc();
							
							$output['list'] .= "
								<div class='row votelist mb-3'>
									<div class='col-4'>
										<strong>".$row['description'].":</strong>
									</div>
									<div class='col-8'>
										<div class='d-flex align-items-center'>
											<img src='images/".(!empty($cmrow['photo']) ? $cmrow['photo'] : 'profile.jpg')."' class='rounded-circle me-2' width='40' height='40' style='object-fit: cover;'>
											<div>
												<div class='fw-bold'>".$cmrow['firstname']." ".$cmrow['lastname']."</div>
												<small class='text-muted'>".$party_row['partylist']."</small>
											</div>
										</div>
									</div>
								</div>
							";
						}
					}
				}
			} else {
				// Handle single vote scenario
				if (strpos($selected_option, 'not-vote-') !== false) {
					$output['list'] .= "
						<div class='row votelist mb-3'>
							<div class='col-4'>
								<strong>".$row['description'].":</strong>
							</div>
							<div class='col-8'>
								<span class='badge bg-secondary'>Prefer Not to Vote</span>
							</div>
						</div>
					";
				} else {
					$sql = "SELECT * FROM candidates WHERE id = '$selected_option'";
					$csquery = $conn->query($sql);
					$csrow = $csquery->fetch_assoc();
					
					// Get party info
					$party_sql = "SELECT * FROM party WHERE id = '".$csrow['partylist_id']."'";
					$party_query = $conn->query($party_sql);
					$party_row = $party_query->fetch_assoc();
					
					$output['list'] .= "
						<div class='row votelist mb-3'>
							<div class='col-4'>
								<strong>".$row['description'].":</strong>
							</div>
							<div class='col-8'>
								<div class='d-flex align-items-center'>
									<img src='images/".(!empty($csrow['photo']) ? $csrow['photo'] : 'profile.jpg')."' class='rounded-circle me-2' width='40' height='40' style='object-fit: cover;'>
									<div>
										<div class='fw-bold'>".$csrow['firstname']." ".$csrow['lastname']."</div>
										<small class='text-muted'>".$party_row['partylist']."</small>
									</div>
								</div>
							</div>
						</div>
					";
				}
			}
		} else {
			// If no selection is made for this position, add it to the error
			$output['error'] = true;
			$output['message'][] = '<li>Please make a selection for '.$row['description'].'</li>';
		}
	}

	echo json_encode($output);
?>