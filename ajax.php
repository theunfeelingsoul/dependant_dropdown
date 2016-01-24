<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "majis";
// made connection
$conn = mysqli_connect($servername,$username,$password,$dbname);

// check connection
if (!$conn) {
	die(mysql_connection_error());
}

// get LGAs
if (isset($_GET['r'])) {
	$region = $_GET['r'];
	// $name = $_POST['n'];

	// create sql statement
	$sql = "SELECT lga FROM lgas where region ='$region'";
	// queried the database
	$result = mysqli_query($conn,$sql) or die (mysqli_error());

	if ($result) {

		$row_cnt = mysqli_num_rows($result);

		if ($row_cnt > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$data[]= $row['lga'];
			}
		}else{
			$data[] = "no records";
			// $data[]= $row['foodname'];
		}
		
	}else{
		$data[] = "querry error";
	}

	$data = json_encode($data);
	echo  $data;
}  // end if

// GET Wards
if (isset($_GET['l'])){
	// echo "gotten";
	$lga = $_GET['l'];
	// $name = $_POST['n'];

	// create sql statement
	$sql = "SELECT ward FROM wards where lga ='$lga'";
	// queried the database
	$result = mysqli_query($conn,$sql) or die (mysqli_error());

	if ($result) {

		$row_cnt = mysqli_num_rows($result);

		if ($row_cnt > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$data[]= $row['ward'];
			}
		}else{
			$data[] = "no records";
			// $data[]= $row['foodname'];
		}
		
	}else{
		$data[] = "querry error";
	}
	
	// change it to a jason array
	// you can use echo to display an array
	$data = json_encode($data);
	echo  $data;
}

if (isset($_GET['w'])) {

	$ward = $_GET['w'];
	$sql = "SELECT wpt_name,lng, lat, ward FROM waterpoints where ward ='$ward'";
	// queried the database
	$result = mysqli_query($conn,$sql) or die (mysqli_error());

	if ($result) {

		$row_cnt = mysqli_num_rows($result);
		$data="";
		$i=1;
		if ($row_cnt > 0) {
			while ($row = mysqli_fetch_assoc($result)) {

				if ($i==$row_cnt) {
					$data .= trim($row['wpt_name'],"").",".trim($row['lat'],"").",".trim($row['lng'],"");
				}else{
					$data .= trim($row['wpt_name'],"").",".trim($row['lat'],"").",".trim($row['lng'],"")."#";

				}
// echo trim($str,"Hed!");
				$i++;
			}
		}else{
			$data= "no records";
			// $data[]= $row['foodname'];
		}
		
	}else{
		$data= "querry error";
	}

	// change it to a jason array
	// you can use echo to display an array
	// $data = json_encode($data);
	// var_dump($data);
	echo  $data;
}


 ?>