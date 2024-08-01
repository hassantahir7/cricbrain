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
?>

<div class="container" style="padding-left: 20px;">
<h2><strong>Runs Made on each delivery length</strong></h2>
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

const labels = <?php echo json_encode($Delivery_Length2); ?>;
const data = {
labels: labels,
datasets: [{
  label: 'Delivery Length VS Runs',
  data: <?php echo json_encode($Delivery_Length2_Runs); ?>,
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