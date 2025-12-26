<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bulk Import Voters
        <small>Import voters from Excel file</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="voters.php">Voters</a></li>
        <li class="active">Bulk Import</li>
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
        if(isset($_SESSION['warning'])){
          echo "
            <div class='alert alert-warning alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Warning!</h4>
              ".$_SESSION['warning']."
            </div>
          ";
          unset($_SESSION['warning']);
        }
      ?>

      <!-- Step 1: File Upload -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-upload"></i> Step 1: Upload Excel File</h3>
            </div>
            <div class="box-body">
              
              <!-- Instructions -->
              <div class="alert alert-info">
                <h4><i class="fa fa-info-circle"></i> Instructions</h4>
                <p><strong>Excel file format requirements:</strong></p>
                <ul>
                  <li>File must be in .csv format</li>
                  <li>First row should contain column headers</li>
                  <li>Required columns: <code>voters_id</code>, <code>firstname</code>, <code>lastname</code>, <code>year</code>, <code>course</code></li>
                  <li>Optional columns: <code>password</code> (if not provided, default password will be used)</li>
                  <li>Maximum file size: 10MB</li>
                </ul>
                <p><a href="#" id="download-template" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download Template</a></p>
              </div>

              <!-- Upload Form -->
              <form id="upload-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="csv_file">Choose CSV File:</label>
                  <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                  <small class="text-muted">Supported formats: .csv only (Max: 10MB)</small>
                </div>
                
                <div class="form-group">
                  <label for="default_password">Default Password (for voters without password in file):</label>
                  <input type="text" class="form-control" id="default_password" name="default_password" value="123456" placeholder="Enter default password">
                  <small class="text-muted">This password will be used for voters who don't have a password specified in the CSV file</small>
                </div>

                <div class="form-group">
                  <label class="checkbox-inline">
                    <input type="checkbox" id="overwrite_existing" name="overwrite_existing" value="1">
                    Overwrite existing voters with same ID
                  </label>
                  <small class="text-muted d-block">If checked, voters with existing IDs will be updated. If unchecked, duplicates will be skipped.</small>
                </div>

                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-upload"></i> Upload and Preview
                </button>
              </form>

            </div>
          </div>
        </div>
      </div>

      <!-- Step 2: Preview Data (Initially Hidden) -->
      <div class="row" id="preview-section" style="display: none;">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-eye"></i> Step 2: Preview Data</h3>
            </div>
            <div class="box-body">
              <div id="preview-content">
                <!-- Content will be loaded here -->
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

  <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

