<!DOCTYPE html>
<html>
<?php
include ('head.php');
?>
<body>
<?php
    include ('header.php');
    include ('search_bar.php');
    include ('_connection.php');

            // Delivery Length - Runs VS Count
            $query1 = $con->query(
                "SELECT Delivery_Length, SUM(Count) AS count
                FROM rk_length_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' 
                AND Delivery_Length <> 'Unknown'
                GROUP BY Delivery_Length
                HAVING count > 1
                ");
            foreach($query1 as $data1)
            {
              $Delivery_Length1[] = $data1['Delivery_Length'];
              $Delivery_Length1_Count[] = $data1['count'];
            }

            // Delivery Length VS Runs
            $query2 = $con->query(
                "SELECT Delivery_Length, SUM(Runs) AS runs
                FROM rk_length_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' 
                AND Runs <> -1 AND Delivery_Length <> 'Unknown'
                GROUP BY Delivery_Length
                HAVING runs > 1
                ");
            foreach($query2 as $data2)
            {
              $Delivery_Length2[] = $data2['Delivery_Length'];
              $Delivery_Length2_Runs[] = $data2['runs'];
            }

            // Delivery Line VS Count
            $query3 = $con->query(
                "SELECT Delivery_Line, SUM(Count) AS count
                FROM rk_line_runs_aovers 
                WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line'
                AND Delivery_Line <> 'Unknown'
                GROUP BY Delivery_Line
                HAVING count > 1
                ");
            foreach($query3 as $data3)
            {
              $Delivery_Line1[] = $data3['Delivery_Line'];
              $Delivery_Line1_Count[] = $data3['count'];
            }

            // Delivery Line VS Runs
            $query4 = $con->query(
                "SELECT Delivery_Line, SUM(Runs) AS runs
                FROM rk_line_runs_aovers 
                WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line' AND Runs <> -1
                AND Delivery_Line <> 'Unknown'
                GROUP BY Delivery_Line
                HAVING runs > 1
                ");
            foreach($query4 as $data4)
            {
              $Delivery_Line2[] = $data4['Delivery_Line'];
              $Delivery_Line2_Runs[] = $data4['runs'];
            }

            // Delivery Line Length Run VS Count
            $query5 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' ( ', Runs, ' ) ') AS xAxis, SUM(Count) AS count
                FROM rk_length_line_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query5 as $data5)
            {
              $Delivery_Line_Length[] = $data5['xAxis'];
              $Delivery_Line_Length_Count[] = $data5['count'];
            }

            // Delivery Line Length Out Count
            $query6 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
                FROM rk_length_line_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown'
                AND Runs = -1
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query6 as $data6)
            {
              $Delivery_Line_Length2[] = $data6['xAxis'];
              $Delivery_Line_Length_Count2[] = $data6['count'];
            }

            // Delivery Line Length Runs
            $query7 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Runs) AS runs
                FROM rk_length_line_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Runs <> -1
                GROUP BY xAxis
                HAVING runs > 1
                ");
            foreach($query7 as $data7)
            {
              $Delivery_Line_Length3[] = $data7['xAxis'];
              $Delivery_Line_Length3_Runs[] = $data7['runs'];
            }

            // Delivery Type Count
            $query8 = $con->query(
                "SELECT Delivery_type, SUM(Count) AS count
                FROM rk_deliverytype_runs_aovers 
                WHERE Delivery_type <> 'Null' AND Delivery_type <> 'Delivery_type'
                AND Delivery_type <> 'Unknown'
                GROUP BY Delivery_type
                HAVING count > 1
                ");
            foreach($query8 as $data8)
            {
              $Delivery_Type1[] = $data8['Delivery_type'];
              $Delivery_Type1_Count[] = $data8['count'];
            }

            // Delivery Type Runs
            $query9 = $con->query(
                "SELECT Delivery_type, SUM(Runs) AS runs
                FROM rk_deliverytype_runs_aovers 
                WHERE Delivery_type <> 'Null' AND Delivery_type <> 'Delivery_type' 
                AND Runs <> -1 AND Delivery_type <> 'Unknown'
                GROUP BY Delivery_type
                HAVING runs > 1
                ");
            foreach($query9 as $data9)
            {
              $Delivery_Type2[] = $data9['Delivery_type'];
              $Delivery_Type2_Runs[] = $data9['runs'];
            }

            // line length type count
            $query10 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Delivery_type) AS xAxis, SUM(Count) AS count
            FROM rk_length_line_deliverytype_runs 
            WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Delivery_type <> 'Null'
            AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Delivery_type <> 'Unknown'
            GROUP BY xAxis
            HAVING count > 1
            ");
            foreach($query10 as $data10)
            {
              $Delivery_Length_line_type[] = $data10['xAxis'];
              $Delivery_Length_line_type_Count[] = $data10['count'];
            }

            // line length type runs
            $query11 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Delivery_type) AS xAxis, SUM(Runs) AS runs
            FROM rk_length_line_deliverytype_runs 
            WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Delivery_type <> 'Null'
            AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Delivery_type <> 'Unknown' AND Runs <> -1
            GROUP BY xAxis
            HAVING runs > 1
            ");
            foreach($query11 as $data11)
            {
              $Delivery_Length_line_type2[] = $data11['xAxis'];
              $Delivery_Length_line_type2_Runs[] = $data11['runs'];
            }

            // line length type out
            $query12 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Delivery_type) AS xAxis, SUM(Count) AS count
            FROM rk_length_line_deliverytype_runs 
            WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Delivery_type <> 'Null'
            AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Delivery_type <> 'Unknown' 
            AND Runs = -1
            GROUP BY xAxis
            ");
            foreach($query12 as $data12)
            {
              $Delivery_Length_line_type3[] = $data12['xAxis'];
              $Delivery_Length_line_type3_Count[] = $data12['count'];
            }
