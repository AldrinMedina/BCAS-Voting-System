<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
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

<script>
$(document).ready(function(){
    console.log('hello');
    loadChart();
    generateSlide();
    setInterval(loadChart, 5000);
});

$('.carousel').carousel({
    interval: 2000
});

$('.carousel').carousel('pause') ;

$('.carousel').hover(function(){
    $('.carousel').carousel('cycle') ;
}) ;

$('.carousel').mouseleave(function(){
    $('.carousel').carousel('pause') ;
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
                        <div class="d-flex justify-content-center align-items-center w-100" style="height: 100vh;">
                            <div class='col-sm-10'>
                                <div class='box box-solid'>
                                    <div class='box-header with-border'>
                                        <h4 class='box-title'><b>${item.description}</b></h4>
                                    </div>
                                    <div class='box-body'>
                                        <div class='chart d-flex align-items-center row' id='${convertToSlug(item.description)}' ">
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
    var chartHTML = ''; // Initialize chartHTML with an empty string
    var desc = '#' + convertToSlug(pos_desc); // Ensure the selector is properly formed
    var total = 0;
    
    // Calculate total votes
    $.each(cvarray, function (index, item) {
        total += item.count;
    });
    
    console.log(total);
    
    // Generate chart HTML
    var count = 0;
    $.each(cvarray, function (index, item) {
        count++;
        var percentage = (item.count / total) * 100;
        
        // Check if percentage is NaN and convert to 0 if true
        percentage = isNaN(percentage) ? 0 : percentage;
        
        var image = item.photo == '' ? '../images/profile.jpg' : '../images/' + item.photo;
        //var image ='../images/profile.jpg';
        chartHTML += `
            <div class="d-flex align-items-center justify-content-between">
                <div class='col-sm-3 d-flex align-content-center justify-items-center row'>
                    <div class="col-sm-12">
                        <center>
                            <img src="${image}" alt="" width="100px" height="100px">
                        </center>
                    </div>
                    <p class="col-sm-12 text-center">${item.candln}</p>
                </div>
                <div class="progress flex-grow-1 mx-3 col-sm-7" style="height: 50px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: ${percentage}%" aria-valuenow="${item.count}" aria-valuemin="0" aria-valuemax="${total}"></div>
                </div>
                <span class="col-sm-2">${percentage.toFixed(2)}%</span>
            </div>
            <br>
        `;
    });

    $(desc).html(chartHTML); // Update the HTML content of the selected element
}


function convertToSlug(Text) {
  return Text.toLowerCase()
    .replace(/[^\w ]+/g, "")
    .replace(/ +/g, "-");
}
</script>

</body>
</html>
