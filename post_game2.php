<!DOCTYPE html>
<html>
<?php
include ('head.php');
?>
<link rel="stylesheet" href="style/style.css" type="text/css" />
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

            $result = mysqli_query($con, 
            "SELECT Shot_Field_Position, SUM(Runs) AS sum
            FROM line_length_fieldpos_runs_aovers
            WHERE Shot_Field_Position <> 'Shot_Field_Position' AND Shot_Field_Position <> 'Unknown'AND Shot_Field_Position <> 'Null'
            AND Delivery_Length = '{$d_length}' AND Delivery_Line = '{$d_line}'
            GROUP BY Shot_Field_Position
            ORDER BY sum DESC
            LIMIT 1");

    }
    elseif($d_line != 'All'){

        $result = mysqli_query($con, 
        "SELECT Shot_Field_Position, SUM(Runs) AS sum
        FROM line_length_fieldpos_runs_aovers
        WHERE Shot_Field_Position <> 'Shot_Field_Position' AND Shot_Field_Position <> 'Unknown'AND Shot_Field_Position <> 'Null'
        AND  Delivery_Line = '{$d_line}'
        GROUP BY Shot_Field_Position
        ORDER BY sum DESC
        LIMIT 1");
        
    }
    elseif($d_length != 'All'){

        $result = mysqli_query($con, 
            "SELECT Shot_Field_Position, SUM(Runs) AS sum
            FROM line_length_fieldpos_runs_aovers
            WHERE Shot_Field_Position <> 'Shot_Field_Position' AND Shot_Field_Position <> 'Unknown'AND Shot_Field_Position <> 'Null'
            AND Delivery_Length = '{$d_length}'
            GROUP BY Shot_Field_Position
            ORDER BY sum DESC
            LIMIT 1");

    }
    else{

        $result = mysqli_query($con, 
            "SELECT Shot_Field_Position, SUM(Runs) AS sum
            FROM line_length_fieldpos_runs_aovers
            WHERE Shot_Field_Position <> 'Shot_Field_Position' AND Shot_Field_Position <> 'Unknown'AND Shot_Field_Position <> 'Null'
            GROUP BY Shot_Field_Position
            ORDER BY sum DESC
            LIMIT 1");

    }

    $row = mysqli_fetch_array($result);
    $fieldValue = $row['Shot_Field_Position'];
    $countValue = $row['sum'];

?>

<div class="container" style="padding-left: 20px;">
<h2>Most Efficient Field Position</h2>
<h3>
        <?php echo $fieldValue;?>   
</h3>
<p>Runs : </p><h4><?php echo $countValue;?></h4>

<form action="post_game2.php" method="post">

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

<p><strong>Delivery Length = </strong><?php echo "$d_length</p>";?>
<p><strong>Delivery Line = </strong><?php echo "$d_line</p>";?>
<p><strong>Overs = </strong><?php echo "$overs</p>";?>


<div class="circ">

<!-- 1 (square leg) -->

<?php
    if ($fieldValue == 'SquareLeg' || $fieldValue == 'BackwardSquareLeg' || $fieldValue == 'ShortLeg' || $fieldValue == 'Square' || $fieldValue == 'DeepSquareLeg' || $fieldValue == 'BackwardSquare' || $fieldValue == 'BehindSquare'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <!-- <div class="segment-text4" style="color: white;">
        <?php //echo $countValue?>
    </div> -->
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text4" style="color: black;">
        <?php //echo "0";?>
    </div> -->
<?php
}
?>

<!-- 2 (Mid Wicket) -->

<?php
    if ($fieldValue == 'MidWicket' || $fieldValue == 'DeepMidWicket' || $fieldValue == 'ShortMidWicket' || $fieldValue == 'RightMidWicket' || $fieldValue == 'WideMidWicket'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text5" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text5" style="color: black;">
        <?php //echo "0";?>
    </div> -->
<?php

}
?>


<!-- 3 (Long On) -->
<?php
    if ($fieldValue == 'LongOn' || $fieldValue == 'MidOn'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text6" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text6" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

<!-- 4 (Long Off) -->

<?php
    if ($fieldValue == 'LongOff' || $fieldValue == 'MidOff'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text7" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text7" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

<!-- 5 (Cover) -->

<?php
    if ($fieldValue == 'CoverSweeper' || $fieldValue == 'Cover' || $fieldValue == 'SweeperCover' || $fieldValue == 'ExtraCover' || $fieldValue == 'DeepExtraCover' || $fieldValue == 'DeepCover'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text8" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text8" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

<!-- 6 (Point) -->

<?php
    if ($fieldValue == 'BackwardPoint' || $fieldValue == 'Point' || $fieldValue == 'BehindThePoint' || $fieldValue == 'DeepPoint'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text1" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text1" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

<!-- 7 (Third man) -->

<?php
    if ($fieldValue == 'ThirdMan' || $fieldValue == 'TheSlips' || $fieldValue == 'Slip1' || $fieldValue == 'Gully' || $fieldValue == 'ShortThirdMan'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text2" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text2" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

<!-- 8 (Fine Leg) -->

<?php
    if ($fieldValue == 'LegSide' || $fieldValue == 'ShortFineLeg' || $fieldValue == 'FineLeg' || $fieldValue == 'DeepFineLeg' || $fieldValue == 'LegSlip'){
?>
    <div class="sect" style="color: #0066b2;"></div>
    <div class="segment-text3" style="color: white;">
        <?php echo $countValue?>
    </div>
<?php
    }
    else{
?>
    <div class="sect" style="color: white;"></div>
    <!-- <div class="segment-text3" style="color: black;">
        <?php echo "0";?>
    </div> -->
<?php

}
?>

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
								<a href="post_game2.php" style="text-decoration: none;">
                                    <div class="textC">Next</div>
                                </a>
							</button>
						</div>
					</div>
				</div>
<?php
include ('search_script.php');
?>

<?php
include ('footer.php');
?>
</body>
</html>