
<?php include 'includes/session.php'; ?>
<?php include 'includes/slugify.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini"></body>
<?php include 'includes/scripts.php'; ?>
    <style>
.main {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  flex-flow: row wrap;
}


</style>
<div class="wrapper">
  
<?php include 'includes/navbar.php'; ?>
<?php include 'includes/menubar.php'; ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Candidate Demographics
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-chart-simple"></i> Home</a></li>
        <li class="active">Candidate Demographics</li>
      </ol>
    </section>
<body>

<?php

$sql = "
    SELECT 
        p.id AS PartyID,
        p.partylist AS PartyName,
        cd.id AS CandidateID,
        cd.lastname AS Candidate
    FROM 
        candidates cd
        INNER JOIN party p ON cd.partylist_id = p.id
    ORDER BY 
        p.partylist, cd.lastname;
";

$result = $conn->query($sql);

$partylists = array();
while ($row = $result->fetch_assoc()) {
    if (!isset($partylists[$row["PartyID"]])) {
        $partylists[$row["PartyID"]] = array("PartyName" => $row["PartyName"], "Candidates" => array());
    }
    $partylists[$row["PartyID"]]["Candidates"][$row["CandidateID"]] = $row["Candidate"];
}
$query3 = "SELECT 
  c.id AS candidate, 
  p.partylist AS party, 
  y.description AS year, 
  COUNT(DISTINCT v.voters_id) AS year_voters, 
  (SELECT COUNT(DISTINCT v2.voters_id) 
   FROM votes v2 
   WHERE v2.candidate_id = c.id) AS total_votes 
FROM 
  votes v 
  JOIN voters vo ON v.voters_id = vo.id 
  JOIN years y ON vo.year = y.id 
  JOIN candidates c ON v.candidate_id = c.id 
  JOIN party p ON c.partylist_id = p.id 
GROUP BY 
  c.lastname, 
  p.partylist, 
  y.description, 
  c.position_id 
ORDER BY 
  p.partylist, 
  c.lastname, 
  y.description";

$query4 = "SELECT 
             c.id AS candidate, 
             p.partylist AS party, 
             co.description AS courses, 
             COUNT(DISTINCT v.voters_id) AS course_voters,
             (SELECT COUNT(DISTINCT v2.voters_id) 
              FROM votes v2 
              WHERE v2.candidate_id = c.id) AS total_votes
          FROM votes v 
          JOIN voters vo ON v.voters_id = vo.id 
          JOIN course co ON vo.course = co.id 
          JOIN candidates c ON v.candidate_id = c.id 
          JOIN party p ON c.partylist_id = p.id 
          GROUP BY 
            c.lastname, 
            p.partylist, 
            co.description, 
            c.position_id 
          ORDER BY 
            p.partylist, 
            c.lastname, 
  co.description";
$result3 = mysqli_query($conn, $query3);
$yearsData = array();
while ($row = mysqli_fetch_assoc($result3)) {
  $yearsData[] = array(
    'candidate' => $row['candidate'],
    'platform' => $row['party'],
    'year' => $row['year'],
    'year_voters' => $row['year_voters'],
    'total_votes' => $row['total_votes']
  );
}



$result4 = mysqli_query($conn, $query4);
$coursesData = array();
while ($row = mysqli_fetch_assoc($result4)) {
  $coursesData[] = array(
    'candidate' => $row['candidate'],
    'platform' => $row['party'],
    'course' => $row['courses'],
    'course_voters' => $row['course_voters'],
    'total_votes' => $row['total_votes']
  );
}

// Automatically populate the chart data arrays
$chartData = array(
  'years' => $yearsData,
  'courses' => $coursesData
);

// You can now use the $chartData array to populate your chart
echo '<script>';
echo 'var chartData = ' . json_encode($chartData) . ';';
echo '</script>';
?>
<div class = "main">
<div class="row" style="width: 100%;">
<div class = "Party col-md-4">
    
