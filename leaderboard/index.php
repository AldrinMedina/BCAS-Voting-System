<?php include 'includes/session.php'; ?>
<?php include 'includes/settings.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
// Get settings from database
$anonymityMode = getBooleanSetting('anonymity_mode', true);
$votingEnabled = getBooleanSetting('voting_enabled', true);
$showVoteCount = getBooleanSetting('show_vote_count', true);
$showPercentage = getBooleanSetting('show_percentage', true);
$carouselInterval = getIntegerSetting('carousel_interval', 2000);
$refreshInterval = getIntegerSetting('results_refresh_interval', 5000);
?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <!-- Anonymity Toggle Control -->
        <!-- <div class="fixed-top" style="z-index: 1050; padding: 15px;">
            <div class="container-fluid">
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <div class="card bg-dark text-white" style="opacity: 0.9;">
                            <div class="card-body py-2 px-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="anonymityToggle" <?= $anonymityMode ? 'checked' : '' ?>>
                                    <label class="form-check-label text-white" for="anonymityToggle">
                                        <i class="fa me-1 <?= $anonymityMode ? 'fa-eye-slash' : 'fa-eye' ?>" id="anon-icon"></i>
                                        <span id="toggleLabel"><?= $anonymityMode ? 'Anonymous Mode' : 'Show Candidates' ?></span>
                                    </label>
                                </div>
                                <?php if (!$votingEnabled): ?>
                                <div class="text-warning mt-1" style="font-size: 0.8em;">
                                    <i class="fa fa-exclamation-triangle"></i> Voting Disabled
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div id="carouselExampleSlidesOnly" class="carousel slide" data-pause="false" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Carousel items will be injected here -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    
    <?php include 'includes/scripts.php'; ?>

<style>
.anonymous-image {
    filter: blur(50px);
    transition: filter 0.3s ease;
}

.anonymous-name {
    color: transparent;
    text-shadow: 0 0 8px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
    position: relative;
}

.anonymous-name::after {
    content: 'Candidate ' attr(data-position);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    color: #333;
    text-shadow: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.reveal-image {
    filter: none;
}

.reveal-name {
    color: inherit;
    text-shadow: none;
}

.reveal-name::after {
    display: none;
}

.toggle-transition {
    transition: all 0.5s ease-in-out;
}

/* Improved styling for the toggle */
.form-check-input:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}

.form-check-input:not(:checked) {
    background-color: #28a745;
    border-color: #28a745;
}