?>

<div style="margin-left: 120px;"><h2><strong>Delivery Length</strong></h2>
<p>Most occurence</p>
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart1"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Length</strong></h2>
<p>Most Runs</p>
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart2"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line</strong></h2>
<p>Most occurence</p>   
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart3"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line</strong></h2>
<p>Most Runs</p>
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart4"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line - Length - Runs</strong></h2>
<p>Most occurence</p>   
        <div style="margin-left: 120px; width: 845px; height: 500px">
          <canvas id="myChart5"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line - Length - Out</strong></h2>
<p>Most occurence</p>   
        <div style="margin-left: 120px; width: 845px; height: 500px">
          <canvas id="myChart6"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line And Length</strong></h2>
<p>Most Runs</p>
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart7"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Type</strong></h2>
<p>Most occurence</p>     
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart8"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Type</strong></h2>
<p>Most Runs</p>   
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart9"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line Length Type</strong></h2>
<p>Most occurence</p>     
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart10"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line Length Type</strong></h2>
<p>Most Runs</p>    
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart11"></canvas>
        </div>
</div>

<div style="margin-left: 120px;"><h2><strong>Delivery Line Length Type - OUT</strong></h2>
<p>Most occurence</p>     
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart12"></canvas>
        </div>
</div>

<script>
const labels = <?php echo json_encode($Delivery_Length1); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Length - Runs VS Count',
  data: <?php echo json_encode($Delivery_Length1_Count); ?>,
  backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
}]
};
const config = {
  type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart1'),
    config
  );
</script>

<script>
const labels2 = <?php echo json_encode($Delivery_Length2); ?>;
const data2 = {
labels: labels2,
datasets: [{
  label: 'Delivery Length VS Runs',
  data: <?php echo json_encode($Delivery_Length2_Runs); ?>,
  backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
  ]
}]
};
const config2 = {
  type: 'bar',
  data: data2,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart2'),
    config2
  );
</script>

