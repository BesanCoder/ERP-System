<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="./stylesheet.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">    
  <style>
body { margin:0%;  
    padding: 0%;
    box-sizing: border-box;
    background-color: #e6e8ed;
    color: #666666;}
   </style>
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
      <p class="font-weight-bold">DASHBOARD</p>
    </div>
    <div class="main-cards">
      <div class="card">
        <div class="card-inner">
          <p class="text-primary">PRODUCTS</p>
          <span class="material-icons-outlined text-blue">inventory_2</span>
        </div>
        <span class="text-primary font-weight-bold">10</span>
      </div>

      <div class="card">
        <div class="card-inner">
          <p class="text-primary">PURCHASE ORDERS</p>
          <span class="material-icons-outlined text-orange">add_shopping_cart</span>
        </div>
        <span class="text-primary font-weight-bold">40</span>
      </div>
      <div class="card">
        <div class="card-inner">
          <p class="text-primary">INVENTORY ALERTS</p>
          <span class="material-icons-outlined text-green">notification_important</span>
        </div>
        <span class="text-primary font-weight-bold">0</span>
      </div>
    </div>
    <!--/*-------------charts -------------*/ --> 
    <div class="charts">
      <div class="charts-card">
        <p class="chart-title">Top 4 Models</p>
        <div id="bar-chart"></div>
     </div>

      <div class="charts-card">
        <p class="chart-title">Purchase and Sales Orders</p>
        <div id="area-chart"></div>
      </div>
    </div>
  </main>
</div>
 <!--/*-------------Scripts-------------*/ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.1/apexcharts.min.js"></script>
<script src="scripts.js"></script>

 </body>
</html>
