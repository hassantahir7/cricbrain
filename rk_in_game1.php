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

      $d_line = $_POST['deliveryLineDropdown'] ?? 'All';
      $d_length = $_POST['deliveryLengthDropdown'] ?? 'All';
      $overs = $_POST['oversDropdown'] ?? 'All';
  
      $over_no_low = 1;
      $over_no_high = 20;
  
      switch ($overs) {
          case "All":
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

        if ($d_line != 'All' && $d_length != 'All') {

        $query = $con->query(
            "SELECT CONCAT(Shot_Field_Position) AS xAxis, SUM(Count) AS count
            FROM rk_length_line_fieldpos_aovers
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Shot_Field_Position <> 'Null' 
            AND Shot_Field_Position <> 'Unknown'
            AND Delivery_Length = '{$d_length}' AND Delivery_Line = '{$d_line}'
            GROUP BY xAxis
            HAVING count > 1
            ");

        }

        elseif($d_line != 'All'){

            $query = $con->query(
                "SELECT CONCAT(Delivery_Length, ' - ', Shot_Field_Position) AS xAxis, SUM(Count) AS count
                FROM rk_length_line_fieldpos_aovers
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' AND Shot_Field_Position <> 'Null' 
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Shot_Field_Position <> 'Unknown'
                AND Over_No BETWEEN '$over_no_low' AND '$over_no_high'
                AND Delivery_Line = '{$d_line}'
                GROUP BY xAxis
                HAVING count > 1
                ");
                        
        }
        elseif($d_length != 'All'){

        $query = $con->query(
            "SELECT CONCAT(Delivery_Line, ' - ', Shot_Field_Position) AS xAxis, SUM(Count) AS count
            FROM rk_length_line_fieldpos_aovers
            WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' AND Shot_Field_Position <> 'Null' 
            AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Shot_Field_Position <> 'Unknown'
            AND Over_No BETWEEN '$over_no_low' AND '$over_no_high'
            AND Delivery_Length = '{$d_length}'
            GROUP BY xAxis
            HAVING count > 1
            ");

        }
        else{

            $query = $con->query(
                "SELECT CONCAT(Delivery_Length,' - ', Delivery_Line, ' - ', Shot_Field_Position) AS xAxis, SUM(Count) AS count
                FROM rk_length_line_fieldpos_aovers
                WHERE Delivery_Length <> 'Null' AND Delivery_Length <> 'Delivery_Length' AND Delivery_Line <> 'Null' AND Shot_Field_Position <> 'Null' 
                AND Delivery_Length <> 'Unknown' AND Delivery_Line <> 'Unknown' AND Shot_Field_Position <> 'Unknown'
                GROUP BY xAxis
                HAVING count > 6
                ");

        }

            foreach($query as $data)
            {
              $Delivery_Length[] = $data['xAxis'];
              $Count[] = $data['count'];
            }
?>

<div class="container" style="padding-left: 20px;">
<h2><strong>Most Played Field Position</strong></h2>

<form action="rk_in_game1.php" method="post">

    <label for="deliveryLengthDropdown">Select a Delivery Length:</label>
    <select name="deliveryLengthDropdown" id="deliveryLengthDropdown">
    <option value="All">All</option>
    <option value="FullLength">Full Length</option>
    <option value="GoodLength">Good Length</option>
    <option value="Yorker">Yorker</option>
    <option value="FullToss">Full Toss</option>
    <option value="ShortLength">Short Length</option>
    <option value="HalfVolley">Half Volley</option>
    </select>

    <br>
    <br>

    <label for="deliveryLineDropdown">Select a Delivery Line:</label>
    <select name="deliveryLineDropdown" id="deliveryLineDropdown">
    <option value="All">All</option>
    <option value="AroundOff">Around Off</option>
    <option value="DownTheLegStump">Down The Leg Stump</option>
    <option value="LegStump">Leg Stump</option>
    <option value="MiddleStump">Middle Stump</option>
    <option value="OffStump">Off Stump</option>
    <option value="OnStump">On Stump</option>
    <option value="OnThePads">On The Pads</option>
    <option value="OutsideOff">Outside Off</option>
    <option value="Straight">Straight</option>
    <option value="Stumps">Stumps</option>
    <option value="Wide">Wide</option>
    <option value="MiddleStumps">Middle Stumps</option>
    <option value="OffThePads">Off The Pads</option>
    <option value="OnTheFifthStump">On The Fifth Stump</option>
    <option value="MiddleLegStump">Middle Leg Stump</option>
    <option value="SixthStump">Sixth Stump</option>
    </select>

    <br>
    <br>

    <label for="oversDropdown">Select Overs:</label>
    <select name="oversDropdown" id="oversDropdown">
    <option value="All">All</option>
    <option value="1_6">1 - 6</option>
    <option value="7_15">7 - 15</option>
    <option value="16_20">16 - 20</option>
    </select>

    <input type="submit" value="Show">
    <br><br>
</form>

<p>Delivery Length = <?php echo "$d_length</p>";?>
<p>Delivery Line = <?php echo "$d_line</p>";?>
<p>Overs = <?php echo "$overs</p>";?>


  <div style="width: 700px; height: 100px: margin: 4px">
    <canvas id="myChart"></canvas>
  </div>

</div>



<div class="container">
					<div class="row">
						<div class="col-6">
							<button onclick="showPrev()"
								style="padding-left: 30px; padding-right: 30px; margin-left: 265px; background-color: #00235a; border-radius: 5px; border: none;">
								<a href="#" style="text-decoration: none;">
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

const labels = <?php echo json_encode($Delivery_Length); ?>;
const data = {
    labels: labels,
  datasets: [{
    label: 'Delivery Length -  Delivery Line - Shot Field Position VS Count',
    data: <?php echo json_encode($Count); ?>,
    fill: true,
    backgroundColor: 'rgb(255, 205, 86, 0.2)',
    borderColor: 'rgb(255, 205, 86)',
    pointBackgroundColor: 'rgb(255, 205, 86)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(255, 205, 86)'
  }
]
};

const config = {
  type: 'radar',
  data: data,
  options: {
    elements: {
      line: {
        borderWidth: 3
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
</body>
</html>