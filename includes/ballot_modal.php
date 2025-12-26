<!-- Preview -->
<!-- Preview Modal -->
<div id="preview_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Preview Your Selections</h4>
                <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview_body">
                <!-- The preview content will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm and Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Platform -->
<div class="modal fade" id="platform">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b><span class="candidate"></span></b></h4>
                <button type="button" class="close btn btn-default" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="plat_view"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Ballot -->
<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Your Votes</h4>
                <button type="button" class="close btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $id = $voter['id'];
                $stmnt = $conn->prepare ("SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id WHERE voters_id = ?  ORDER BY positions.priority ASC");
                $stmnt->bind_param("s", $id);
                $stmnt->execute();
                $query = $stmnt->get_result();
                //$sql = "SELECT *, candidates.firstname AS canfirst, candidates.lastname AS canlast FROM votes LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id WHERE voters_id = '$id'  ORDER BY positions.priority ASC";
                //$query = $conn->query($sql);
                while($row = $query->fetch_assoc()){
                  if($row['candidate_id']==0){
                    echo "
                    <div class='row votelist mb-1'>
                      <span class='col-sm-6'><span class=''><b>".$row['description']." :</b></span></span> 
                      <span class='col-sm-6 text-danger'>-Abstain-</span>
                    </div>
                    ";
                  }else{
                    echo "
                    <div class='row votelist mb-1'>
                      <span class='col-sm-6'><span class=''><b>".$row['description']." :</b></span></span> 
                      <span class='col-sm-6'>".$row['canfirst']." ".$row['canlast']."</span>
                    </div>
                    ";
                  }
                  
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Identity Confirmation Modal -->
<div id="id01" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient text-white border-0" >
                <!-- <div class="d-flex align-items-center">
                    <div class="me-3 p-2 bg-white bg-opacity-20 rounded-circle">
                        <i class="fa fa-shield-alt fs-4"></i>
                    </div>
                    <div>
                        <h4 class="modal-title mb-0 fw-bold">Identity Confirmation</h4>
                        <small class="opacity-75">Secure access verification required</small>
                    </div>
                </div> -->
            </div>
            <div class="modal-body p-4">
                <form action="numpass.php" method="post" id="otpForm">
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3 d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%;">
                            <i class="fa fa-key text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Enter Verification Code</h5>
                        <p class="text-muted mb-0">Please enter the 6-digit code provided to you to continue with the voting process.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="psw" class="form-label fw-semibold mb-3">
                            <i class="fa fa-lock me-2 text-primary"></i>
                            6-Digit Security Code
                        </label>
                        <input class="form-control form-control-lg text-center fw-bold" 
                               type="password" 
                               placeholder="000000" 
                               name="psw" 
                               id="psw" 
                               maxlength="6"
                               pattern="[0-9]{6}"
                               style="letter-spacing: 0.5rem; font-size: 1.5rem;"
                               required>
                        <div class="form-text text-center mt-2">
                            <i class="fa fa-info-circle me-1"></i>
                            Enter the exact 6-digit code you received
                        </div>
                    </div>
                    
                    <div class="alert alert-info border-0 bg-light d-flex align-items-center" role="alert">
                        <div class="me-3">
                            <i class="fa fa-exclamation-triangle text-warning fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong>Important:</strong> This verification ensures the security and authenticity of your vote. Keep your code confidential.
                        </div>
                    </div>
            </div>
            <div class="modal-footer bg-light border-0 p-4">
                <div class="d-flex w-100 gap-2">
                    <a href="logout.php" class="btn btn-outline-danger flex-fill">
                        <i class="fa fa-sign-out me-2"></i>
                        Logout
                    </a>
                    <button type="submit" name="login" class="btn btn-success flex-fill btn-lg fw-bold" >
                        <i class="fa fa-check-circle me-2"></i>
                        Verify & Continue
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>