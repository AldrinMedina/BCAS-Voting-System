<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/session.php'; ?>
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
</head>
<?php
$query = "SELECT 
             p.partylist AS party, 
             COUNT(DISTINCT v.voters_id) AS total_voters 
          FROM votes v 
          JOIN candidates c ON v.candidate_id = c.id 
          JOIN party p ON c.partylist_id = p.id
          GROUP BY c.partylist_id";

$result = $conn->query($query);

$party_voters = array();
while($row = $result->fetch_assoc()) {
    $party_voters[$row["party"]] = $row["total_voters"];
}

$query3 = "SELECT 
             y.description AS year, 
             p.partylist AS party, 
             COUNT(DISTINCT v.voters_id) AS year_voters 
          FROM votes v 
          JOIN voters vo ON v.voters_id = vo.id 
          JOIN years y ON vo.year = y.id 
          JOIN candidates c ON v.candidate_id = c.id 
          JOIN party p ON c.partylist_id = p.id
          GROUP BY y.description, c.partylist_id";

$result3 = $conn->query($query3);
$partyCharts = array();

if ($result3->num_rows > 0) {
    while($row = $result3->fetch_assoc()) {
        $percentage = number_format(($row["year_voters"] / $party_voters[$row["party"]]) * 100, 2);


        // Add data to the chart array for each party
        if (!isset($partyCharts[$row["party"]])) {
            $partyCharts[$row["party"]] = array();
        }
        $partyCharts[$row["party"]][] = array(
            'label' => $row["year"],
            'value' => $percentage
        );
    }
} else {
    echo "0 results";
}?>
<center>
<h1>Voters By Year</h1>
<div class = "parent-container">
<?php foreach ($partyCharts as $party => $chartData) { ?>
<div class = "chart-container">
  <canvas id="chart-<?php echo slugify($party); ?>" width="400" height="400"></canvas>
</div>

  <script>
    var ctx = document.getElementById('chart-<?php echo slugify($party); ?>').getContext('2d');


    var chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: <?php echo json_encode(array_column($chartData, 'label')); ?>,
        datasets: [{
          label: 'Voter Percentage',
          data: <?php echo json_encode(array_column($chartData, 'value')); ?>,
datalabels: {
            display: true,
      formatter: function(value, ctx) {
          var labelIndex = ctx.dataIndex;
          return ctx.chart.data.labels[labelIndex] + ': ' + value + '%';
            }
          },
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            // Add more colors as needed
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            // Add more colors as needed
          ],
          borderWidth: 1
        }]
      },
     options: {
    title: {
      display: true,
          text: '<?php echo json_encode($party); ?>'
    },
    maintainAspectRatio: false, // Add this to allow resizing
    width: 500, // Set a fixed width
    height: 500 // Set a fixed height
  }
});
  </script>
<?php } ?>
</div>
</center>