<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini">
  <style>
    .progress {
      margin-left: 15px; /* Adds some left margin */
    }

    .text-center {
      text-align: center; /* Ensures all text is centered properly */
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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM positions";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>

              <p>No. of Positions</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="positions.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM candidates";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
          
              <p>No. of Candidates</p>
            </div>
            <div class="icon">
              <i class="fa fa-black-tie"></i>
            </div>
            <a href="candidates.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php
                $sql = "SELECT * FROM voters";
                $query = $conn->query($sql);

                echo "<h3>".$query->num_rows."</h3>";
              ?>
             
              <p>Total Voters</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="voters.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="voters_voted"></h3>

              <p>Voters Voted</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <a href="votes.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-xs-12">
          <h3>Votes Tally
            <span class="pull-right">
              <a href="print.php" class="btn btn-success btn-sm btn-flat"><span class="glyphicon glyphicon-print"></span> Print</a>
            </span>
          </h3>
        </div>
      </div>

      <?php
        $sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $conn->query($sql);
        $inc = 2;
        while($row = $query->fetch_assoc()){
          $inc = ($inc == 2) ? 1 : $inc+1; 
          if($inc == 1) echo "<div class='row'>";
          echo "
            <div class='col-sm-6'>
              <div class='box box-solid'>
                <div class='box-header with-border'>
                  <h4 class='box-title'><b>".$row['description']."</b></h4>
                </div>
                <div class='box-body'>
                  <div class='chart d-flex align-items-center row' id='".slugify($row['description'])."'>
                    
                  </div>
                </div>
              </div>
            </div>
          ";
          if($inc == 2) echo "</div>";  
        }
        if($inc == 1) echo "<div class='col-sm-6'></div></div>";
      ?>

      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
  $(document).ready(function(){
    loadChart();
    setInterval(loadChart, 5000);
  });
  function loadChart(){
    votedCount();
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
                                        $.ajax({
                                            url: 'get_nocount.php',
                                            method: 'POST',
                                            data: {id: pos_id},
                                            dataType: 'json',
                                            success: function(novotes_data) {
                                                cvarray.push({
                                                    candln: 'Did not vote',
                                                    photo: 'novote.png',
                                                    count: novotes_data
                                                });

                                                // Sort the array after getting "Did not vote" data
                                                cvarray.sort((a, b) => b.count - a.count);
                                                generateChart(cvarray, pos_item.description);
                                            },
                                            error: function(error){
                                                console.log(error);
                                            }
                                        });
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

  function generateChart(cvarray, pos_desc) {
    var chartHTML = ''; // Initialize chartHTML with an empty string
    var desc = '#' + convertToSlug(pos_desc); // Ensure the selector is properly formed
    var total = 0;
    $.each(cvarray, function (index, item) { total += item.count; });
    console.log(total);
    $.each(cvarray, function (index, item) {
        var percentage = (item.count / total) * 100;
        var image = item.photo == '' ? '../images/profile.jpg' : '../images/' + item.photo;
        chartHTML += `
            <div class="d-flex align-items-center justify-content-between col-sm-12 mb-3">
                <div class='col-sm-3 text-center'>
                    <img src="${image}" alt="" class="img-fluid rounded-circle" width="80" height="80">
                    <p class="mt-2">${item.candln}</p>
                </div>
                <div class="progress col-sm-7" style="height: 30px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: ${percentage}%" aria-valuenow="${item.count}" aria-valuemin="0" aria-valuemax="${total}"></div>
                </div>
                <span class="col-sm-2 text-center">${item.count} votes</span>
            </div>
        `;
    });

    $(desc).html(chartHTML); // Update the HTML content of the selected element
  }


function votedCount(){
  $.ajax({
    url: 'get_voted.php',
    method: 'GET',
    dataType: 'json',
    success: function(votes_data) {
        $('#voters_voted').text(votes_data);
    },
    error: function(error){
        console.log(error);
    }
  });
}

function convertToSlug(Text) {
  return Text.toLowerCase()
    .replace(/[^\w ]+/g, "")
    .replace(/ +/g, "-");
}

</script>
</body>
</html>