<?php
	include 'includes/session.php';

	function generateElectionResults($conn){
		$contents = '';
		$totalVoters = 0;
		$positionCount = 0;
	 	
		$sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $conn->query($sql);
        
        while($row = $query->fetch_assoc()){
        	$positionCount++;
        	$id = $row['id'];
        	$positionVotes = 0;
        	
        	// Position Header with modern styling
        	$contents .= '
        		<div style="background: linear-gradient(135deg, #4CAF50, #2E7D32); color: white; padding: 12px; margin: 20px 0 10px 0; border-radius: 8px;">
        			<h3 style="margin: 0; font-size: 16px; text-align: center; font-weight: bold;">
        				' . strtoupper($row['description']) . '
        			</h3>
        			<p style="margin: 5px 0 0 0; text-align: center; font-size: 10px; opacity: 0.9;">
        				Maximum votes allowed: ' . $row['max_vote'] . '
        			</p>
        		</div>
        	';

        	// Get all candidates for this position
        	$sql = "SELECT * FROM candidates WHERE position_id = '$id' ORDER BY lastname ASC";
    		$cquery = $conn->query($sql);
    		$candidates = [];
    		$maxVotes = 0;
    		
    		while($crow = $cquery->fetch_assoc()){
    			$sql = "SELECT * FROM votes WHERE candidate_id = '".$crow['id']."'";
      			$vquery = $conn->query($sql);
      			$votes = $vquery->num_rows;
      			$positionVotes += $votes;
      			
      			// Get party information
      			$partySql = "SELECT partylist FROM party WHERE id = '".$crow['partylist_id']."'";
      			$partyQuery = $conn->query($partySql);
      			$partyRow = $partyQuery->fetch_assoc();
      			$party = $partyRow ? $partyRow['partylist'] : 'Independent';
      			
      			$candidates[] = [
      				'name' => $crow['lastname'] . ", " . $crow['firstname'],
      				'party' => $party,
      				'votes' => $votes,
      				'photo' => $crow['photo']
      			];
      			
      			if($votes > $maxVotes) $maxVotes = $votes;
    		}
    		
    		// Sort candidates by votes (descending)
    		usort($candidates, function($a, $b) {
    			return $b['votes'] - $a['votes'];
    		});
    		
    		// Generate candidate results table
    		$contents .= '
    			<table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    				<thead>
    					<tr style="background: #f8f9fa;">
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold; color: #2E7D32;">Rank</th>
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold; color: #2E7D32;">Candidate</th>
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold; color: #2E7D32;">Party</th>
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: center; font-weight: bold; color: #2E7D32;">Votes</th>
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: center; font-weight: bold; color: #2E7D32;">Percentage</th>
    						<th style="border: 1px solid #ddd; padding: 10px; text-align: left; font-weight: bold; color: #2E7D32;">Vote Bar</th>
    					</tr>
    				</thead>
    				<tbody>
    		';
    		
    		$rank = 1;
    		foreach($candidates as $candidate) {
    			$percentage = $positionVotes > 0 ? round(($candidate['votes'] / $positionVotes) * 100, 1) : 0;
    			$barWidth = $maxVotes > 0 ? ($candidate['votes'] / $maxVotes) * 100 : 0;
    			
    			// Determine row styling based on rank
    			$rowStyle = '';
    			$rankBadge = '';
    			if($rank === 1 && $candidate['votes'] > 0) {
    				$rowStyle = 'background: #e8f5e8;';
    				$rankBadge = '<span style="background: #4CAF50; color: white; padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;">WINNER</span>';
    			} elseif($rank <= 3) {
    				$rowStyle = 'background: #fff3e0;';
    				$rankBadge = '<span style="background: #FF9800; color: white; padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold;">TOP 3</span>';
    			}
    			
    			$contents .= '
    				<tr style="' . $rowStyle . '">
    					<td style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold;">
    						#' . $rank . '<br>' . $rankBadge . '
    					</td>
    					<td style="border: 1px solid #ddd; padding: 8px;">
    						<strong>' . htmlspecialchars($candidate['name']) . '</strong>
    					</td>
    					<td style="border: 1px solid #ddd; padding: 8px; color: #666;">
    						' . htmlspecialchars($candidate['party']) . '
    					</td>
    					<td style="border: 1px solid #ddd; padding: 8px; text-align: center; font-weight: bold; font-size: 14px;">
    						' . number_format($candidate['votes']) . '
    					</td>
    					<td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
    						' . $percentage . '%
    					</td>
    					<td style="border: 1px solid #ddd; padding: 8px;">
    						<div style="background: #f0f0f0; height: 20px; border-radius: 10px; position: relative; overflow: hidden;">
    							<div style="background: linear-gradient(90deg, #4CAF50, #66BB6A); height: 100%; width: ' . $barWidth . '%; border-radius: 10px; transition: width 0.3s ease;"></div>
    							<span style="position: absolute; top: 2px; left: 8px; font-size: 10px; color: #333; font-weight: bold;">' . $candidate['votes'] . '</span>
    						</div>
    					</td>
    				</tr>
    			';
    			$rank++;
    		}
    		
    		$contents .= '
    				</tbody>
    			</table>
    			<div style="margin-bottom: 5px; padding: 8px; background: #f8f9fa; border-radius: 5px; font-size: 11px; color: #666;">
    				<strong>Position Summary:</strong> Total Votes Cast: ' . number_format($positionVotes) . ' | Total Candidates: ' . count($candidates) . '
    			</div>
    		';
    		
    		$totalVoters = max($totalVoters, $positionVotes);
        }

        // Add summary section
        $contents .= '
        	<div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 10px; border-left: 5px solid #4CAF50;">
        		<h3 style="color: #2E7D32; margin: 0 0 15px 0; font-size: 14px;">ELECTION SUMMARY</h3>
        		<table style="width: 100%; font-size: 11px;">
        			<tr>
        				<td style="padding: 5px 0;"><strong>Total Positions:</strong></td>
        				<td style="text-align: right;">' . $positionCount . '</td>
        			</tr>
        			<tr>
        				<td style="padding: 5px 0;"><strong>Highest Vote Count:</strong></td>
        				<td style="text-align: right;">' . number_format($totalVoters) . '</td>
        			</tr>
        			<tr style="border-top: 1px solid #ddd;">
        				<td style="padding: 10px 0 5px 0;"><strong>Report Generated:</strong></td>
        				<td style="text-align: right; padding: 10px 0 5px 0;">' . date("F j, Y \a\\t g:i A") . '</td>
        			</tr>
        		</table>
        	</div>
        ';

		return $contents;
	}

	require_once('../tcpdf/tcpdf.php'); 

	// Custom PDF class with modern header and footer
	class ModernElectionPDF extends TCPDF {

		//Page header
		public function Header() {
			// Header background
			$this->SetFillColor(76, 175, 80); // Green background
			$this->Rect(0, 0, $this->getPageWidth(), 35, 'F');
			
			// Logo
			$image_file = K_PATH_IMAGES.'logo.jpg';
			if(file_exists($image_file)) {
				$this->Image($image_file, 15, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			}
			
			// Institution name
			$this->SetFont('helvetica', 'B', 16);
			$this->SetTextColor(255, 255, 255); // White text
			$this->SetXY(45, 12);
			$this->Cell(0, 0, 'BATANGAS COLLEGE OF ARTS AND SCIENCES INC.', 0, false, 'L', 0, '', 0, false, 'M', 'M');
			
			// Subtitle
			$this->SetFont('helvetica', '', 10);
			$this->SetXY(45, 22);
			$this->Cell(0, 0, 'Official Election Results Report', 0, false, 'L', 0, '', 0, false, 'M', 'M');
			
			// Reset text color for body
			$this->SetTextColor(0, 0, 0);
		}
	
		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			
			// Footer background
			$this->SetFillColor(248, 249, 250);
			$this->Rect(0, $this->GetY()-5, $this->getPageWidth(), 20, 'F');
			
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			$this->SetTextColor(100, 100, 100);
			
			// Left side - authenticity note
			$this->SetXY(15, $this->GetY());
			$this->Cell(0, 10, '🔒 This document is system-generated and digitally secured. Any alteration voids authenticity.', 0, false, 'L', 0, '', 0, false, 'T', 'M');
			
			// Right side - page number
			$this->SetXY(-50, $this->GetY());
			$this->Cell(35, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}
		
	// Get election configuration
	$parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW);
    $title = $parse['election_title'];
    
    // Set timezone
    date_default_timezone_set('Asia/Manila');

    // Create PDF instance
    $pdf = new ModernElectionPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    
    // Set document information
    $pdf->SetCreator('BCAS Voting System');  
    $pdf->SetAuthor('Batangas College of Arts and Sciences Inc.');
    $pdf->SetTitle('Election Results: ' . $title);  
    $pdf->SetSubject('Official Election Tally Report');
    $pdf->SetKeywords('election, results, voting, tally, BCAS');
    
    // Set default font
    $pdf->SetFont('helvetica', '', 10);  
    
    // Set margins (increased top margin for header)
    $pdf->SetMargins(15, 45, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    
    // Enable auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 25);  
    
    // Add first page
    $pdf->AddPage();  
    
    // Title section with modern styling
    $titleContent = '
    	<div style="text-align: center; margin: 20px 0 30px 0;">
    		<h1 style="color: #2E7D32; font-size: 24px; margin: 0 0 10px 0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
    			' . htmlspecialchars($title) . '
    		</h1>
    		<div style="background: linear-gradient(90deg, #4CAF50, #66BB6A); height: 4px; width: 200px; margin: 10px auto; border-radius: 2px;"></div>
    		<h2 style="color: #666; font-size: 18px; margin: 15px 0 5px 0; font-weight: normal;">
    			OFFICIAL TALLY RESULTS
    		</h2>
    		<p style="color: #888; font-size: 12px; margin: 5px 0 0 0;">
    			Generated on ' . date("l, F j, Y \a\\t g:i A") . '
    		</p>
    	</div>
    ';
    
    // Write title
    $pdf->writeHTML($titleContent, true, false, true, false, '');
    
    // Generate and write election results
    $resultsContent = generateElectionResults($conn);
    $pdf->writeHTML($resultsContent, true, false, true, false, '');
    
    // Add signature section
    $signatureContent = '
    	<div style="margin-top: 40px; page-break-inside: avoid;">
    		<table style="width: 100%; margin-top: 30px;">
    			<tr>
    				<td style="width: 50%; text-align: center; vertical-align: bottom;">
    					<div style="border-bottom: 1px solid #333; width: 200px; margin: 0 auto 5px auto; height: 40px;"></div>
    					<strong>Election Administrator</strong><br>
    					<small style="color: #666;">Signature & Date</small>
    				</td>
    				<td style="width: 50%; text-align: center; vertical-align: bottom;">
    					<div style="border-bottom: 1px solid #333; width: 200px; margin: 0 auto 5px auto; height: 40px;"></div>
    					<strong>Authorized Personnel</strong><br>
    					<small style="color: #666;">Signature & Date</small>
    				</td>
    			</tr>
    		</table>
    		
    		<div style="margin-top: 30px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; font-size: 10px; color: #856404;">
    			<strong>DISCLAIMER:</strong> This report contains official election results as recorded by the BCAS Voting System. 
    			Results are final upon official certification. For questions or concerns, contact the Election Committee.
    		</div>
    	</div>
    ';
    
    $pdf->writeHTML($signatureContent, true, false, true, false, '');
    
    // Output PDF
    $filename = 'BCAS_Election_Results_' . date('Y-m-d_H-i-s') . '.pdf';
    $pdf->Output($filename, 'I');

?>