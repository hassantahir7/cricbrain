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

            $over_no_low = 1;
            $over_no_high = 20;

            if (isset($_GET['range'])) {
                switch ($_GET['range']) {
                    case "all":
                        $over_no_low = 1;
                        $over_no_high = 20;
                        break;
                    case "1_6":
                        $over_no_low = 1;
                        $over_no_high = 6;
                        break;
                    case "7_15":
                        $over_no_low = 7;
                        $over_no_high = 15;
                        break;
                    case "16_20":
                        $over_no_low = 16;
                        $over_no_high = 20;
                        break;
                    default:
                        echo "No data available";
                }
            }

            if(empty($_GET['range']) || $_GET['range'] == 'all'){

                $query = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
                FROM rk_length_line_runs_aovers 
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Runs = -1
                GROUP BY xAxis
                HAVING count > 1
                ");

            }

            elseif($_GET['range'] == '1_6'){

                $query = $con->query(
                    "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
                    FROM rk_length_line_runs_aovers 
                    WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                    AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND OverNumber BETWEEN 1 AND 6 AND Runs = -1
                    GROUP BY xAxis
                    HAVING count > 1
                    ");

            }

            elseif($_GET['range'] == '7_15'){

                $query = $con->query(
                    "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
                    FROM rk_length_line_runs_aovers 
                    WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                    AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND OverNumber BETWEEN 7 AND 15 AND Runs = -1
                    GROUP BY xAxis
                    HAVING count > 1
                    ");

            }

            elseif($_GET['range'] == '16_20'){

                $query = $con->query(
                    "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line) AS xAxis, SUM(Count) AS count
                    FROM rk_length_line_runs_aovers 
                    WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null'
                    AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND OverNumber BETWEEN 16 AND 20 AND Runs = -1
                    GROUP BY xAxis
                    HAVING count > 1
                    ");

            }

            foreach($query as $data)
            {
              $Delivery_Line_Length[] = $data['xAxis'];
              $Count[] = $data['count'];
            }
?>

<div class="container" style="padding-left: 20px; margin-top: 20px;">
  <div class="row" style="margin-left: 83px;">
  <div class="col-lg-12">
    <div class="m-2 float-lg-right">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a href="rk_strong_weak7.php?range=all" class="nav-item nav-link <?= (empty($_GET['range']) || $_GET['range'] == 'all') ? 'active' : '' ?>" id="nav-1w-tab" role="tab" aria-controls="nav-1w" title="all">All</a>
          <a href="rk_strong_weak7.php?range=1_6" class="nav-item nav-link <?= $_GET['range'] == '1_6' ? 'active' : '' ?>" id="nav-1m-tab" role="tab" aria-controls="nav-1m" title="1_6">1-6</a>
          <a href="rk_strong_weak7.php?range=7_15" class="nav-item nav-link <?= $_GET['range'] == '7_15' ? 'active' : '' ?>" id="nav-6m-tab" role="tab" aria-controls="nav-6m" title="7_15">7-15</a>
          <a href="rk_strong_weak7.php?range=16_20" class="nav-item nav-link <?= $_GET['range'] == '16_20' ? 'active' : '' ?>" id="nav-1y-tab" role="tab" aria-controls="nav-1y" title="16_20">16-20 Overs</a>
        </div>
      </nav>
    </div>
  </div>
</div>
<div style="margin-left: 120px;"><h2><strong>Delivery Line And Length - OUT</strong></h2></div>
    
        <div style="margin-left: 120px; width: 845px; height: 500px">
        <canvas id="myChart"></canvas>
        </div>
</div>

                <div class="container">
					<div class="row">
						<div class="col-6">
							<button onclick="showPrev()"
								style="padding-left: 30px; padding-right: 30px;  background-color: #00235a; border-radius: 5px; border: none;">
								<a href="#" style="text-decoration: none;">
                <div class="textC">Prev</div></a>
							</button>
						</div>
						<div class="col-6">
							<button onclick="showNext()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<a href="strong_weak2.php" style="text-decoration: none;">
                  <div class="textC">Next</div>
                </a>
							</button>
						</div>
					</div>
				</div>

<script>

const labels = <?php echo json_encode($Delivery_Line_Length); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Length - Delivery_Line (OUT)  VS Count',
  data: <?php echo json_encode($Count); ?>,
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
<?php
include ('search_script.php');
?>

<?php
include ('footer.php');
?>
</body>
</html>