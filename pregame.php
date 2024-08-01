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

            //    Delivery Line - Count
            $query = $con->query(
                "SELECT CONCAT(Delivery_Line,' - ', Runs) AS xAxis, SUM(Count) AS count
                FROM line_runs_aovers
                WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line' AND Runs <> -1
                AND Delivery_Line <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query as $data)
            {
              $Delivery_Line[] = $data['xAxis'];
              $Delivery_Line_Count[] = $data['count'];
            }

            //    Delivery Line - Runs
            $query2 = $con->query(
                "SELECT Delivery_Line, SUM(Runs) AS runs
                FROM line_runs_aovers
                WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line' AND Runs <> -1
                AND Delivery_Line <> 'Unknown'
                GROUP BY Delivery_Line
                HAVING runs > 1
                ");
            foreach($query2 as $data2)
            {
                $Delivery_Line2[] = $data2['Delivery_Line'];
                $Delivery_Line2_Runs[] = $data2['runs'];
            }

            //    Delivery Length - Count 
            $query3 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Runs) AS xAxis, SUM(Count) AS count
                FROM length_runs_aovers
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Runs <> -1
                AND Delivery_Length <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query3 as $data3)
            {
            $Delivery_Length[] = $data3['xAxis'];
            $Delivery_Length_Count[] = $data3['count'];
            }

            //    Delivery Length - Runs 
            $query4 = $con->query(
                "SELECT Delivery_Length, SUM(Runs) AS runs
                FROM length_runs_aovers
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Runs <> -1
                AND Delivery_Length <> 'Unknown'
                GROUP BY Delivery_Length
                HAVING runs > 1
                ");
            foreach($query4 as $data4)
            {
            $Delivery_Length2[] = $data4['Delivery_Length'];
            $Delivery_Length_Runs[] = $data4['runs'];
            }

            //    Shot Type - Count
            $query5 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ',Shot_type, ' - ', Runs) AS xAxis, SUM(Count) AS count
                FROM line_length_deliverytype_shot_runs_innings_aovers
                WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Shot_type <> 'Null' 
                AND Shot_type <> 'Unknown' AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query5 as $data5)
            {
            $Shot_Type1[] = $data5['xAxis'];
            $Shot_Type1_Count[] = $data5['count'];
            }

            //    Shot Type - Runs
            $query6 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ',Shot_type) AS xAxis, SUM(Runs) AS runs
                FROM line_length_deliverytype_shot_runs_innings_aovers
                WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Shot_type <> 'Null' 
                AND Shot_type <> 'Unknown' AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown'
                GROUP BY xAxis
                HAVING runs > 1
                ");
            foreach($query6 as $data6)
            {
            $Shot_Type2[] = $data6['xAxis'];
            $Shot_Type2_Runs[] = $data6['runs'];
            }

            //    Field Position - Count
            $query7 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Shot_Field_Position, ' - ', Runs) AS xAxis, SUM(Count) As count
                FROM line_length_fieldpos_runs_aovers 
                WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Null' AND Delivery_Line <> 'Unknown' AND Shot_Field_Position <> 'Null' AND Shot_Field_Position <> 'Unknown' 
                GROUP By xAxis
                HAVING count > 1
                ");
            foreach($query7 as $data7)
            {
              $Field_Position[] = $data7['xAxis'];
              $Field_Position_Count[] = $data7['count'];
            }

            //    Field Position - Runs
            $query8 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Shot_Field_Position) AS xAxis, SUM(Runs) As runs
                FROM line_length_fieldpos_runs_aovers 
                WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Null' AND Delivery_Line <> 'Unknown' AND Shot_Field_Position <> 'Null' AND Shot_Field_Position <> 'Unknown' 
                GROUP By xAxis
                HAVING runs > 1
                ");
            foreach($query8 as $data8)
            {
              $Field_Position2[] = $data8['xAxis'];
              $Field_Position2_Runs[] = $data8['runs'];
            }

            //    Hit Type - Count
            $query9 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Hit_type) AS xAxis, SUM(Count) AS count
            FROM length_line_hittype 
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' AND Hit_type <> 'Null' 
            GROUP By xAxis
            HAVING count > 2
            ");
            foreach($query9 as $data9)
            {
              $HitType[] = $data9['xAxis'];
              $HitType_Count[] = $data9['count'];
            }

            //    Line Length Runs - Count
            $query10 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Runs) AS xAxis, SUM(Count) AS count
            FROM length_line_runs 
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' 
            GROUP By xAxis
            HAVING count > 5
            ");
            foreach($query10 as $data10)
            {
              $Line_Length1[] = $data10['xAxis'];
              $Line_Length1_Count[] = $data10['count'];
            }

            //    Line Length - Runs
            $query11 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Runs) AS runs
            FROM length_line_runs 
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' 
            GROUP By xAxis
            HAVING runs > 2
            ");
            foreach($query11 as $data11)
            {
              $Line_Length2[] = $data11['xAxis'];
              $Line_Length2_Runs[] = $data11['runs'];
            }

            //    Line Length Out - Count
            $query12 = $con->query(
            "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
            FROM length_line_runs 
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
            AND Delivery_Line <> 'Unknown' AND Delivery_Length <> 'Unknown'
            AND Runs = -1
            GROUP By xAxis
            ");
            foreach($query12 as $data12)
            {
              $Line_Length3[] = $data12['xAxis'];
              $Line_Length3_Out[] = $data12['count'];
            }

            //    Delivery Type - Count
            $query13 = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ',Delivery_type) AS xAxis, SUM(Count) AS count
                FROM line_length_deliverytype_shot_runs_innings_aovers
                WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Delivery_type <> 'Null' 
                AND Delivery_type <> 'Unknown' AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 1
                ");
            foreach($query13 as $data13)
            {
              $DeliveryType[] = $data13['xAxis'];
              $DeliveryType_Count[] = $data13['count'];
            }
?>

<!-- Delivery Line - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Line</strong></h2>
    <p>Most occurence</p>
    <div style="width: 900px; height: 700px">
        <canvas id="myChart"></canvas>
    </div>
</div>

<!-- Delivery Line - Runs -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Line</strong></h2>
    <p>Most Runs</p>
    <div style="width: 900px; height: 700px">
        <canvas id="myChart2"></canvas>
    </div>
</div>


<!-- Delivery Length - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Length</strong></h2>
    <p>Most occurence</p>
    <div style="width: 900px; height: 700px">
        <canvas id="myChart3"></canvas>
    </div>
</div>

<!-- Delivery Length - Runs -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Length</strong></h2>
    <p>Most Runs</p>
    <div style="width: 900px; height: 700px">
        <canvas id="myChart4"></canvas>
    </div>
</div>

<!-- Line Length - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Line And Length</strong></h2>
    <p>Most occurence</p>
    <div style="width: 1200px; height: 800px">
        <canvas id="myChart10"></canvas>
    </div>
</div>

<!-- Line Length - Runs -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Line And Length</strong></h2>
    <p>Most Runs</p>
    <div style="width: 1200px; height: 800px">
        <canvas id="myChart11"></canvas>
    </div>
</div>

<!-- Line Length Out- Count -->
<div style="padding-left: 50px;">
    <h2><strong>Delivery Line And Length</strong></h2>
    <p>Most occurence</p>
    <div style="width: 900px; height: 700px">
        <canvas id="myChart12"></canvas>
    </div>
</div>

<!-- Shot type - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Shot Type</strong></h2>
    <p>Most occurence</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart5"></canvas>
    </div>
</div>

<!-- Shot type - Runs -->
<div style="padding-left: 50px;">
    <h2><strong>Shot Type</strong></h2>
    <p>Most Runs</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart6"></canvas>
    </div>
</div>

<!-- Field Position - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Field Position</strong></h2>
    <p>Most occurence</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart7"></canvas>
    </div>
</div>

<!-- Field Position - Runs -->
<div style="padding-left: 50px;">
    <h2><strong>Field Position</strong></h2>
    <p>Most Runs</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart8"></canvas>
    </div>
</div>

<!-- Hit Type - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Hit Type</strong></h2>
    <p>Most occurence</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart9"></canvas>
    </div>
</div>

<!-- Delivery Type - Count -->
<div style="padding-left: 50px;">
    <h2><strong>Delivert Type</strong></h2>
    <p>Most occurence</p>
    <div style="width: 1000px; height: 700px">
        <canvas id="myChart13"></canvas>
    </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-6">
			<button onclick="showPrev()" style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
				<div class="textC">Prev</div>
			</button>
		</div>
		<div class="col-6">
			<button onclick="showNext()" style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
				<a href="strong_weak2.php" style="text-decoration: none;">
                    <div class="textC">Next</div></a>
			</button>
		</div>
	</div>
</div>

<!-- Delivery Line - Count -->
<script>
const labels = <?php echo json_encode($Delivery_Line); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Line - Runs VS Count',
  data: <?php echo json_encode($Delivery_Line_Count); ?>,
  backgroundColor: [
    'rgb(75, 192, 192)'
  ]
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
    document.getElementById('myChart'),
    config
  );
