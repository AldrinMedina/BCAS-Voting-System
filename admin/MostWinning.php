<?php include 'includes/session.php'; ?>
<?php include 'includes/scripts.php'; ?>
<?php include 'includes/slugify.php'; ?>
<html>
  <head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <style>
      .parent-container {
        display: flex;
        width: 100%;
      }
      .chart-container {
        width: 500px; /* Set the width to 400px */
        height: 500px; /* Set the height to 400px */
        flex: 1;

      }
      </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
<body >

<?php
$query = "
  SELECT 
    c.partylist_id, 
    COUNT(v.id) AS positions_won,
    p.partylist AS partylist
  FROM 
    candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    LEFT JOIN party p ON c.partylist_id = p.id
  WHERE 
    v.id IS NULL OR v.id = (SELECT id FROM votes v2 WHERE v2.candidate_id = c.id ORDER BY v2.id DESC LIMIT 1)
  GROUP BY 
    c.partylist_id
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  $platforms = array();
  $positionsWon = array();
  
  while ($row = mysqli_fetch_assoc($result)) {
    $platforms[] = $row['partylist'];
    $positionsWon[] = $row['positions_won'];
  }
  

  ?>
<center>
<div class = "chart-container">
<h1>Winning Positions</h1>
  <canvas id="chart" width="100%" height="80%"></canvas>
</div>
<script>
  var ctx = document.getElementById("chart").getContext("2d");
  var chart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
      labels: <?php echo json_encode($platforms); ?>,
      datasets: [{
        label: 'Positions Won',
        data: <?php echo json_encode($positionsWon); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
        datalabels: {
          display: true,
          formatter: function(value, context) {
            var totalPositions = <?php
              $query = "SELECT COUNT(DISTINCT id) AS count FROM positions";
              $result = mysqli_query($conn, $query);
              $row = mysqli_fetch_assoc($result);
              echo $row['count'];
            ?>;
        return value + ' out of ' + totalPositions ;

          },    color: 'black',
                        font: {
                            size: 18
                        }
        }
      }]
    },
    options: {
legend: {
      display: false

    },
      scales: {
        yAxes: [{
          display: true,
          ticks: {

            beginAtZero: true
          }
        }],
        xAxes: [{
          display: true,
          ticks: {
            beginAtZero: true,
            stepSize: 1
          },
          afterDataLimits: function(scale) {
            <?php
              $query = "SELECT COUNT(DISTINCT id) AS count FROM positions";
              $result = mysqli_query($conn, $query);
              $row = mysqli_fetch_assoc($result);
              echo "scale.max = " . $row['count'] . ";";
            ?>
          }
        }]
      }
    }
  });
</script>
  <?php
} else {
  echo "No data found";
}

mysqli_close($conn);
?>



</center>
</body>

</html>