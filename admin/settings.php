<?php include 'includes/session.php'; ?>
<?php include 'includes/settings.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
  <style>
    .settings-section {
      border: 1px solid #f4f4f4;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 20px;
      background: #fff;
    }
    .settings-section h4 {
      margin-top: 0;
      color: #444;
      border-bottom: 2px solid #00a65a;
      padding-bottom: 10px;
    }
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 34px;
    }
    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }
    input:checked + .slider {
      background-color: #00a65a;
    }
    input:checked + .slider:before {
      transform: translateX(26px);
    }
  </style>
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Settings</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

      <div class="row">
        <!-- Existing Settings -->
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">System Administration</h3>
            </div>
            <div class="box-body">
              
              <!-- Super Admin Section -->
              <div class="settings-section">
                <h4><i class="fa fa-user-secret"></i> Super Admin</h4>
                <?php
                  if (!isset($_SESSION['superAdmin']) || trim($_SESSION['superAdmin']) == ''){
                    echo '
                      <p>No superadmin is currently signed-in</p>
                      <a class="btn btn-primary btn-flat" href="#sAdmin" data-toggle="modal">
                        <i class="fa fa-sign-in"></i> Sign In
                      </a>
                    ';
                  }else{
                    echo '
                      <p><strong>'.$_SESSION['superAdmin'].'</strong> is currently signed-in</p>
                      <a class="btn btn-danger btn-flat" href="SAdlogout.php">
                        <i class="fa fa-sign-out"></i> Sign Out
                      </a>
                    ';
                  }
                ?>
              </div>

              <!-- Election Title Section -->
              <div class="settings-section">
                <h4><i class="fa fa-edit"></i> Election Configuration</h4>
                <div class="row">
                  <div class="col-sm-8">
                    <p><strong>Current Title:</strong><br>
                    <?php 
                      $parse = parse_ini_file('config.ini', FALSE, INI_SCANNER_RAW); 
                      echo htmlspecialchars($parse['election_title']); 
                    ?></p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <a class="btn btn-info btn-flat" href="#config" data-toggle="modal">
                      <i class="fa fa-edit"></i> Change Title
                    </a>
                  </div>
                </div>
              </div>

              <!-- Dangerous Actions Section -->
              <div class="settings-section">
                <h4><i class="fa fa-exclamation-triangle text-red"></i> Dangerous Actions</h4>
                <div class="row" style="margin-bottom: 10px;">
                  <div class="col-sm-8">
                    <strong>Reset All Votes</strong>
                    <p class="text-muted small">This will permanently delete all vote records</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <a href="#reset" data-toggle="modal" class="btn btn-danger btn-flat">
                      <i class="fa fa-refresh"></i> Reset Votes
                    </a>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8">
                    <strong>Delete Candidates & Parties</strong>
                    <p class="text-muted small">This will remove all candidates and party data</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <a href="#delete_candidates" data-toggle="modal" class="btn btn-danger btn-flat">
                      <i class="fa fa-trash"></i> Delete All
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- New Database Settings -->
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Display & Voting Settings</h3>
            </div>
            <div class="box-body">
              
              <!-- Display Settings -->
              <div class="settings-section">
                <h4><i class="fa fa-eye"></i> Display Settings</h4>
                
                <!-- Anonymity Mode -->
                <div class="row" style="margin-bottom: 15px;">
                  <div class="col-sm-8">
                    <strong>Anonymous Mode</strong>
                    <p class="text-muted small">Hide candidate names and photos on leaderboard by default</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <label class="switch">
                      <input type="checkbox" id="anonymity_mode" <?= getBooleanSetting('anonymity_mode', true) ? 'checked' : '' ?>>
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>

                <!-- Show Vote Count -->
                <div class="row" style="margin-bottom: 15px;">
                  <div class="col-sm-8">
                    <strong>Show Vote Count</strong>
                    <p class="text-muted small">Display number of votes in progress bars</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <label class="switch">
                      <input type="checkbox" id="show_vote_count" <?= getBooleanSetting('show_vote_count', true) ? 'checked' : '' ?>>
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>

                <!-- Show Percentage -->
                <div class="row">
                  <div class="col-sm-8">
                    <strong>Show Percentage</strong>
                    <p class="text-muted small">Display vote percentages on leaderboard</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <label class="switch">
                      <input type="checkbox" id="show_percentage" <?= getBooleanSetting('show_percentage', true) ? 'checked' : '' ?>>
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Voting Control -->
              <div class="settings-section">
                <h4><i class="fa fa-vote-yea"></i> Voting Control</h4>
                <div class="row">
                  <div class="col-sm-8">
                    <strong>Enable Voting</strong>
                    <p class="text-muted small">Allow users to cast votes. Disable to stop all voting.</p>
                  </div>
                  <div class="col-sm-4 text-right">
                    <label class="switch">
                      <input type="checkbox" id="voting_enabled" <?= getBooleanSetting('voting_enabled', true) ? 'checked' : '' ?>>
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
              </div>

              <!-- Timing Settings -->
              <div class="settings-section">
                <h4><i class="fa fa-clock-o"></i> Timing Settings</h4>
                <div class="row" style="margin-bottom: 15px;">
                  <div class="col-sm-6">
                    <label><strong>Carousel Interval</strong></label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="carousel_interval" 
                             value="<?= getIntegerSetting('carousel_interval', 2000) ?>" 
                             min="1000" max="10000" step="500">
                      <span class="input-group-addon">ms</span>
                    </div>
                    <p class="text-muted small">Slide transition time</p>
                  </div>
                  <div class="col-sm-6">
                    <label><strong>Refresh Interval</strong></label>
                    <div class="input-group">
                      <input type="number" class="form-control" id="results_refresh_interval" 
                             value="<?= getIntegerSetting('results_refresh_interval', 5000) ?>" 
                             min="1000" max="60000" step="1000">
                      <span class="input-group-addon">ms</span>
                    </div>
                    <p class="text-muted small">Auto-refresh rate</p>
                  </div>
                </div>
              </div>

            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-success btn-flat" id="saveAllSettings">
                <i class="fa fa-save"></i> Save All Settings
              </button>
              <button type="button" class="btn btn-warning btn-flat pull-right" id="resetDefaults">
                <i class="fa fa-refresh"></i> Reset to Defaults
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Settings Status Table -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Current Settings Status</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="settingsStatusTable">
                  <thead>
                    <tr>
                      <th>Setting</th>
                      <th>Current Value</th>
                      <th>Description</th>
                      <th>Last Updated</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Will be populated by JavaScript -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <?php include 'includes/votes_modal.php'; ?>
    <?php include 'settings/config_modal.php' ?>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fa fa-spinner fa-spin fa-2x text-green"></i>
        <p class="mt-2"><strong>Updating settings...</strong></p>
      </div>
    </div>
  </div>