<script>
$(document).ready(function() {
    // Handle file upload form
    $('#upload-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var fileInput = $('#csv_file')[0]; // Changed from excel_file to csv_file
        
        if (!fileInput.files.length) {
            alert('Please select a file to upload.');
            return;
        }

        var file = fileInput.files[0];
        var maxSize = 10 * 1024 * 1024; // 10MB in bytes

        if (file.size > maxSize) {
            alert('File size exceeds 10MB limit. Please choose a smaller file.');
            return;
        }

        console.log('File details:', {
            name: file.name,
            size: file.size,
            type: file.type
        });

        // Show loading state
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

        $.ajax({
            url: 'process_csv_upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    displayPreview(response.data);
                    $('#preview-section').show();
                    $('html, body').animate({
                        scrollTop: $('#preview-section').offset().top - 100
                    }, 500);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status,
                    readyState: xhr.readyState
                });
                
                // Try to parse response as JSON to get actual error
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    alert('Server Error: ' + errorResponse.message);
                } catch(e) {
                    // If not JSON, show the raw response
                    if (xhr.responseText) {
                        alert('Server Error: ' + xhr.responseText.substring(0, 200));
                    } else {
                        alert('Upload failed. Status: ' + xhr.status + ' - ' + status);
                    }
                }
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Download template
    $('#download-template').on('click', function(e) {
        e.preventDefault();
        window.location.href = 'download_csv_template.php';
    });

    function displayPreview(data) {
        var html = `
            <div class="alert alert-success">
                <h4><i class="fa fa-check"></i> File processed successfully!</h4>
                <p><strong>Total rows found:</strong> ${data.summary.total_rows}</p>
                <p><strong>Valid records:</strong> ${data.summary.valid_records}</p>
                <p><strong>Invalid records:</strong> ${data.summary.invalid_records}</p>
                <p><strong>Duplicates found:</strong> ${data.summary.duplicates}</p>
            </div>
        `;

        // Show validation errors if any
        if (data.errors && data.errors.length > 0) {
            html += `
                <div class="alert alert-warning">
                    <h4><i class="fa fa-exclamation-triangle"></i> Validation Errors</h4>
                    <ul style="margin-bottom: 0;">
            `;
            data.errors.forEach(function(error) {
                html += `<li>Row ${error.row}: ${error.message}</li>`;
            });
            html += `</ul></div>`;
        }

        // Show sample of valid data
        if (data.valid_data && data.valid_data.length > 0) {
            html += `
                <h4>Preview of Valid Records (showing first 10):</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Voter ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Year</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            var displayData = data.valid_data.slice(0, 10);
            displayData.forEach(function(row) {
                html += `
                    <tr>
                        <td>${row.voters_id}</td>
                        <td>${row.firstname}</td>
                        <td>${row.lastname}</td>
                        <td>${row.year_name}</td>
                        <td>${row.course_name}</td>
                        <td>
                            ${row.is_duplicate ? '<span class="label label-warning">Duplicate</span>' : '<span class="label label-success">New</span>'}
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table></div>`;

            if (data.valid_data.length > 10) {
                html += `<p><em>... and ${data.valid_data.length - 10} more records</em></p>`;
            }
        }

        // Import buttons
        if (data.summary.valid_records > 0) {
            html += `
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <form id="import-form">
                            <input type="hidden" name="session_id" value="${data.session_id}">
                            <div class="btn-group">
                                <button type="submit" name="import_type" value="new_only" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Import New Records Only (${data.summary.valid_records - data.summary.duplicates})
                                </button>
                                ${data.summary.duplicates > 0 ? `
                                    <button type="submit" name="import_type" value="all" class="btn btn-warning">
                                        <i class="fa fa-refresh"></i> Import All (Update Duplicates)
                                    </button>
                                ` : ''}
                            </div>
                        </form>
                    </div>
                </div>
            `;
        }

        $('#preview-content').html(html);
    }

    // Handle import form submission
    $(document).on('submit', '#import-form', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $(this).find('button[type="submit"]:focus');
        
        // Get the clicked button's value for import_type
        var clickedBtn = $(document.activeElement);
        if (clickedBtn.attr('name') === 'import_type') {
            formData += '&import_type=' + clickedBtn.val();
        }
        
        var originalText = submitBtn.html();
        
        if (!confirm('Are you sure you want to import these records? This action cannot be undone.')) {
            return;
        }

        console.log('Starting import with data:', formData);
        submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Importing...').prop('disabled', true);

        $.ajax({
            url: 'import_voters.php', // FIXED: Removed 'voters/' path
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Import response:', response);
                if (response.success) {
                    alert('Import completed successfully!\n\n' +
                          'Records imported: ' + response.imported + '\n' +
                          'Records updated: ' + response.updated + '\n' +
                          'Records skipped: ' + response.skipped);
                    
                    // Reset form and hide preview
                    $('#upload-form')[0].reset();
                    $('#preview-section').hide();
                } else {
                    alert('Import failed: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Import AJAX Error Details:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status,
                    readyState: xhr.readyState
                });
                
                // Try to parse response as JSON to get actual error
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    alert('Import Error: ' + errorResponse.message);
                } catch(e) {
                    // If not JSON, show the raw response
                    if (xhr.responseText) {
                        alert('Import Error: ' + xhr.responseText.substring(0, 200));
                    } else {
                        alert('Import failed. Status: ' + xhr.status + ' - ' + status);
                    }
                }
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});
</script>

<style>
.table th {
    background-color: #f5f5f5;
}
.alert {
    border-radius: 5px;
}
.btn-group .btn {
    margin-right: 10px;
}
</style>

</body>
</html>