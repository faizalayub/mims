<!-- <?php
$connect = mysqli_connect('localhost', '', '', 'inventory_management');
if ($connect->connect_error) {
die("Database Connection failed: " . $connect->connect_error);
}
?> -->

<?php
$connect = mysqli_connect("localhost","root","","inventory_management");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>