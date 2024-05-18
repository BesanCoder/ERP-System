<!DOCTYPE html>
<html>
<head>
    <title>Parts</title>
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
   </style>
    <link rel="stylesheet" href="./Tablestyle.css">
</head>
<body>
<div class="grid-container">
<!---------Adds the Header and the sideBar-------------->
<?php
include 'C:\xampp\htdocs\ERP System\configuration.php';
include 'C:\xampp\htdocs\ERP System\layout\Header.html';
include('C:\xampp\htdocs\ERP System\layout\sidebar.html');
?>
 <!--/*-------------Main-------------*/ --> 
 <main class="main-container">
    <div class="main-title">
      <p class="font-weight-bold">products</p>
    </div>
      <?php
      $query = "SELECT * FROM part ORDER BY part_ID";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Product ID</th><th>Supplier ID</th><th>Name</th><th>Description</th><th>Price</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["Part_ID"] . "</td>";
            echo "<td>" . $row["Supplier_ID"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Description"] . "</td>";
            echo "<td>" . $row["price"] . "K </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }
?>
   </main>
</div>
<script src="scripts.js"></script>
 </body>
</html>