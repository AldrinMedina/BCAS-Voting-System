<!-- settings/eligibility_modal.php -->
<div class="modal fade" id="eligibility">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-users"></i> Configure Voting Eligibility</h4>
            </div>
            <form class="form-horizontal" method="POST" action="settings/update_eligibility.php">
                <div class="modal-body">
                    
                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        <strong>Configure who can vote:</strong> Select specific year levels and courses, or allow all students to vote.
                    </div>

                    <!-- Year Level Selection -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Year Levels:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="year_restriction" value="all" 
                                               <?php echo ($restrictions['allowed_years'] == 'all') ? 'checked' : ''; ?>>
                                        <strong>All Year Levels</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="year_restriction" value="specific" 
                                               <?php echo ($restrictions['allowed_years'] != 'all') ? 'checked' : ''; ?>>
                                        <strong>Specific Year Levels:</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="row year-checkboxes" style="margin-top: 10px; margin-left: 20px;">
                                <?php 
                                $allowed_years = ($restrictions['allowed_years'] != 'all') ? json_decode($restrictions['allowed_years'], true) : [];
                                foreach($years as $year): 
                                ?>
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="allowed_years[]" value="<?php echo $year['id']; ?>"
                                               <?php echo (in_array($year['id'], $allowed_years)) ? 'checked' : ''; ?>>
                                        <?php echo $year['description']; ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Course Selection -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Courses:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="course_restriction" value="all" 
                                               <?php echo ($restrictions['allowed_courses'] == 'all') ? 'checked' : ''; ?>>
                                        <strong>All Courses</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input type="radio" name="course_restriction" value="specific" 
                                               <?php echo ($restrictions['allowed_courses'] != 'all') ? 'checked' : ''; ?>>
                                        <strong>Specific Courses:</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="row course-checkboxes" style="margin-top: 10px; margin-left: 20px; max-height: 200px; overflow-y: auto;">
                                <?php 
                                $allowed_courses = ($restrictions['allowed_courses'] != 'all') ? json_decode($restrictions['allowed_courses'], true) : [];
                                foreach($courses as $course): 
                                ?>
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="allowed_courses[]" value="<?php echo $course['id']; ?>"
                                               <?php echo (in_array($course['id'], $allowed_courses)) ? 'checked' : ''; ?>>
                                        <?php echo $course['description']; ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i>
                        <strong>Note:</strong> Changes will affect all future voting sessions. Students who don't meet the criteria will not be able to access the voting page.
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success btn-flat" name="save_eligibility">
                        <i class="fa fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle year restriction radio buttons
    $('input[name="year_restriction"]').change(function() {
        if ($(this).val() === 'all') {
            $('.year-checkboxes input[type="checkbox"]').prop('disabled', true).prop('checked', false);
        } else {
            $('.year-checkboxes input[type="checkbox"]').prop('disabled', false);
        }
    });

    // Handle course restriction radio buttons
    $('input[name="course_restriction"]').change(function() {
        if ($(this).val() === 'all') {
            $('.course-checkboxes input[type="checkbox"]').prop('disabled', true).prop('checked', false);
        } else {
            $('.course-checkboxes input[type="checkbox"]').prop('disabled', false);
        }
    });

    // Initialize state based on current selections
    if ($('input[name="year_restriction"]:checked').val() === 'all') {
        $('.year-checkboxes input[type="checkbox"]').prop('disabled', true);
    }
    if ($('input[name="course_restriction"]:checked').val() === 'all') {
        $('.course-checkboxes input[type="checkbox"]').prop('disabled', true);
    }

    // Form validation
    $('#eligibility form').on('submit', function(e) {
        var yearRestriction = $('input[name="year_restriction"]:checked').val();
        var courseRestriction = $('input[name="course_restriction"]:checked').val();

        if (yearRestriction === 'specific') {
            if ($('.year-checkboxes input[type="checkbox"]:checked').length === 0) {
                e.preventDefault();
                alert('Please select at least one year level or choose "All Year Levels".');
                return false;
            }
        }

        if (courseRestriction === 'specific') {
            if ($('.course-checkboxes input[type="checkbox"]:checked').length === 0) {
                e.preventDefault();
                alert('Please select at least one course or choose "All Courses".');
                return false;
            }
        }
    });
});
</script>