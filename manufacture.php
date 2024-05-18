<!DOCTYPE html>
<html>
<head>
    <title>Manufacture</title>
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
.center{
 display: flex;
  justify-content: center;
  align-items: center;
height: 8vh;}
.center>a{ display: block; /* Ensure each link takes up the full width of the container */
  text-align: center; /* Center the text within each link */
  padding: 10px 20px;}

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
include 'C:\xampp\htdocs\ERP System\configuration.php';
include 'C:\xampp\htdocs\ERP System\layout\Header.html';
include 'C:\xampp\htdocs\ERP System\layout\sidebar.html';
?>
 <!--/*-------------Main-------------*/ --> 
 <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">Manufacturing info </p>
    </div>
<?php
$query = "SELECT * FROM manufacturing_process";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Process ID</th><th>Line ID</th><th>Process Name</th><th>Description</th><th>Operation Time</th><th>Handling Time</th><th>Tool Handling Time</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["Process_ID"] . "</td>";
        echo "<td>" . $row["Line_ID"] . "</td>";
        echo "<td>" . $row["Process_name"] . "</td>";
        echo "<td>" . $row["Description"] . "</td>";
        echo "<td>" . $row["operation_Time"] . "</td>";
        echo "<td>" . $row["handling_Time"] . "</td>";
        echo "<td>" . $row["Tool_Handling_Time"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No data found.";
}
?>
<div class="center"><!--BTNs-->
<a href = "manufacture.php?id=2"><button class="myBtn"> Process #2 Info </button></a>
<a href = "manufacture.php?id=5"><button class="myBtn"> Process #5 Info </button></a>
<a href = "manufacture.php?id=10"><button class="myBtn">Process #10 Info </button></a>
</div>
<br>
<?php
  if(isset($_GET['id'])){

	echo "<div class='row'>";     /////////////////////////////////////1st table
	echo "<div class='column'><table border='1'>";
	echo "<tr><th>Total number of products = </th><td>".TotalNumberOfProducts()."</td></tr>";
	echo "<tr><th>Total Number Of Parts =  </th><td>".TotalNumOfParts()."</td></tr>";
	echo "<tr><th>Cycle Time =  </th><td>".CycleTime()."m</td></tr>";
	echo "<tr><th>Job Shop Production Time =  </th><td>".JobShopProductionTime()."</td></tr>";
	echo "<tr><th>Hourly Production Rate =  </th><td>".HourlyProductionRate()."</td></tr>";
	echo "<tr><th>Availability =  </th><td>".Availability()."</td></tr></table></div>";

	echo "<div class='column'><table border='1'>";   ///////////////////////////////2nd table 
	echo "<tr><th>Production Capacity =  </th><td>".ProductionCapacity()."</td></tr>";
	echo "<tr><th>Utilization =  </th><td>".Utilization()."</td></tr>";
	echo "<tr><th>Production Rate Of Machine =  </th><td>".ProductionRateOfMachine()."</td></tr>";
	echo "<tr><th>Manufacturing Lead Time =  </th><td>".ManufacturingLeadTime()."</td></tr>";
	echo "<tr><th>Total Annual Cost =  </th><td>".TotalAnnualCost()."</td></tr>";
	echo "<tr><th>Capital Recovery Factor =  </th><td>".CRF()."</td></tr>";
	echo "<tr><th>Uniform Annual Cost =  </th><td>".UAC()."</td></tr>";
	echo "<tr><th>Factory Overhead Rate = </th><td>".FOHR()."</td></tr>";
	echo "<tr><th>Corporate Overhead Rate = </th><td>".COHR()."</td></tr>";
	echo "<tr><th>Work In Process = </th><td>".WorkInProcess()."</td></tr>";
	echo "<tr><th>Cost per piece = </th><td>".CPC()."</td></tr>";
	echo "<tr><th>Hourly Rate to Operate the Machine = </th><td>".CO()."</td></tr></table></div></div>";
	
  
	/*
	  echo "Cost of a Manufacturing Part = ".CMP()."<br>";  
	  
	  echo "Average Hourly Plant Production Rate = ".AverageHourlyPlantProductionRate()."<br>"; 
	  
	  echo "Average Production Time Of Part On Machine = ".AverageProductionTimeOfPartOnMachine()."<br>"; 
	   */
  }
  ///////////////CH2 FUNCTIONS
  function TotalNumberOfProducts()
	  {
		  // p = num of products(trim levels) 
		  //q = quantity that the factory produces YEARLY 
		  //qf = factory quantity
		  $p= 4;
		  $q= 90000; 
		  $qf = $p * $q;
		  return $qf;
	  }
	  
  function TotalNumOfParts()
	  {
		$np = 10; //parts for each car 
		$npf = TotalNumberOfProducts() * $np ;
		  return $npf;
	  }	
	  
  
  //CH3 FUNCTIONS	
  function CycleTime()
  {  
		$P_ID=$_GET['id'];
		$q = "SELECT Tool_Handling_Time, handling_Time, operation_Time
		FROM manufacturing_process WHERE Process_ID ='$P_ID'";
		$result = query($q);
		$row = mysqli_fetch_array($result);
		$to = $row["operation_Time"];
		$th = $row["handling_Time"];
		$tt = $row["Tool_Handling_Time"];
	//call the fetch function
	$tc= $to + $th + $tt;
  
	
	//call the storing function
	  return $tc;
	}
	
  function JobShopProductionTime()
	  {
		$P_ID=$_GET['id'];
		$q = "SELECT Set_up_Time FROM machines WHERE Machine_ID ='$P_ID'";
		$result = query($q);
		$row = mysqli_fetch_array($result);
		$tsu = $row["Set_up_Time"];
		$tp= $tsu + CycleTime();
		return $tp;
	  }
  function HourlyProductionRate()
	  {
		  $rp = 60/JobShopProductionTime();
		  return $rp;
	  }
	  
  function Availability()
	  {
		  $P_ID=$_GET['id'];
		  $q = "SELECT mean_time_between_failure, mean_time_between_repair
		  FROM machines WHERE Machine_ID ='$P_ID'";
		  $result = query($q);
		  $row = mysqli_fetch_array($result);
		  $MTBF = $row["mean_time_between_failure"];
		  $MTTR = $row["mean_time_between_repair"];
		  $availability = ($MTBF - $MTTR) / $MTBF;
		  return $availability;
	  }
	  
  function ProductionCapacity()
	  {
		  $P_ID=$_GET['id'];
		  $q = "SELECT num_of_machine, num_of_hours
		  FROM machines WHERE Machine_ID ='$P_ID'";
		  $result = query($q);
		  $row = mysqli_fetch_array($result);
		  $n = $row["num_of_machine"];
		  $hpc = $row["num_of_hours"];
		  $pc= $n * $hpc * HourlyProductionRate(); 
		  return $pc;
	  }
  
  function Utilization() //FRACTIONofTime()
	  {
		  $P_ID=$_GET['id'];
		  $q = "SELECT num_of_hours, capacity FROM machines WHERE Machine_ID ='$P_ID'";
		  $result = query($q);
		  $row = mysqli_fetch_array($result);
		  $workedhoursofmachine = $row["num_of_hours"];
		  $fullcapacityofmachine = $row["capacity"];
		  $fij = $workedhoursofmachine / $fullcapacityofmachine ;
		  return $fij*100;
	  }
  function ProductionRateOfMachine()
	  {
		  $Rpij = 60 / JobShopProductionTime();
		  return $Rpij;
	  }
   /* function AverageHourlyPlantProductionRate()
	  {
		  $fij = 2.5; //time of each part by this machine
		  $no = 3; // each part goes through 3 main operations (lines)
		  $rpph= $fij * (ProductionRateOfMachine() / $no); 
		  return $rpph;
	  }  */
  
  /* function AverageProductionTimeOfPartOnMachine()
	  {
		  $P_ID=$_GET['id'];
		  $q = "SELECT  Set_up_Time FROM machines WHERE Machine_ID ='$P_ID'";
		  $result = query($q);
		  $row = mysqli_fetch_array($result);
		  $tsu = $row["Set_up_Time"];
		  
		  $q2 = "SELECT Quantity FROM part WHERE Part_ID ='$P_ID'";
		  $result = query($q);
		  $row = mysqli_fetch_array($result);
		  $Tpij=($tsu + CycleTime()) / $qj;
		  return $Rpij;
	  } */
  
  function ManufacturingLeadTime ()
  {
	  $P_ID=$_GET['id'];
	  $q = "SELECT  Set_up_Time FROM machines WHERE Machine_ID ='$P_ID'";
	  $result = query($q);
	  $row = mysqli_fetch_array($result);
	  $tsu = $row["Set_up_Time"];
	  $no = 3; //3 main processes 
	  $tno = 8; //3+4+1 add non-operation for each machine
	  $quantity = 1; //JOB SHOP
	  $MLT = $no * ($tsu + ($quantity * CycleTime()) + $tno);
	  return $MLT;
  }	
  
  function WorkInProcess()
  {
	  $AverageHourlyPlantProductionRate = 1.5; //cars assembelled per hour
	  $WIP= $AverageHourlyPlantProductionRate * ManufacturingLeadTime();
	  return $WIP;
  } 
	  
  function TotalAnnualCost()
  {
	  $P_ID=$_GET['id'];
	  $q = "SELECT  fixed_cost, variable_cost FROM financial";
	  $result = query($q);
	  $row = mysqli_fetch_array($result);
	  $cf = $row["fixed_cost"];
	  $cv = $row["variable_cost"];
	  $quantity = 90000; //TOTAL AMOUNT OF CARS ASSEMBELLED ANNUALLY
	  $totalcost = $cf + $cv * ($quantity);
	  return $totalcost;
  }
  
  function CRF() {
	  $P_ID=$_GET['id'];
	  $q = "SELECT interest_rate, num_year FROM machines WHERE Machine_ID ='$P_ID'";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $i = $row["interest_rate"];
	  $N = $row["num_year"];
	  $crf = ($i * (pow((1+$i),$N))) / (pow((1+$i),$N) -1);  
	  return $crf; 
  } 
  
  function UAC() {
	  $P_ID=$_GET['id'];
	  $q = "SELECT initial_cost FROM machines WHERE Machine_ID ='$P_ID'";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $ic = $row["initial_cost"];
	  $uac = $ic * CRF();	  
	  return $uac; 
  }	
  
  function FOHR() {
	  $q = "SELECT annual_fohc, direct_labor_cost FROM financial";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $fohc = $row["annual_fohc"];
	  $dlc = $row["direct_labor_cost"];
	  $fohr = $fohc/$dlc;  
	  return $fohr;
  }
  
  function COHR() {
	  $q = "SELECT  direct_labor_cost, annual_cohc FROM financial";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $cohc = $row["annual_cohc"];
	  $dlc = $row["direct_labor_cost"];
	  $cohr = $cohc/$dlc; 
	  return $cohr;
	  
  }
  
  function CO() {
	  $q = "SELECT factoryOveheadRT_labor, direct_labor_wageRT FROM financial";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $FOHRl = $row["factoryOveheadRT_labor"];
	  $Cl = $row["direct_labor_wageRT"];
	  
	  $P_ID = $_GET['id'];
	  $q2 = "SELECT factory_overhead_rate FROM machines WHERE Machine_ID ='$P_ID'";
	  $result2 = query($q2);
	  $row2 = mysqli_fetch_array($result2); 
	  $FOHRm = $row2["factory_overhead_rate"];
	  $Cm = HourlyProductionRate();
	  
	  $Co = ($Cl *(1 + $FOHRl)) + ($Cm *(1 + $FOHRm)); 
	  return $Co;
  } 
  
  /* function CMP(){	
	  $cmp = ($coi * $tpi) + $cti; 
	  return $cmp;
  } */
  
  function CPC(){
	  $q = "SELECT cost_startingMaterial FROM financial";
	  $result = query($q);
	  $row = mysqli_fetch_array($result); 
	  $cm = $row["cost_startingMaterial"];
	  
	  $CMP = 30; //assumption of the cost of a part
	  $cpc = $cm + $CMP;  
	  return $cpc;
  } 

?>
</main>
</div>
<script src="scripts.js"></script>
 </body>
</html>