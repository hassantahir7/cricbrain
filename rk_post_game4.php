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

    $query4 = $con->query(
        "SELECT Delivery_Line, SUM(Count) AS count
        FROM rk_line_runs_aovers 
        WHERE Delivery_Line <> 'Null' AND Delivery_Line <> 'Delivery_Line' AND Runs = -1
        AND Delivery_Line <> 'Unknown'
        GROUP BY Delivery_Line
        ");
    foreach($query4 as $data4)
    {
      $Delivery_Line2[] = $data4['Delivery_Line'];
      $Delivery_Line2_Count[] = $data4['count'];
    }
?>

<div class="container" style="padding-left: 20px;">
<h2><strong>Number of wickets on each delivery line</strong></h2>
    <div style="width: 950px; height: 420px">
        <canvas id="myChart"></canvas>
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

const labels = <?php echo json_encode($Delivery_Line2); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Line - OUT VS Count',
  data: <?php echo json_encode($Delivery_Line2_Count); ?>,
  backgroundColor: [
    'rgb(102, 255, 102)',
    'rgb(255, 99, 132)',
    'rgb(75, 192, 192)',
    'rgb(255, 205, 86)',
    'rgb(201, 203, 207)',
    'rgb(54, 162, 235)',
    'rgb(255, 153, 255)',
      'rgb(255, 159, 64)',
      'rgb(255, 255, 153)',
      'rgb(214, 245, 214)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)',
      'rgb(255, 102, 163)',
      'rgb(179, 0, 71)',
      'rgb(191, 255, 0)',
      'rgb(255, 128, 128)',
      'rgb(255, 26, 26)'
  ],
  hoverOffset: 4
}]
};

const config = {
type: 'pie',
data: data,
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