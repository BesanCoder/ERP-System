<?php
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'erp'; 

$conn = mysqli_connect($host, $dbUsername, $dbPassword, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
function query($q) {
    global $conn;
    return mysqli_query($conn,$q);}
?>