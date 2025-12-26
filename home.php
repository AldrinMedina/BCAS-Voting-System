<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green layout-top-nav" <?php if (!isset($_SESSION['otp_verified'])) { echo 'onload="openModal()"'; } ?>>
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	      	<?php
	      		$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
    			$title = $parse['election_title'];
	      	?>
	      	<h1 class="text-center title mb-4"><b><?php echo strtoupper($title); ?></b></h1>
	        <div class="row">
	        	<div class="col-10 offset-1">
	        		<?php
				        if(isset($_SESSION['error'])){
				        	?>
				        	<div class="alert alert-danger alert-dismissible fade show">
				        		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					        	<ul class="mb-0">
					        		<?php
					        			foreach($_SESSION['error'] as $error){
					        				echo "
					        					<li>".$error."</li>
					        				";
					        			}
					        		?>
					        	</ul>
					        </div>
				        	<?php
				         	unset($_SESSION['error']);

				        }
				        if(isset($_SESSION['success'])){
				          	echo "
				            	<div class='alert alert-success alert-dismissible fade show'>
				              		<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				              		<h4><i class='fa fa-check'></i> Success!</h4>
				              	".$_SESSION['success']."
				            	</div>
				          	";
				          	unset($_SESSION['success']);
				        }

				    ?>
 
				    <div class="alert alert-danger alert-dismissible fade show" id="alert" style="display:none;">
		        		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			        	<span class="message"></span>
			        </div>

				    <?php
              $stmnt = $conn->prepare ("SELECT * FROM votes WHERE voters_id = ?");
              $stmnt->bind_param("s", $voter['id']);
              $stmnt->execute();
              $vquery = $stmnt->get_result();
				    	if($vquery->num_rows > 0){
				    		?>
				    		<div class="text-center">
					    		<h3>You have already voted for this election.</h3>
					    		<a href="#view" data-bs-toggle="modal" class="btn btn-primary btn-lg" style="background-color: #4CAF50; border: 2px solid #2C6B2F; color: white;">View Ballot</a>
					    	</div>
				    		<?php
				    	}
				    	else{
				    		?>
			    			<!-- Voting Ballot -->
						    <form method="POST" id="ballotForm" action="submit_ballot.php">
								<input type="hidden" name="vote" value="true">
				        		<?php
				        			include 'includes/slugify.php';
									$voter_year_level = $voter['y_lvl']; // Initialize the voter's year level

									// if (isset($voter['y_lvl'])) {
									// 	$voter_year_level = $voter['y_lvl']; // Assume $voter['year'] contains something like "1st-Year College"
									// }

									// Remove the "-Year College" part for comparison with the position
									// $voter_year_number = substr($voter_year_level, 0, strpos($voter_year_level, "-"));
									

									$candidate = '';
									$posstmnt = $conn->prepare("SELECT * FROM positions ORDER BY priority ASC");
									$posstmnt->execute();
									$query = $posstmnt->get_result();

									while ($row = $query->fetch_assoc()) {
										// Check if the position is a representative position
										if (strpos($row['description'], 'Representative') !== false) {
											// Extract the year number from the position description
											// $position_year_number = substr($row['description'], 0, strpos($row['description'], ''));
											$position_year_level = str_replace('Representative', '', $row['description']);
											$position_year_level = trim($position_year_level);

											// Only display the position if the year level matches the voter's year level
											if ($voter_year_level !== $position_year_level) {
												continue; // Skip this iteration if the years don't match
											}
										}

										// Fetch candidates for this position
										$candstmnt = $conn->prepare("SELECT * FROM candidates WHERE position_id=?");
										$candstmnt->bind_param("s", $row['id']);
										$candstmnt->execute();
										$cquery = $candstmnt->get_result();
										$candidate_cards = '';

										while ($crow = $cquery->fetch_assoc()) {
											$sql = "SELECT * FROM party WHERE id = '".$crow['partylist_id']."'";
											$pquery = $conn->query($sql);
											$prow = $pquery->fetch_assoc();

											$slug = slugify($row['description']);
											$checked = '';
											if (isset($_SESSION['post'][$slug])) {
												$value = $_SESSION['post'][$slug];

												if (is_array($value)) {
													foreach ($value as $val) {
														if ($val == $crow['id']) {
															$checked = 'checked';
														}
													}
												} else {
													if ($value == $crow['id']) {
														$checked = 'checked';
													}
												}
											}
											
											$input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="form-check-input candidate-input '.$slug.'" name="'.$slug."[]".'" value="'.$crow['id'].'" '.$checked.' id="candidate_'.$crow['id'].'">' : '<input type="radio" class="form-check-input candidate-input '.$slug.'" name="'.slugify($row['description']).'" value="'.$crow['id'].'" '.$checked.' id="candidate_'.$crow['id'].'">';
											$image = (!empty($crow['photo'])) ? 'images/'.$crow['photo'] : 'images/profile.jpg';
											$candidate_cards .= '
												<div class="col-lg-4 col-md-6 col-12 mb-4">
													<div class="card candidate-card h-100 shadow-sm border-0" data-candidate-id="'.$crow['id'].'">
														<div class="position-relative">
															<img src="'.$image.'" class="card-img-top candidate-photo" alt="'.$crow['firstname'].' '.$crow['lastname'].'">
															<div class="position-absolute top-0 end-0 m-3">
																<div class="form-check">
																	'.$input.'
																	<label class="form-check-label visually-hidden" for="candidate_'.$crow['id'].'">
																		Select '.$crow['firstname'].' '.$crow['lastname'].'
																	</label>
																</div>
															</div>
															<div class="card-overlay position-absolute bottom-0 start-0 w-100 p-3 text-white">
																<div class="candidate-info">
																	<h5 class="card-title candidate-name mb-1 fw-bold">'.$crow['firstname'].' '.$crow['lastname'].'</h5>
																	<p class="card-text candidate-party mb-0">
																		<span class="badge bg-primary bg-opacity-90">'.$prow['partylist'].'</span>
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											';

										}

										// Add "Prefer Not to Vote" option
										$not_vote_value = "not-vote-" . $row['id'];
										$checked_not_vote = isset($_SESSION['post'][$slug]) && $_SESSION['post'][$slug] == $not_vote_value ? 'checked' : '';
										$input_not_vote = '<input type="radio" class="form-check-input candidate-input '.$slug.'" name="'.$slug.'" value="'.$not_vote_value.'" '.$checked_not_vote.' id="not_vote_'.$row['id'].'">';

										$candidate_cards .= '
											<div class="col-lg-4 col-md-6 col-12 mb-4">
												<div class="card no-vote-card h-100 shadow-sm border-2 border-secondary border-opacity-25" data-candidate-id="not-vote">
													<div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">
														<div class="mb-3">
															<i class="fa fa-times-circle text-secondary mb-3" style="font-size: 3rem;"></i>
														</div>
														<div class="form-check mb-3">
															'.$input_not_vote.'
															<label class="form-check-label fw-semibold text-secondary" for="not_vote_'.$row['id'].'">
																Prefer Not to Vote
															</label>
														</div>
														<small class="text-muted">Skip this position</small>
													</div>
												</div>
											</div>
										';


										$instruct = ($row['max_vote'] > 1) ? 'You may select up to '.$row['max_vote'].' candidates' : 'Select only one candidate';

										echo '
											<div class="position-section mb-5">
												<div class="position-header mb-4">
													<div class="d-flex justify-content-between align-items-center flex-wrap">
														<div class="mb-2 mb-md-0">
															<h2 class="position-title mb-2 text-primary fw-bold">'.$row['description'].'</h2>
															<p class="position-instruction text-muted mb-0">
																<i class="fa fa-info-circle"></i> '.$instruct.'
															</p>
														</div>
														<button type="button" class="btn btn-outline-secondary btn-sm reset" data-desc="'.slugify($row['description']).'">
															<i class="fa fa-refresh"></i> Clear Selection
														</button>
													</div>
												</div>
												<div class="candidates-grid">
													<div class="row">
														'.$candidate_cards.'
													</div>
												</div>
											</div>
										';

										$candidate_cards = '';
									}	

				        		?>
				        		<div class="text-center mb-4">
									<button type="button" class="btn btn-primary btn-lg px-5" id="previewAndSubmit">
										<i class="fa fa-check-square-o"></i> Submit Ballot
									</button>
								</div>

				        	</form>
				        	<!-- End Voting Ballot -->
				    		<?php
				    	}

				    ?>

	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/ballot_modal.php'; ?>
