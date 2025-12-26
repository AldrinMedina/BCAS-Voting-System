<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
              
		$id = $_POST['id'];
		$data[]=array();
		$sql = "SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id WHERE voters_id = '$id'  ORDER BY positions.priority ASC";
		$query = $conn->query($sql);
		while($row = $query->fetch_assoc()){
			if($row['candidate_id']==0){
				array_push($data, "
					<div class='row votelist mb-1'>
						<span class='col-sm-6'><span class=''><b>".$row['description']." :</b></span></span> 
						<span class='col-sm-6 text-danger'>-Abstain-</span>
					</div>
				") ;
			}else{
				array_push($data, "
					<div class='row votelist'>
						<span class='col-sm-4'><span class=''><b>".$row['description']." :</b></span></span> 
						<span class='col-sm-8'>".$row['canfirst']." ".$row['canlast']."</span>
					</div>
				") ;
			}
			
		}
		echo json_encode($data);
	}
?>