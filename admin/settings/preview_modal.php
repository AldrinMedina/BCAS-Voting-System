<!-- settings/preview_modal.php -->
<div class="modal fade" id="preview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-eye"></i> Preview Eligible Voters</h4>
            </div>
            <div class="modal-body">
                <div id="eligible-voters-content">
                    <!-- Content will be loaded via AJAX -->
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                        <p>Loading eligible voters...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
                <button type="button" class="btn btn-info btn-flat" id="refresh-preview">
                    <i class="fa fa-refresh"></i> Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Load eligible voters when modal is opened
    $('#preview').on('show.bs.modal', function() {
        loadEligibleVoters();
    });

    // Refresh button
    $('#refresh-preview').on('click', function() {
        loadEligibleVoters();
    });

    function loadEligibleVoters() {
        $('#eligible-voters-content').html(`
            <div class="text-center">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
                <p>Loading eligible voters...</p>
            </div>
        `);

        $.ajax({
            url: 'settings/get_eligible_voters.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    $('#eligible-voters-content').html(`
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                            Error: ${response.error}
                        </div>
                    `);
                } else {
                    displayEligibleVoters(response);
                }
            },
            error: function() {
                $('#eligible-voters-content').html(`
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                        Failed to load eligible voters. Please try again.
                    </div>
                `);
            }
        });
    }

    function displayEligibleVoters(data) {
        let html = `
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h4><i class="fa fa-info-circle"></i> Eligibility Summary</h4>
                        <p><strong>Total Eligible Voters:</strong> ${data.total_eligible}</p>
                        <p><strong>Total Registered Students:</strong> ${data.total_students}</p>
                        <p><strong>Percentage Eligible:</strong> ${data.percentage}%</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fa fa-calendar"></i> Breakdown by Year Level</h5>
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Year Level</th>
                                    <th class="text-center">Eligible</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        data.year_breakdown.forEach(function(year) {
            html += `
                <tr ${year.eligible > 0 ? 'class="success"' : 'class="warning"'}>
                    <td>${year.description}</td>
                    <td class="text-center">${year.eligible}</td>
                    <td class="text-center">${year.total}</td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5><i class="fa fa-graduation-cap"></i> Breakdown by Course</h5>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th class="text-center">Eligible</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
        `;

        data.course_breakdown.forEach(function(course) {
            html += `
                <tr ${course.eligible > 0 ? 'class="success"' : 'class="warning"'}>
                    <td>${course.description}</td>
                    <td class="text-center">${course.eligible}</td>
                    <td class="text-center">${course.total}</td>
                </tr>
            `;
        });

        html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <h5><i class="fa fa-list"></i> Current Filter Settings</h5>
                    <div class="well well-sm">
                        <p><strong>Year Levels:</strong> ${data.filter_settings.years}</p>
                        <p><strong>Courses:</strong> ${data.filter_settings.courses}</p>
                        <p><strong>Voting Status:</strong> 
                            <span class="label ${data.filter_settings.is_active ? 'label-success' : 'label-danger'}">
                                ${data.filter_settings.is_active ? 'ACTIVE' : 'INACTIVE'}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        `;

        $('#eligible-voters-content').html(html);
    }
});
</script>