.card {
    border-radius: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.updating-settings {
    opacity: 0.6;
    pointer-events: none;
}
</style>

<script>
let isAnonymous = <?= $anonymityMode ? 'true' : 'false' ?>;
let showVoteCount = <?= $showVoteCount ? 'true' : 'false' ?>;
let showPercentage = <?= $showPercentage ? 'true' : 'false' ?>;
let carouselInterval = <?= $carouselInterval ?>;
let refreshInterval = <?= $refreshInterval ?>;

$(document).ready(function(){
    loadChart();
    generateSlide();
    setInterval(loadChart, refreshInterval);
    
    // Handle anonymity toggle
    $('#anonymityToggle').change(function() {
        const newAnonymityMode = this.checked;
        updateAnonymitySetting(newAnonymityMode);
    });
    
    // Load settings from database on page load
    loadSettings();
});

function loadSettings() {
    $.ajax({
        url: 'get_settings.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const settings = response.settings;
                
                // Update local variables
                isAnonymous = settings.anonymity_mode === '1';
                showVoteCount = settings.show_vote_count === '1';
                showPercentage = settings.show_percentage === '1';
                carouselInterval = parseInt(settings.carousel_interval) || 2000;
                refreshInterval = parseInt(settings.results_refresh_interval) || 5000;
                
                // Update UI
                $('#anonymityToggle').prop('checked', isAnonymous);
                updateAnonymityDisplay();
                updateToggleLabel();
                
                // Update carousel interval
                $('.carousel').carousel('dispose');
                $('.carousel').carousel({
                    interval: carouselInterval
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load settings:', error);
        }
    });
}

function updateAnonymitySetting(anonymityMode) {
    // Show loading state
    $('.card').addClass('updating-settings');
    
    $.ajax({
        url: 'update_setting.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            key: 'anonymity_mode',
            value: anonymityMode
        }),
        success: function(response) {
            if (response.success) {
                isAnonymous = anonymityMode;
                updateAnonymityDisplay();
                updateToggleLabel();
                console.log('Anonymity setting updated successfully');
            } else {
                console.error('Failed to update anonymity setting:', response.message);
                // Revert toggle if failed
                $('#anonymityToggle').prop('checked', isAnonymous);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error updating anonymity setting:', error);
            // Revert toggle if failed
            $('#anonymityToggle').prop('checked', isAnonymous);
        },
        complete: function() {
            // Remove loading state
            $('.card').removeClass('updating-settings');
        }
    });
}

function updateToggleLabel() {
    const label = $('#toggleLabel');
    const icon = $('#anon-icon');
    
    if (isAnonymous) {
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
        label.html('Anonymous Mode');
    } else {
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
        label.html('Show Candidates');
    }
}

function updateAnonymityDisplay() {
    if (isAnonymous) {
        $('.candidate-image').addClass('anonymous-image').removeClass('reveal-image');
        $('.candidate-name').addClass('anonymous-name').removeClass('reveal-name');
    } else {
        $('.candidate-image').removeClass('anonymous-image').addClass('reveal-image');
        $('.candidate-name').removeClass('anonymous-name').addClass('reveal-name');
    }
}

$('.carousel').carousel({
    interval: carouselInterval
});

$('.carousel').carousel('pause');

$('.carousel').hover(function(){
    $('.carousel').carousel('cycle');
});

$('.carousel').mouseleave(function(){
    $('.carousel').carousel('pause');
}); 

function loadChart(){
    $.ajax({
        url: 'get_pos.php',
        method: 'GET',
        dataType: 'json',
        success: function(pos_data) {
            $.each(pos_data, function(index, pos_item){
                let cvarray = [];
                var pos_id = pos_item.id;
                $.ajax({
                    url: 'get_cand.php',
                    method: 'POST',
                    data: {id: pos_id},
                    dataType: 'json',
                    success: function(cand_data){
                        let remainingRequests = cand_data.length;
                        
                        $.each(cand_data, function(index, cand_item){
                            $.ajax({
                                url: 'get_count.php',
                                method: 'POST',
                                data: {id: cand_item.id},
                                dataType: 'json',
                                success: function(votes_data) {
                                    cvarray.push({
                                        candln: cand_item.lastname,
                                        photo: cand_item.photo,
                                        count: votes_data
                                    });
                                    remainingRequests--;
                                    
                                    if (remainingRequests === 0) {
                                        // Sort the array after getting "Did not vote" data
                                        cvarray.sort((a, b) => b.count - a.count);
                                        generateChart(cvarray, pos_item.description);
                                    }
                                },
                                error: function(error){
                                    console.log(error);
                                }
                            });
                        });
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
        }
    });
}

function generateSlide(){
    $.ajax({
        url: 'get_pos.php',
        method: 'GET',
        dataType: 'json',
        success: function(pos_data) {
            var slideHTML = '';

            $.each(pos_data, function(index, item){
                slideHTML += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <div class="d-flex justify-content-center align-items-center w-100" style="height: 100vh; padding-top: 80px;">
                            <div class='col-sm-10'>
                                <div class='box box-solid'>
                                    <div class='box-header with-border'>
                                        <h4 class='box-title'><b>${item.description}</b></h4>
                                    </div>
                                    <div class='box-body'>
                                        <div class='chart d-flex align-items-center row pt-2' id='${convertToSlug(item.description)}' ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('.carousel-inner').html(slideHTML);
        }
    });
}

function generateChart(cvarray, pos_desc) {
    var chartHTML = '';
    var desc = '#' + convertToSlug(pos_desc);
    var total = 0;
    
    // Calculate total votes
    $.each(cvarray, function (index, item) {
        total += item.count;
    });
    
    console.log(total);
    
    // Generate chart HTML with anonymity classes
    var count = 0;
    $.each(cvarray, function (index, item) {
        count++;
        var percentage = (item.count / total) * 100;
        
        // Check if percentage is NaN and convert to 0 if true
        percentage = isNaN(percentage) ? 0 : percentage;
        
        var image = item.photo == '' ? '../images/profile.jpg' : '../images/' + item.photo;
        
        // Add anonymity classes based on current state
        var imageClass = isAnonymous ? 'candidate-image anonymous-image toggle-transition' : 'candidate-image reveal-image toggle-transition';
        var nameClass = isAnonymous ? 'candidate-name anonymous-name toggle-transition' : 'candidate-name reveal-name toggle-transition';
        
        // Build vote count display based on settings
        var voteDisplay = '';
        if (showVoteCount && showPercentage) {
            voteDisplay = `${item.count} votes`;
        } else if (showVoteCount) {
            voteDisplay = `${item.count} votes`;
        } else if (showPercentage) {
            voteDisplay = `${percentage.toFixed(1)}%`;
        } else {
            voteDisplay = 'Votes';
        }
        
        var percentageDisplay = showPercentage ? `${percentage.toFixed(1)}%` : '';
        
        chartHTML += `
            <div class="d-flex align-items-center justify-content-between mb-1">
                <div class='col-sm-3 d-flex align-content-center justify-items-center row'>
                    <div class="col-sm-12">
                        <center>
                            <img src="${image}" alt="" width="75px" height="75px" class="${imageClass}" style="border-radius: 50%; border: 3px solid #007bff;">
                        </center>
                    </div>
                    <p class="col-sm-12 text-center ${nameClass}" data-position="${count}" style="font-weight: bold; margin-top: 10px;">${item.candln}</p>
                </div>
                <div class="progress flex-grow-1 mx-3 col-sm-7" style="height: 30px; border-radius: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: ${percentage}%; border-radius: 25px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;" aria-valuenow="${item.count}" aria-valuemin="0" aria-valuemax="${total}">
                        ${voteDisplay}
                    </div>
                </div>
                <span class="col-sm-2 text-center" style="font-size: 1.2em; font-weight: bold; color: #007bff;">${percentageDisplay}</span>
            </div>
        `;
    });

    $(desc).html(chartHTML);
}

function convertToSlug(Text) {
    return Text.toLowerCase()
        .replace(/[^\w ]+/g, "")
        .replace(/ +/g, "-");
}
</script>

</body>
</html>