<script>
const labels3 = <?php echo json_encode($Delivery_Line1); ?>;
const data3 = {
labels: labels3,
datasets: [{
  label: 'Delivery Line VS Count',
  data: <?php echo json_encode($Delivery_Line1_Count); ?>,
  backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
}]
};
const config3 = {
  type: 'bar',
  data: data3,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart3'),
    config3
  );
</script>

<script>
const labels4 = <?php echo json_encode($Delivery_Line2); ?>;
const data4 = {
labels: labels4,
datasets: [{
  label: 'Delivery Line VS Runs',
  data: <?php echo json_encode($Delivery_Line2_Runs); ?>,
  backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
  ]
}]
};
const config4 = {
  type: 'bar',
  data: data4,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart4'),
    config4
  );
</script>

<script>
const labels5 = <?php echo json_encode($Delivery_Line_Length); ?>;
const data5 = {
labels: labels5,
datasets: [{
  label: 'Delivery Length - Delivery_Line - Runs VS Count',
  data: <?php echo json_encode($Delivery_Line_Length_Count); ?>,
  backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
}]
};
const config5 = {
  type: 'bar',
  data: data5,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart5'),
    config5
  );
</script>

<script>
const labels6 = <?php echo json_encode($Delivery_Line_Length2); ?>;
const data6 = {
labels: labels6,
datasets: [{
  label: 'Delivery Length - Delivery_Line (OUT) VS Count',
  data: <?php echo json_encode($Delivery_Line_Length_Count2); ?>,
  backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
}]
};
const config6 = {
  type: 'bar',
  data: data6,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart6'),
    config6
  );
</script>

<script>
const labels7 = <?php echo json_encode($Delivery_Line_Length3); ?>;
const data7 = {
labels: labels7,
datasets: [{
  label: 'Delivery Length - Delivery_Line VS Runs',
  data: <?php echo json_encode($Delivery_Line_Length3_Runs); ?>,
  backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
  ]
}]
};
const config7 = {
  type: 'bar',
  data: data7,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart7'),
    config7
  );
</script>

<script>
const labels8 = <?php echo json_encode($Delivery_Type1); ?>;
const data8 = {
labels: labels8,
datasets: [{
  label: 'Delivery Type VS Count',
  data: <?php echo json_encode($Delivery_Type1_Count); ?>,
  backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
}]
};
const config8 = {
  type: 'bar',
  data: data8,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart8'),
    config8
  );
</script>

<script>
const labels9 = <?php echo json_encode($Delivery_Type2); ?>;
const data9 = {
labels: labels9,
datasets: [{
  label: 'Delivery Type VS Runs',
  data: <?php echo json_encode($Delivery_Type2_Runs); ?>,
  backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
  ]
}]
};
const config9 = {
  type: 'bar',
  data: data9,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart9'),
    config9
  );
</script>

<script>
  const labels10 = <?php echo json_encode($Delivery_Length_line_type); ?>;
  const data10 = {
  labels: labels10,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Delivery Type VS Count',
    data: <?php echo json_encode($Delivery_Length_line_type_Count); ?>,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};
const config10 = {
  type: 'bar',
  data: data10,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart10'),
    config10
  );
</script>

<script>
  const labels11 = <?php echo json_encode($Delivery_Length_line_type2); ?>;
  const data11 = {
  labels: labels11,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Delivery Type VS Runs',
    data: <?php echo json_encode($Delivery_Length_line_type2_Runs); ?>,
    backgroundColor: [
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
  ]
  }]
};
const config11 = {
  type: 'bar',
  data: data11,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart11'),
    config11
  );
</script>

<script>
  const labels12 = <?php echo json_encode($Delivery_Length_line_type3); ?>;
  const data12 = {
  labels: labels12,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Delivery Type VS Count',
    data: <?php echo json_encode($Delivery_Length_line_type3_Count); ?>,
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1
  }]
};
const config12 = {
  type: 'bar',
  data: data12,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart12'),
    config12
  );
</script>

<?php
include ('search_script.php');
?>
<?php
include ('footer.php');
?>
</body>
</html>