</div>

    <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(document).ready(function() {
    loadSettingsStatus();
    
    // Auto-save on switch changes
    $('input[type="checkbox"]').change(function() {
        const key = $(this).attr('id');
        const value = $(this).is(':checked');
        updateSingleSetting(key, value, true);
    });
    
    // Auto-save on number input changes (with debounce)
    let saveTimeout;
    $('input[type="number"]').on('input', function() {
        const key = $(this).attr('id');
        const value = $(this).val();
        
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            updateSingleSetting(key, value, true);
        }, 1000);
    });
    
    // Save all settings button
    $('#saveAllSettings').click(function() {
        saveAllSettings();
    });
    
    // Reset to defaults button
    $('#resetDefaults').click(function() {
        if (confirm('Are you sure you want to reset all display settings to their default values?')) {
            resetToDefaults();
        }
    });
});

function updateSingleSetting(key, value, showAlert = false) {
    $.ajax({
        url: 'update_setting.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ key: key, value: value }),
        success: function(response) {
            if (response.success) {
                if (showAlert) {
                    showSuccessAlert(`Setting '${formatSettingName(key)}' updated successfully!`);
                }
                loadSettingsStatus();
            } else {
                console.error('Failed to update setting:', response.message);
                showErrorAlert(`Failed to update '${formatSettingName(key)}': ${response.message}`);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating setting:', error);
            showErrorAlert(`Error updating '${formatSettingName(key)}': ${error}`);
        }
    });
}

function saveAllSettings() {
    $('#loadingModal').modal('show');
    
    const settings = [
        { key: 'anonymity_mode', value: $('#anonymity_mode').is(':checked') },
        { key: 'voting_enabled', value: $('#voting_enabled').is(':checked') },
        { key: 'show_vote_count', value: $('#show_vote_count').is(':checked') },
        { key: 'show_percentage', value: $('#show_percentage').is(':checked') },
        { key: 'carousel_interval', value: $('#carousel_interval').val() },
        { key: 'results_refresh_interval', value: $('#results_refresh_interval').val() }
    ];
    
    let completed = 0;
    let errors = 0;
    
    settings.forEach(setting => {
        updateSingleSetting(setting.key, setting.value, false);
        completed++;
        
        if (completed === settings.length) {
            setTimeout(() => {
                $('#loadingModal').modal('hide');
                if (errors === 0) {
                    showSuccessAlert('All settings saved successfully!');
                } else {
                    showErrorAlert(`Settings saved with ${errors} error(s).`);
                }
                loadSettingsStatus();
            }, 500);
        }
    });
}

function resetToDefaults() {
    $('#loadingModal').modal('show');
    
    const defaultSettings = [
        { key: 'anonymity_mode', value: true },
        { key: 'voting_enabled', value: true },
        { key: 'show_vote_count', value: true },
        { key: 'show_percentage', value: true },
        { key: 'carousel_interval', value: 2000 },
        { key: 'results_refresh_interval', value: 5000 }
    ];
    
    let completed = 0;
    
    defaultSettings.forEach(setting => {
        updateSingleSetting(setting.key, setting.value, false);
        completed++;
        
        if (completed === defaultSettings.length) {
            // Update form fields
            $('#anonymity_mode').prop('checked', true);
            $('#voting_enabled').prop('checked', true);
            $('#show_vote_count').prop('checked', true);
            $('#show_percentage').prop('checked', true);
            $('#carousel_interval').val(2000);
            $('#results_refresh_interval').val(5000);
            
            setTimeout(() => {
                $('#loadingModal').modal('hide');
                showSuccessAlert('All settings reset to defaults!');
                loadSettingsStatus();
            }, 500);
        }
    });
}

function loadSettingsStatus() {
    $.ajax({
        url: 'get_settings.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let tableHTML = '';
                
                const descriptions = {
                    'anonymity_mode': 'Hide candidate information on public leaderboard',
                    'voting_enabled': 'Allow users to cast votes in the system',
                    'show_vote_count': 'Display vote numbers in progress bars',
                    'show_percentage': 'Show percentage values on leaderboard',
                    'carousel_interval': 'Time between automatic slide transitions',
                    'results_refresh_interval': 'How often to refresh vote counts automatically'
                };
                
                Object.keys(response.settings).forEach(key => {
                    const value = response.settings[key];
                    const description = descriptions[key] || 'No description available';
                    
                    tableHTML += `
                        <tr>
                            <td><strong>${formatSettingName(key)}</strong></td>
                            <td>${formatSettingValue(key, value)}</td>
                            <td>${description}</td>
                            <td><small class="text-muted">Just updated</small></td>
                        </tr>
                    `;
                });
                
                $('#settingsStatusTable tbody').html(tableHTML);
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load settings status:', error);
            $('#settingsStatusTable tbody').html('<tr><td colspan="4" class="text-center text-danger">Failed to load settings</td></tr>');
        }
    });
}

