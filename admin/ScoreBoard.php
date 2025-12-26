<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
<style>
#carousel-iframe {
  width: 100%;
  height: 100%;
  border: none;
  overflow: hidden;
}
#carousel-iframe {
  transition: opacity 0.5s; /* add a 0.5s fade-in effect */
}
</style>
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Statistics
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Statistics</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content" style="height:80vh;">
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
      <div class="row" style="height:80vh;">
        <div class="col-xs-12" style="height:80vh;">
          <div class="box" style="height:80vh;">
            <div class="box-body" style="height:80vh;">
              <div class = "chart-container" style="height:75vh;">
                <iframe src="" id = "carousel-iframe" style="height: 100%; width:100%;" scrolling="no" ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>


  <?php include 'includes/footer.php'; ?>
</div>
<script>
const phpSources = ["MostWinning.php", "VoteDistribution.php", "CourseVotes.php", "GradeVotes.php"]; // your array of PHP page sources

// Get the iframe element
const iframe = document.getElementById('carousel-iframe');

// Initialize the current index
let currentIndex = 0;

// Function to update the iframe's src attribute
function updateIframeSrc() {
  iframe.style.opacity = 0; // set opacity to 0 before updating src
  iframe.src = phpSources[currentIndex];
  iframe.onload = function() { // wait for the iframe to finish loading
    iframe.style.opacity = 1; // set opacity back to 1 after load
    currentIndex = (currentIndex + 1) % phpSources.length; // increment currentIndex here
  };
}

// Function to cycle through the PHP pages
function cycleThroughPages() {
  updateIframeSrc();
}

// Set the interval to cycle through the pages every 5 seconds (adjust to your liking)
setInterval(cycleThroughPages, 3000);

// Set the interval to cycle through the pages every 5 seconds (adjust to your liking)
setInterval(cycleThroughPages, 3000);

// Initialize the iframe with the first PHP page
updateIframeSrc();
</script>
</body>
</html>
