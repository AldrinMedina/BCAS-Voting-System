<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script>
  <style>

        .chart-container {
            width: 500px; /* Set the width to 400px */
            height: 80%; /* Set the height to 400px */
        }
    </style>
<?php
$stmt = $conn->prepare("SELECT 
                            c.partylist_id, 
                            COUNT(v.id) AS num_votes,
                            p.partylist AS partylist
                        FROM candidates c
                        LEFT JOIN votes v
                        ON c.id = v.candidate_id
                        JOIN party p
                        ON c.partylist_id = p.id
                        GROUP BY c.partylist_id;");
$stmt->execute();
$result = $stmt->get_result();

$labels = array();
$data = array();

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['partylist'];
    $data[] = $row['num_votes'];
}
?>
<body>
<center>
    <div class="chart-container">
<h1>Party Vote Distribution</h1>
        <canvas id="doughnut-chart"></canvas>
    </div>
</center>
    <script>
        var ctx = document.getElementById('doughnut-chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Votes',
                    data: <?php echo json_encode($data); ?>,
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
responsive: true, // <--- Add this line
    maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'bottom' 
// Move the legend to the bottom
                },
                plugins: {
                    datalabels: {
                        display: true,
                        formatter: function(value, ctx) {
                            var sum = ctx.dataset.data.reduce(function(a, b) {
                                return a + b;
                            }, 0);

                            return value + ' out of ' + sum.toLocaleString();
                        },
                        color: 'black',
                        font: {
                            size: 18
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>