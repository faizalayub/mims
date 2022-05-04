<?php
//Include database configuration file

$connect = mysqli_connect("localhost","root","","inventory_management");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}


if(isset($_POST["agency_id"])){
    //Get all state data
	$agency_id= $_POST['agency_id'];
    $query = "SELECT * FROM site WHERE agency_id = '$agency_id' 
	ORDER BY site_desc ASC";
	$run_query = mysqli_query($connect, $query);
    
    //Count total number of rows
    $count = mysqli_num_rows($run_query);
    
    //Display states list
    if($count > 0){
        echo '<option value="" Please Select Site </option>';
        while($row = mysqli_fetch_array($run_query)){
		$site_id=$row['site_id'];
		$site_desc=$row['site_desc'];
        echo "<option value='$site_id'>$site_desc</option>";
        }
    }else{
        echo '<option value="">City not available</option>';
    }
}

?>