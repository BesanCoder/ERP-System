<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
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
    color: #666666;
   }
   .row {
      display: flex; /* Use flex display for the row */
    }
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
include('C:\xampp\htdocs\ERP System\layout\sidebar.html');
?>
 <!--/*-------------Main-------------*/ --> 
 <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">Inventory info </p>
    </div> 
<?php
include 'C:\xampp\htdocs\ERP System\configuration.php';
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Lead Time </th><th>Annual unit</th><th>setup cost</th><th>annual cycle cost</th><th>lot size</th><th>time between orders</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["lead_time"] . "</td>";
        echo "<td>" . $row["annual_unit_hc"] . "</td>";
        echo "<td>" . $row["setup_cost_lot"] . "</td>";
        echo "<td>" . $row["annual_cycleInv_cost"] . "</td>";
        echo "<td>" . $row["lot_size"] . "</td>";
        echo "<td>" . $row["time_btwn_orders"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found.<br>";}
	echo "<br> <p class='font-weight-bold'>Inventory Functions: </p> <br>";
	 	//Inventory Functions
	echo "<div class='row'>";
	echo" <div class='column'> <table border='1'>";
	echo "<tr><th>Average Cycle Inventory = </th><td>".AverageCycleInventory()."</td></tr>";
	echo "<tr><th>Pipeline Inventory = </th><td>".PipelineInventory()."</td></tr>";
	echo "<tr><th>Annual Holding Cost = </th><td>".AnnualHoldingCost()."</td></tr>";
	echo "<tr><th>Annual Ordering Cost = </th><td>".AnnualOrderingCost()."</td></tr>";
	echo "<tr><th>TotalAnnualCycleInventoryCost = </th><td>".TotalAnnualCycleInventoryCost()."</td></tr></table></div>";
	echo "<div class='column'><table border='1'><tr><th>TotalAnnualCycleInventoryCost2 = </th><td>".TotalAnnualCycleInventoryCost2()."</td></tr>";
	echo "<tr><th>Economic Order Quantity = </th><td>".EOQ()."</td></tr>";
	echo "<tr><th>Time Between Orders = </th><td>".TBO()."</td></tr>";
	echo "<tr><th>Inventory Position = </th><td>".InventoryPosition()."</td></tr>";
	echo "<tr><th>Re-Order Point = </th><td>".ROP()."</td></tr></table></div></div>";

    function AverageCycleInventory()
	{
		$q = 90000; //TOTAL AMOUNT OF CARS ASSEMBELLED ANNUALLY
		$avgci = $q / 2;
		return $avgci;
	}

function PipelineInventory()
	{
		$q = "SELECT lead_time FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$l = $row["lead_time"];
		$d = 90000; // avg demand = quantity annual produced 
		$pli = $d * $l;
		return $pli;
	}

function AnnualHoldingCost()
	{
		$q = "SELECT annual_unit_hc FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$uhc = $row["annual_unit_hc"];
		$ahc = AverageCycleInventory() * $uhc;
		return $ahc;
	}

function AnnualOrderingCost()
	{
		$q = "SELECT setup_cost_lot FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$suc = $row["setup_cost_lot"];
		$ordernum = 90000;
		$aoc = $ordernum * $suc;
		return $aoc;
	}  

function TotalAnnualCycleInventoryCost()
	{
		$tacic = AnnualHoldingCost() * AnnualOrderingCost();
		return $tacic;
	}

function TotalAnnualCycleInventoryCost2()
	{
		$q = "SELECT annual_unit_hc, lot_size, setup_cost_lot FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$s = $row["setup_cost_lot"];
		$h = $row["annual_unit_hc"];
		$q = $row["lot_size"];
		$d = 90000;
		$c = (($q/2) *$h) + (($d/$q) * $s);
		return $c;
	}

function EOQ()
	{
		$q = "SELECT annual_unit_hc, setup_cost_lot FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$s = $row["setup_cost_lot"];
		$h = $row["annual_unit_hc"];
		$d = 90000;
		$eoq = sqrt((2*$d*$s)/$h);
		return $eoq;
	}	

function TBO()
	{
		$d = 90000;
		$time = 12; // months/year
		$tbo = (EOQ() / $d) * $time;
		return $tbo;
	}

function InventoryPosition()
	{
		//ASSUMPTION OF A CERTAIN SITUATION 
		$oh = 500;
		$sr = 250;
		$bo = 0;
		$ip = $oh + $sr - $bo;
		return $ip;
	}

function ROP()
	{
		$q = "SELECT lead_time FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$l = $row["lead_time"];
		$D = 90000/52; // to find demand per week 
		$safetystock = 200; 
		$rop = $D * $l + $safetystock;
		return $rop;
	}	
?>
</main>
</div>
<script src="scripts.js"></script>
</body>
</html>