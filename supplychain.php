<!DOCTYPE html>
<html>
<head>
    <title>SupplyChain </title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="./stylesheet.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">    
   <style>
body {
    margin:0%;  
    padding: 0%;
    box-sizing: border-box;
    background-color: #e6e8ed;
    color: #666666; }
.row {
      display: flex; /* Use flex display for the row */}
.column {
      flex: 1; /* Make columns equally share the available width */
      padding: 10px;
      box-sizing: border-box;
    }
   </style>
<link rel="stylesheet" href="./Tablestyle.css">
</head>
<body>
<div class="grid-container">
<!---------Adds the Header and the sideBar-------------->
<?php
include 'C:\xampp\htdocs\ERP System\layout\Header.html';
include 'C:\xampp\htdocs\ERP System\layout\sidebar.html';
include 'C:\xampp\htdocs\ERP System\all_Functions.php';
?>
 <!--/*-------------Main-------------*/ --> 
 <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">Supply chain info </p>
    </div> 
<?php
include 'C:\xampp\htdocs\ERP System\configuration.php';
$query = "SELECT * FROM supply";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Freight cost</th><th>Shipment cost</th><th>Admin cost</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["freight_cost"] . "</td>";
        echo "<td>" . $row["shipment_cost"] . "</td>";
        echo "<td>" . $row["admin_cost"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found.<br>";}
	echo "<br> <p class='font-weight-bold'>Supply Chain Functions: </p>";
    
    echo "<table border='1'>";
    echo "<tr><th>Function</th><th>Cost</th></tr>";
    echo "<tr><td>Material Costs</td><td>".MaterialCosts()."</td></tr>";
    echo "<tr><td>Annual Inventory Cost</td><td>".AnnualInventoryCost()."</td></tr>";
    echo "<tr><td>Freight Minus Shipment</td><td>".Freightminusshipment()."</td></tr>";
    echo "<tr><td>Total Annual Cost SCM</td><td>".TotalAnnualCostSCM()."</td></tr>";
    echo "<tr><td>Total Annual Costs</td><td>".TotalAnnualCosts()."</td></tr></table>";

 	
//SUPPLY CHAIN FUNCTIONS 
/*
function MaterialCosts() 
{
	$p = 4; //trims
	$d = 90000;  //annual
	$mc= $p * $d;
	return $mc;
}

function AnnualInventoryCost()
{
	$q = "SELECT annual_unit_hc FROM inventory";
	$result = query($q);
	$row = mysqli_fetch_array($result); 
	$h = $row["annual_unit_hc"];
	$aic = (AverageCycleInventory() + PipelineInventory() )* $h;
	return $aic;
}

function Freightminusshipment()
{
	$q = "SELECT freight_cost, shipment_cost FROM supply";
	$result = query($q);
	$row = mysqli_fetch_array($result); 
	$freightcosts = $row["freight_cost"];	
	$shipmentcost = $row["shipment_cost"];
	$fs= $freightcosts-$shipmentcost;
	return $fs;
}

function TotalAnnualCostSCM()
{
	$q = "SELECT admin_cost FROM supply";
	$result = query($q);
	$row = mysqli_fetch_array($result); 
	$administrativeCosts = $row["admin_cost"];
	$tac=  MaterialCosts() + AnnualInventoryCost()+ $administrativeCosts;
	return $tac;
}

function TotalAnnualCosts()
{
	$q = "SELECT freight_cost, admin_cost FROM supply";
	$result = query($q);
	$row = mysqli_fetch_array($result); 
	$freightcosts = $row["freight_cost"];
	$administrativeCosts = $row['admin_cost'];
	$tac = MaterialCosts()+ $freightcosts +AnnualInventoryCost()+ $administrativeCosts;
	return $tac;
}
	*/
?>
</main>
</div>
<script src="scripts.js"></script>
</body>
</html>