</script>


<!-- Delivery Line - Runs -->
<script>
const labels2 = <?php echo json_encode($Delivery_Line2); ?>;
const data2 = {
labels: labels2,
datasets: [{
  label: 'Delivery Line VS Runs',
  data: <?php echo json_encode($Delivery_Line2_Runs); ?>,
  backgroundColor: [
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

<!-- Delivery Length - Count -->
<script>
const labels3 = <?php echo json_encode($Delivery_Length); ?>;
const data3 = {
labels: labels3,
datasets: [{
  label: 'Delivery Length - Runs VS Count',
  data: <?php echo json_encode($Delivery_Length_Count); ?>,
  backgroundColor: [
    'rgb(75, 192, 192)'
  ]
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

<!-- Delivery Length - Runs -->
<script>
const labels4 = <?php echo json_encode($Delivery_Length2); ?>;
const data4 = {
labels: labels4,
datasets: [{
  label: 'Delivery Length VS Runs',
  data: <?php echo json_encode($Delivery_Length_Runs); ?>,
  backgroundColor: [
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

<!-- Shot Type - Count -->
<script>
const labels5 = <?php echo json_encode($Shot_Type1); ?>;
const data5 = {
labels: labels5,
datasets: [{
  label: 'Delivery Length - Delivery Line - Shot Type - Runs VS Count',
  data: <?php echo json_encode($Shot_Type1_Count); ?>,
  backgroundColor: [
      'rgb(153, 102, 255)'
  ]
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

<!-- Shot Type - Runs -->
<script>
const labels6 = <?php echo json_encode($Shot_Type2); ?>;
const data6 = {
labels: labels6,
datasets: [{
  label: 'Delivery Length - Delivery Line - Shot Type VS Runs',
  data: <?php echo json_encode($Shot_Type2_Runs); ?>,
  backgroundColor: [
    'rgb(201, 203, 207)'
  ]
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

<!-- Field Position - Count -->
<script>
const labels7 = <?php echo json_encode($Field_Position); ?>;
const data7 = {
labels: labels7,
datasets: [{
  label: 'Delivery Length - Delivery Line - Shot Field Position - Runs VS Count',
  data: <?php echo json_encode($Field_Position_Count); ?>,
  backgroundColor: [
    'rgb(54, 162, 235)'
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

<!-- Field Position - Runs -->
<script>
const labels8 = <?php echo json_encode($Field_Position2); ?>;
const data8 = {
labels: labels8,
datasets: [{
  label: 'Delivery Length - Delivery Line - Shot Field Position VS Runs',
  data: <?php echo json_encode($Field_Position2_Runs); ?>,
  backgroundColor: [
    'rgb(201, 203, 207)'
  ]
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

<!-- Hit Type - Count -->
<script>
  const labels9 = <?php echo json_encode($HitType); ?>;
  const data9= {
  labels: labels9,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Hit Type VS Count',
    data: <?php echo json_encode($HitType_Count); ?>,
    backgroundColor: [
        'rgb(153, 102, 255)'
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

<!-- Line Length - Count -->
<script>
  const labels10 = <?php echo json_encode($Line_Length1); ?>;
  const data10 = {
  labels: labels10,
  datasets: [{
    label: 'Delivery Length - Delivery_Line - Runs VS Count',
    data: <?php echo json_encode($Line_Length1_Count); ?>,
    backgroundColor: [
        'rgb(54, 162, 235)'
    ]
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

<!-- Line Length - Runs -->
<script>
  const labels11 = <?php echo json_encode($Line_Length2); ?>;
  const data11 = {
  labels: labels11,
  datasets: [{
    label: 'Delivery Length - Delivery_Line VS Runs',
    data: <?php echo json_encode($Line_Length2_Runs); ?>,
    backgroundColor: [
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

<!-- Line Length Out - Count -->
<script>
  const labels12 = <?php echo json_encode($Line_Length3); ?>;
  const data12 = {
  labels: labels12,
  datasets: [{
    label: 'Delivery Length - Delivery_Line - OUT VS Count',
    data: <?php echo json_encode($Line_Length3_Out); ?>,
    backgroundColor: [
        'rgb(54, 162, 235)'
    ]
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

<!-- Delivery Type - Count -->
<script>
  const labels13 = <?php echo json_encode($DeliveryType); ?>;
  const data13 = {
  labels: labels13,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Delivery Type VS Count',
    data: <?php echo json_encode($DeliveryType_Count); ?>,
    backgroundColor: [
        'rgb(54, 162, 235)'
    ]
  }]
};
const config13 = {
  type: 'bar',
  data: data13,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  },
};
  var myChart = new Chart(
    document.getElementById('myChart13'),
    config13
  );
</script>

<?php
include ('search_script.php');
?>
</body>
</html>