</div>

<!-- Identity Confirmation Modal -->
<!-- <div id="id01" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content"> 
			<div class="modal-header">
				<h4 class="modal-title"><b>Identity Confirmation</b></h4>
			</div>
			<div class="modal-body">
				<form action="numpass.php" method="post">
					<label for="psw" class="form-label"><b>Enter the provided 6 Digit Code</b></label>
					<input class="form-control" type="text" placeholder="Enter the code." name="psw" id="psw" required>
			</div>
			<div class="modal-footer">
				<a href="logout.php" class="btn btn-danger"><i class="fa fa-sign-out"></i> LOGOUT</a>
				<input type="submit" value="Submit" name="login" class="btn btn-success">
				</form>
			</div>
		</div>
	</div>
</div> -->

<?php include 'includes/scripts.php'; ?>

<script>
var modal = document.getElementById('id01');

function openModal(){
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
}

$(document).ready(function() {
    
    // Handle card clicks to select candidates
    $('.candidate-card, .no-vote-card').on('click', function(e) {
        if (e.target.type === 'radio' || e.target.type === 'checkbox') {
            return; // Let the input handle the event
        }
        
        const input = $(this).find('input[type="radio"], input[type="checkbox"]');
        const isCheckbox = input.attr('type') === 'checkbox';
        const positionSection = $(this).closest('.position-section');
        
        if (isCheckbox) {
            // Handle checkbox (multiple selection)
            input.prop('checked', !input.prop('checked'));
        } else {
            // Handle radio (single selection)
            const name = input.attr('name');
            $(`input[name="${name}"]`).prop('checked', false);
            positionSection.find('.candidate-card, .no-vote-card').removeClass('selected');
            input.prop('checked', true);
        }
        
        updateCardSelection();
        $(this).addClass('just-selected');
        setTimeout(() => {
            $(this).removeClass('just-selected');
        }, 300);
    });

    // Handle direct input changes
    $('.candidate-input').on('change', function() {
        updateCardSelection();
    });

    // Update visual selection state
    function updateCardSelection() {
        $('.candidate-card, .no-vote-card').each(function() {
            const input = $(this).find('input[type="radio"], input[type="checkbox"]');
            if (input.prop('checked')) {
                $(this).addClass('selected');
            } else {
                $(this).removeClass('selected');
            }
        });
    }

    // Enhanced reset functionality
    $(document).on('click', '.reset', function(e) {
        e.preventDefault();
        const desc = $(this).data('desc');
        const positionSection = $(this).closest('.position-section');
        
        // Uncheck all inputs for this position
        $(`.${desc}`).prop('checked', false);
        
        // Remove selected class from all cards in this position
        positionSection.find('.candidate-card, .no-vote-card').removeClass('selected');
        
        // Add a subtle animation to show the reset
        positionSection.find('.candidate-card, .no-vote-card').addClass('loading');
        setTimeout(() => {
            positionSection.find('.candidate-card, .no-vote-card').removeClass('loading');
        }, 300);
    });

    // Enhanced form validation with better UX
	$('#previewAndSubmit').click(function(e) {
		e.preventDefault();
		
		// Add loading state to button
		const $button = $(this);
		const originalText = $button.html();
		$button.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
		
		// Check if at least one candidate or "Prefer Not to Vote" is selected for each position
		let allValid = true;
		let invalidPositions = [];
		
		$('.position-section').each(function() {
			const positionTitle = $(this).find('.position-title').text();
			const inputs = $(this).find('input[type="radio"], input[type="checkbox"]');
			const selected = inputs.filter(':checked').length > 0;

			if (!selected) {
				allValid = false;
				invalidPositions.push(positionTitle);
				
				// Add visual indication to invalid position
				$(this).addClass('invalid-position');
				setTimeout(() => {
					$(this).removeClass('invalid-position');
				}, 3000);
			}
		});

		if (!allValid) {
			const errorMessage = `Please make a selection for the following position(s): ${invalidPositions.join(', ')}`;
			$('.message').html(errorMessage);
			$('#alert').show();
			
			// Scroll to first invalid position
			$('html, body').animate({
				scrollTop: $('.position-section.invalid-position').first().offset().top - 100
			}, 500);
			
			// Reset button
			$button.html(originalText).prop('disabled', false);
		} else {
			// Serialize the form data
			const form = $('#ballotForm').serialize();
			$.ajax({
				type: 'POST',
				url: 'preview.php',
				data: form,
				dataType: 'json',
				success: function(response) {
					console.log('Preview response:', response); // Debug log
					if (response.error) {
						let errmsg = '';
						const messages = response.message;
						for (let i in messages) {
							errmsg += messages[i]; 
						}
						$('.message').html(errmsg);
						$('#alert').show();
					} else {
						// Set the preview content first
						$('#preview_body').html(response.list);
						
						// Show the modal using Bootstrap 5 method
						const previewModal = new bootstrap.Modal(document.getElementById('preview_modal'));
						previewModal.show();
					}
					// Reset button
					$button.html(originalText).prop('disabled', false);
				},
				error: function(xhr, status, error) {
					console.log('AJAX Error:', error); // Debug log
					console.log('Response:', xhr.responseText); // Debug log
					$('.message').html('An error occurred while processing your request. Please try again.');
					$('#alert').show();
					// Reset button
					$button.html(originalText).prop('disabled', false);
				}
			});
		}
	});

    // Initialize card selection state on page load
    updateCardSelection();

    // Enhanced confirm submit with better UX (for modal)
    $('#confirmSubmit').click(function() {
        const $button = $(this);
        const originalText = $button.html();
        
        if (confirm('Are you sure you want to submit your ballot? This action cannot be undone.')) {
            $button.html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);
            $('#ballotForm').submit();
        }
    });
});
</script>

</body>
</html>