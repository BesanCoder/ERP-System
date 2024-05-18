
<?php 

if(isset($_GET['id'])){
	echo "Total number of products = ".TotalNumberOfProducts()."<br>";
	echo "Total Number Of Parts = ".TotalNumOfParts()."<br>";
    echo "Cycle Time = ".CycleTime()."<br>";
	echo "Job Shop Production Time = ".JobShopProductionTime()."<br>";
	echo "Hourly Production Rate = ".HourlyProductionRate()."<br>";
	echo "Availability = ".Availability()."<br>";
	echo "Production Capacity = ".ProductionCapacity()."<br>";
	echo "Utilization = ".Utilization()."<br>";
	echo "Production Rate Of Machine = ".ProductionRateOfMachine()."<br>";
	echo "Manufacturing Lead Time = ".ManufacturingLeadTime()."<br>";
	echo "Total Annual Cost = ".TotalAnnualCost()."<br>";
	echo "Capital Recovery Factor = ".CRF()."<br>";
	echo "Uniform Annual Cost = ".UAC()."<br>";
	echo "Factory Overhead Rate = ".FOHR()."<br>";
	echo "Corporate Overhead Rate = ".COHR()."<br>";
	echo "Work In Process = ".WorkInProcess()."<br>";
	echo "Cost per piece = ".CPC()."<br>";	
	echo "Hourly Rate to Operate the Machine = ".CO()."<br>";
	
	//Inventory Functions
	echo "<br> Inventory Functions: <br> Average Cycle Inventory = ".AverageCycleInventory()."<br>";
	echo "Pipeline Inventory = ".PipelineInventory()."<br>";
	echo "Annual Holding Cost = ".AnnualHoldingCost()."<br>";
	echo "Annual Ordering Cost = ".AnnualOrderingCost()."<br>";
	echo "TotalAnnualCycleInventoryCost = ".TotalAnnualCycleInventoryCost()."<br>";
	echo "TotalAnnualCycleInventoryCost2 = ".TotalAnnualCycleInventoryCost2()."<br>";
	echo "Economic Order Quantity = ".EOQ()."<br>";
	echo "Time Between Orders = ".TBO()."<br>";
	echo "Inventory Position = ".InventoryPosition()."<br>";
	echo "Re-Order Point = ".ROP()."<br>";
	
	//SUPPLY CHAIN FUNCTIONS 
	echo "<br> Supplychain Functions: <br>";
	echo "Material Costs = ".MaterialCosts()."<br>";
	echo "Annual Inventory Cost = ".AnnualInventoryCost()."<br>";
	echo "Freight minus shipmen t= ".Freightminusshipment()."<br>";
	echo "Total Annual Cost SCM = ".TotalAnnualCostSCM()."<br>";
	echo "Total Annual Costs = ".TotalAnnualCosts()."<br>";
	/* 
	echo "Cost of a Manufacturing Part = ".CMP()."<br>";  
	
	echo "Average Hourly Plant Production Rate = ".AverageHourlyPlantProductionRate()."<br>"; 
	
	echo "Average Production Time Of Part On Machine = ".AverageProductionTimeOfPartOnMachine()."<br>"; 
	 */
}
//CH2 FUNCTIONS
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
		return $fij;
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

//INVENTORY FUNCTIONS 
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

/* function StandardDeviationOfDemandDuringLeadTime()
	{
		$q = "SELECT lead_time FROM inventory";
		$result = query($q);
		$row = mysqli_fetch_array($result); 
		$l = $row["lead_time"];	
		$stddlt= $std * sqrt($l);
		return $stddlt;
	}

function SafetyStock()
	{
		$ss = $z * StandardDeviationOfDemandDuringLeadTime();
		return $ss;
	}

function VariableStandardDeviationOfDemandDuringLeadTime()
	{
		$vstddlt= sqrt($l * $std * $std + $d * $d * $stdlt * $stdlt);
		return $stddlt;
	}
	
function TotalCost()
	{
		$tt = TotalAnnualCycleInventoryCost2() * SafetyStock();
		return $tt;
	} */
	
//SUPPLY CHAIN FUNCTIONS 

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
	$aic = (AverageCycleInventory() + PipelineInventory())* $h;
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
	$tac=  MaterialCosts() + AnnualInventoryCost() + $administrativeCosts;
	return $tac;
}

function TotalAnnualCosts()
{
	$q = "SELECT freight_cost, admin_cost FROM supply";
	$result = query($q);
	$row = mysqli_fetch_array($result); 
	$freightcosts = $row["freight_cost"];
	$administrativeCosts = $row["admin_cost"];
	$tac = MaterialCosts()+ $freightcosts +AnnualInventoryCost()+ $administrativeCosts;
	return $tac;
}
	
?>