function formatSettingName(key) {
    return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

function formatSettingValue(key, value) {
    if (['anonymity_mode', 'voting_enabled', 'show_vote_count', 'show_percentage'].includes(key)) {
        const isEnabled = value === '1';
        return `<span class="label label-${isEnabled ? 'success' : 'danger'}">${isEnabled ? 'Enabled' : 'Disabled'}</span>`;
    }
    if (['carousel_interval', 'results_refresh_interval'].includes(key)) {
        return `<code>${value}ms</code>`;
    }
    return `<code>${value}</code>`;
}

function showSuccessAlert(message) {
    const alertHTML = `
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-check"></i> ${message}
        </div>
    `;
    $('.content-header').after(alertHTML);
    setTimeout(() => $('.alert').fadeOut(), 4000);
}

function showErrorAlert(message) {
    const alertHTML = `
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-warning"></i> ${message}
        </div>
    `;
    $('.content-header').after(alertHTML);
    setTimeout(() => $('.alert').fadeOut(), 6000);
}

// Existing vote status functionality
$(document).on('change', '#vstatus', function(e){
    e.preventDefault();
    var status = $(this).is(':checked') ? 'active' : 'inactive';
    updateStatus(status);
});

function updateStatus(status){
    $.ajax({
        type: 'POST',
        url: 'settings/vote_status.php',
        data: {status: status},
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.error) {
                alert(response.error);
            } else {
                alert(response.success);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + error);
        }
    });
}
</script>
</body>
</html>