<?php foreach ($partylists as $partyID => $partyInfo) {
    echo "<div class='party-info row'><h2>Party: " . $partyInfo["PartyName"] . "</h2>";
    echo`<div class="col-md-6"></div>
    `;
    foreach ($partyInfo["Candidates"] as $candidateID => $candidate) {
        echo "<button class='btn btn-default btn-block' onclick='getVoterInfo(\"" . $candidateID . "\")'>" . $candidate . "</button><br>";
    }
    echo "
    
    </div>";
}
?>
</div>
<div class = "canvas col-md-8">
<canvas id="year-pie" ></canvas>
<canvas id="course-pie" ></canvas>
</div>
</div>  
</div>
<script>
  var chartData = <?php echo json_encode($chartData); ?>;
var candidateData = {};
var yearLabels = [];
var yearData = [];
var courseLabels = [];
var courseData = [];

var yearPieData = {
  labels: yearLabels,
  datasets: [{
    data: yearData,
    backgroundColor: ['#FF6384'],
    hoverBackgroundColor: ['#FF6384']
  }]
};

var coursePieData = {
  labels: courseLabels,
  datasets: [{
    data: courseData,
    backgroundColor: ['#36A2EB'],
    hoverBackgroundColor: ['#36A2EB']
  }]
};

var ctxYear = document.getElementById('year-pie').getContext('2d');
var yearPie = new Chart(ctxYear, {
  type: 'pie',
  data: yearPieData,
  options: {
    title: {
      display: true,
      text: 'Voters by Year'
    }
  }
});

var ctxCourse = document.getElementById('course-pie').getContext('2d');
var coursePie = new Chart(ctxCourse, {
  type: 'pie',
  data: coursePieData,
  options: {
    title: {
      display: true,
      text: 'Voters by Course'
    }
  }
});
function getVoterInfo(candidateID) {
  yearPie.destroy();
  coursePie.destroy();
  
  yearLabels.length = 0;
  yearData.length = 0;
  courseLabels.length = 0;
  courseData.length = 0;
  
  for (var i = 0; i < chartData.years.length; i++) {
    if (chartData.years[i].candidate == candidateID) {
      yearLabels.push(chartData.years[i].year);
      var yearVoters = chartData.years[i].year_voters;
      var totalVotes = chartData.years[i].total_votes;
      var percentage = (yearVoters / totalVotes) * 100;
      yearData.push(percentage.toFixed(2));
    }
  }
  
  for (var i = 0; i < chartData.courses.length; i++) {
    if (chartData.courses[i].candidate == candidateID) {
      courseLabels.push(chartData.courses[i].course);
      var courseVoters = chartData.courses[i].course_voters;
      var totalVotes = chartData.courses[i].total_votes;
      var percentage = (courseVoters / totalVotes) * 100;
      courseData.push(percentage.toFixed(2));
    }
  }
  
yearPie = new Chart(ctxYear, {
  type: 'pie',
  data: {
    labels: yearLabels,
    datasets: [{
      data: yearData,
      backgroundColor: ['#FF6384'],
      hoverBackgroundColor: ['#FF6384']
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Voters by Year'
    },
    plugins: {
      datalabels: {
        display: true,
        formatter: function(value, ctx) {
          return value + '%';
        },
        color: 'white',
        font: {
          weight: 'bold'
        }
      }
    }
  }
});
  
coursePie = new Chart(ctxCourse, {
  type: 'pie',
  data: {
    labels: courseLabels,
    datasets: [{
      data: courseData,
      backgroundColor: ['#36A2EB'],
      hoverBackgroundColor: ['#36A2EB']
    }]
  },
  options: {
    title: {
      display: true,
      text: 'Voters by Course'
    },
    plugins: {
      datalabels: {
        display: true,
        formatter: function(value, ctx) {
          return value + '%';
        },
        color: 'white',
        font: {
          weight: 'bold'
        }
      }
    }
  }
});}
</script>

