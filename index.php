
<?php
	include 'database.php';
	if (isset($_GET['submit'])) {
		echo $name = $_GET['name'];
		echo "<br/>";
		echo $city = $_GET['city'];
		echo "<br/>";
		echo $food = $_GET['food'];
		echo "<br/>";
	}

	$sql = "SELECT * FROM regions";

	$result = mysqli_query($conn,$sql) or die(mysqli_error());

	while ($row = mysqli_fetch_assoc($result)) {
		$regions[] = array(
			'region' => $row['region']
			);

	}





  ?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<br/>
<a href="dd.php">RELOAD</a>
<BR>
<form action="" method="get" id="admin_divsion">
	<div class="col-sm-3">
	<select id="region" name="name" class="form-control">
		<option>Choose region</option>
		<?php 
			foreach ($regions as  $region) {
				?>
					<option><?php echo $region['region'] ?></option>
				<?php
			}
		 ?>
		
	</select>
	</div>
	<div class="col-sm-3">
	<select id="lga" name="city" disabled="true" class="form-control">
		<option>select city</option>
	</select>
	</div>

	<div class="col-sm-3">
	<select id="ward" name="food" disabled="true" class="form-control">
		<option>select food</option>
		
	</select>
	</div>
	<input type="submit" name="submit"/>
</form>

<div id="map" class="container-fluid" style="height: 400px;"></div>
						</div>


<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script type="text/javascript">
		

		// on change get the value of the select option
		var $region = $("#region");
		var $lga = $("#lga");
		var $ward = $("#ward");

		$( "#admin_divsion" ).submit(function( event ) {
			var w = $ward.val();
			event.preventDefault();
		
		}); // end submit function  and maps
		
		// STEP 1 : CHOOSE REGION
		// get the list of LGA's 
		// dpendant on the REGION  chosen
		$region.on("change",function(){
			// clear the next two selects tags
			$('#lga').empty();
			$('#ward').empty();
			// disable the #ward select
			$('#ward').prop("disabled",true);
			// eneable the #lga select
			$('#lga').prop("disabled",false);
			
			//get the value of #region select chosen
			var r = $region.val();
	        // send the value to query the database
	        // use ajax post
			$.post( "ajax.php?r="+r, function( data ) {
				// set the first select option for #lga as select LGA
				// set the first select option for #ward as select Ward
				$('#lga').append($("<option></option>").attr("value","0").text("select LGA"));
				$('#ward').append($("<option></option>").attr("value","0").text("select Ward"));
				//then populate the #lga select 
				var selectValues = data;
				// use Jason.parse() to convert the data to an object
				// because the $.each function works on objects
				$.each(JSON.parse(selectValues), function(key, value) {   
				     $('#lga')
				         .append($("<option></option>")
				         // you can write it as
				         // .attr("value",key) 
				         // if you want the value attribute to be numbered 
				         .attr("value",value) 
				         .text(value)); 
				});
			}); // end post
	    });

		// STEP 2:CHOOSE LGA
	    $lga.on("change",function(){
    		// clear the #ward select
			$('#ward').empty();
			// enable the #ward select
			$('#ward').prop("disabled",false);

			//get the chosen value for the #lga 
			var l = $lga.val()
			console.log(l);

	        // send the value to query the database
			$.post( "ajax.php?l="+l, function( data ) {
				//populate the select 
				var selectValues = data;
				console.log(data);
				// set the first option for asthetic. to say what the select if for
				$('#ward').append($("<option></option>").attr("value","0").text("select Ward")); 
				// use Jason.parse() to convert the data to an object
				// because the $.each function works on objects
				
				$.each(JSON.parse(selectValues), function(key, value) {   
					$('#ward')
						.append($("<option></option>")
						// you can write it as
						// .attr("value",key) 
						// if you want the value attribute to be numbered 
						.attr("value",value)
						.text(value)); 
				});
			}); // end post
	    });

		
	</script>