<?php
// Include config.php for database connection
include_once 'config.php';

// Fetch data from seat_matrix_minor table
$sql_minor = "SELECT subject, max_seats, round1 FROM seat_matrix_minor";
$result_minor = $conn->query($sql_minor);
$minorData = [];
if ($result_minor->num_rows > 0) {
    while ($row = $result_minor->fetch_assoc()) {
        $minorData[] = $row;
    }
}

// Fetch data from seat_matrix_generic table
$sql_generic = "SELECT subject, max_seats, round1 FROM seat_matrix_generic";
$result_generic = $conn->query($sql_generic);
$genericData = [];
if ($result_generic->num_rows > 0) {
    while ($row = $result_generic->fetch_assoc()) {
        $genericData[] = $row;
    }
}

// Fetch data from seat_matrix_voc table
$sql_voc = "SELECT subject, max_seats, round1 FROM seat_matrix_voc";
$result_voc = $conn->query($sql_voc);
$vocData = [];
if ($result_voc->num_rows > 0) {
    while ($row = $result_voc->fetch_assoc()) {
        $vocData[] = $row;
    }
}

// Fetch data from seat_matrix_vac table
$sql_vac = "SELECT subject, max_seats, round1 FROM seat_matrix_vac";
$result_vac = $conn->query($sql_vac);
$vacData = [];
if ($result_vac->num_rows > 0) {
    while ($row = $result_vac->fetch_assoc()) {
        $vacData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seat Analysis</title>
<style>
body{
    overflow-x: scroll;
    min-height: 300%;
}

.container{
    overflow-x: auto;
    overflow-y: auto;
    display: inline;
}

.panel {
  display: flex;
  flex-wrap: wrap;
}

.chart {
    width: 800px;
  height: 1200px; 
  margin-bottom: 20px;
  margin: 0 0 0 10px;
  
}

</style>
</head>
<body>

<div class="panel">
  <div class="container">
      <h3>Minor Subjects</h3>
  <canvas id="minorChart" class="chart"></canvas>
  </div> 
  <div class="container">
    <h3>Generic subjects</h3>
  <canvas id="genericChart" class="chart"></canvas>
  </div>
  <div class="container">
    <h3>VOC Subjects</h3>
  <canvas id="vocChart" class="chart"></canvas>
  </div>
  <div class="container">
    <h3>VAC Subjects</h3>
  <canvas id="vacChart" class="chart"></canvas>
  </div>
  
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
// Minor subjects data
var minorData = <?php echo json_encode($minorData); ?>;

// Generic subjects data
var genericData = <?php echo json_encode($genericData); ?>;

// VOC subjects data
var vocData = <?php echo json_encode($vocData); ?>;

// VAC subjects data
var vacData = <?php echo json_encode($vacData); ?>;

// Chart for Minor subjects
var minorLabels = minorData.map(item => item.subject);
var minorRound1 = minorData.map(item => item.max_seats - item.round1);

var minorChartCtx = document.getElementById('minorChart').getContext('2d');
var minorChart = new Chart(minorChartCtx, {
    type: 'bar',
    data: {
      labels: minorLabels,
      datasets: [{
        label: 'Seats Allotted',
        data: minorRound1,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
});

// Chart for Generic subjects
var genericLabels = genericData.map(item => item.subject);
var genericRound1 = genericData.map(item => item.max_seats - item.round1);

var genericChartCtx = document.getElementById('genericChart').getContext('2d');
var genericChart = new Chart(genericChartCtx, {
    type: 'bar',
    data: {
      labels: genericLabels,
      datasets: [{
        label: 'Seats Allotted',
        data: genericRound1,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
});

// Chart for VOC subjects
var vocLabels = vocData.map(item => item.subject);
var vocRound1 = vocData.map(item => item.max_seats - item.round1);

var vocChartCtx = document.getElementById('vocChart').getContext('2d');
var vocChart = new Chart(vocChartCtx, {
    type: 'bar',
    data: {
      labels: vocLabels,
      datasets: [{
        label: 'Seats Allotted',
        data: vocRound1,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
});

// Chart for VAC subjects
var vacLabels = vacData.map(item => item.subject);
var vacRound1 = vacData.map(item => item.max_seats - item.round1);

var vacChartCtx = document.getElementById('vacChart').getContext('2d');
var vacChart = new Chart(vacChartCtx, {
    type: 'bar',
    data: {
      labels: vacLabels,
      datasets: [{
        label: 'Seats Allotted',
        data: vacRound1,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
});
</script>

</body>
</html>

