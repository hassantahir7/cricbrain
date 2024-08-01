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

    $query11 = $con->query(
        "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Delivery_type) AS xAxis, SUM(Count) AS count
        FROM rk_length_line_deliverytype_runs 
        WHERE Delivery_Length <> 'Delivery_Length' AND Delivery_Length <> 'Null' AND Delivery_Line <> 'Null' AND Delivery_type <> 'Null'
        AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Delivery_type <> 'Unknown' AND Runs = -1
        GROUP BY xAxis
        ");
        foreach($query11 as $data11)
        {
          $Delivery_Length_line_type2[] = $data11['xAxis'];
          $Delivery_Length_line_type2_Count[] = $data11['count'];
        }
?>

<div class="container" style="padding-left: 20px;">
<h2><strong>Wickets taken on each combination of Delivery Length, Line and Type</strong></h2>
    <div style="width: 950px; height: 420px">
        <canvas id="myChart11"></canvas>
    </div>
</div>


                <div class="container">
					<div class="row">
						<div class="col-6">
							<button onclick="showPrev()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<a href="strong_weak7.php" style="text-decoration: none;">
                                <div class="textC">Prev</div></a>
							</button>
						</div>
						<div class="col-6">
							<button onclick="showNext()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<a href="#" style="text-decoration: none;">
                                    <div class="textC">Next</div>
                                </a>
							</button>
						</div>
					</div>
				</div>

                <script>
  const labels11 = <?php echo json_encode($Delivery_Length_line_type2); ?>;
  const data11 = {
  labels: labels11,
  datasets: [{
    label: 'Delivery Length - Delivery Line - Delivery Type - OUT VS Count',
    data: <?php echo json_encode($Delivery_Length_line_type2_Count); ?>,
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

<?php
include ('search_script.php');
?>

<?php
include ('footer.php');
?>

</body>
</html>