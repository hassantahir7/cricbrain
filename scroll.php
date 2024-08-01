<!DOCTYPE html>
<html>
<?php
include ('head.php');
?>
<body>
	<?php
	include ('header.php');
	?>

	<div class="search-bar">
		<form action="#" method="GET">
			<input type="text" name="search" placeholder="Search...">
			<button type="submit">Go</button>
		</form>
	</div>

	<?php
            include ('_connection.php');

            $over_no_low = 0;
            $over_no_high = 30;

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
                        $over_no_low = 6;
                        $over_no_high = 16;
                        break;
                    case "16_20":
                        $over_no_low = 16;
                        $over_no_high = 20;
                        break;
                    default:
                        echo "No data available";
                }
            }
            $query = $con->query("
            SELECT CONCAT(Delivery_Line,'-', Runs) AS xAxis, Count
            FROM line_runs_overs_balls 
            WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line' AND Runs <> -1
            AND Over_number BETWEEN '$over_no_low' AND '$over_no_high'
            ");
            
            foreach($query as $data)
            {
              $Delivery_Line[] = $data['xAxis'];
            //   $Runs[] = $data['Runs'];
              $Count[] = $data['Count'];
            }

            $query2 = $con->query("
            SELECT CONCAT(Delivery_Length,'-', Runs) AS xAxis, Count
            FROM length_runs_overs
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Runs <> -1 AND Runs <> 'Runs' AND Count <> 'Count'
            AND Over_number BETWEEN '$over_no_low' AND '$over_no_high'
            ");
            
            foreach($query2 as $data2)
            {
              $Delivery_Length[] = $data2['xAxis'];
            //   $Runs[] = $data2['Runs'];
              $Count2[] = $data2['Count'];
            }
?>

<div class="container" style="padding-left: 20px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-2 float-lg-right">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a href="scroll.php?range=all" class="nav-item nav-link <?= (empty($_GET['range']) || $_GET['range'] == 'all') ? 'active' : ''; ?>" id="nav-1w-tab" role="tab" aria-controls="nav-1w" aria-selected="false" title="all">all</a>
                        <a href="scroll.php?range=1_6" class="nav-item nav-link <?= $_GET['range'] == '1_6' ? 'active' : ''; ?>" id="nav-1m-tab" role="tab" aria-controls="nav-1m" aria-selected="false" title="1_6">1-6</a>
                        <a href="scroll.php?range=7_15" class="nav-item nav-link <?= $_GET['range'] == '7_15' ? 'active' : ''; ?>" id="nav-6m-tab" role="tab" aria-controls="nav-6m" aria-selected="true" title="7_15">7-15</a>
                        <a href="scroll.php?range=16_20" class="nav-item nav-link <?= $_GET['range'] == '16_20' ? 'active' : ''; ?>" id="nav-1y-tab" role="tab" aria-controls="nav-1y" aria-selected="true" title="16_20">16-20 Overs</a>
                        </div>
                </nav>
            </div>
        </div>
    </div>
    <h2><strong>Delivery Line</strong></h2>

    <div style="width: 900px; height: 700px">
        <canvas id="myChart"></canvas>
    </div>
</div>


<div class="container" style="padding-left: 20px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-2 float-lg-right">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a href="scroll.php?range=all" class="nav-item nav-link <?= (empty($_GET['range']) || $_GET['range'] == 'all') ? 'active' : ''; ?>" id="nav-1w-tab" role="tab" aria-controls="nav-1w" aria-selected="false" title="all">all</a>
                        <a href="scroll.php?range=1_6" class="nav-item nav-link <?= $_GET['range'] == '1_6' ? 'active' : ''; ?>" id="nav-1m-tab" role="tab" aria-controls="nav-1m" aria-selected="false" title="1_6">1-6</a>
                        <a href="scroll.php?range=7_15" class="nav-item nav-link <?= $_GET['range'] == '7_15' ? 'active' : ''; ?>" id="nav-6m-tab" role="tab" aria-controls="nav-6m" aria-selected="true" title="7_15">7-15</a>
                        <a href="scroll.php?range=16_20" class="nav-item nav-link <?= $_GET['range'] == '16_20' ? 'active' : ''; ?>" id="nav-1y-tab" role="tab" aria-controls="nav-1y" aria-selected="true" title="16_20">16-20 Overs</a>
                        </div>
                </nav>
            </div>
        </div>
    </div>

    <h2><strong>Delivery Length</strong></h2>
        <div style="width: 900px; height: 700px">
        <canvas id="myChart2"></canvas>
        </div>
</div>

          <div class="container">
					<div class="row">
						<div class="col-6">
							<button onclick="showPrev()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<div class="textC">Prev</div>
							</button>
						</div>
						<div class="col-6">
							<button onclick="showNext()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<a href="strong_weak2.php" style="text-decoration: none;">
                                <div class="textC">Next</div></a>
							</button>
						</div>
					</div>
				</div>

<script>

const labels = <?php echo json_encode($Delivery_Line); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Line - Runs VS Count',
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

<script>

const labels2 = <?php echo json_encode($Delivery_Length); ?>;
const data2 = {
labels: labels2,
datasets: [{
  label: 'Delivery Length - Runs VS Count',
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
		document.querySelector('form').addEventListener('submit', function(e) {
		  e.preventDefault();
		  const searchValue = document.querySelector('input[name="search"]').value;
		  if (searchValue.toLowerCase() === 'babar azam') {
			document.querySelector('.carousel').style.display = 'block';
			// Initialize the carousel slider here if needed
		  } else {
			const errorMessage = document.createElement('div');
			errorMessage.innerText = 'Oops! No player of that name';
			document.body.appendChild(errorMessage);
		  }
		});
	  </script>

</body>
</html>