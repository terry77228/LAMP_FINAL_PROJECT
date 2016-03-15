<!DOCTYPE html>
<html>
<head>
	<title>Mini craiglist - new post</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>		
</head>
<style type="text/css">

.error{
	color: red;
}
</style>

<body>

<script type="text/javascript">
	function validateForm(){
		var valid = true;
		
		var data = document.forms["saledata"]["title"].value;
		if (data == null || data =="") {
			document.getElementById("titleError").innerHTML="* Title is required";
			valid = false;
		}
		else{
			document.getElementById("titleError").innerHTML="* ";
		}
		data = document.forms["saledata"]["price"].value;
		if (data == null || data =="") {
			document.getElementById("priceError").innerHTML="* Price is required";
			valid = false;
		}
		else if(data < 0.0){
			document.getElementById("priceError").innerHTML="* Price must be non-negative";
			valid = false;	
		}
		else{
			document.getElementById("priceError").innerHTML="* ";
		}
		data = document.forms["saledata"]["description"].value;
		if (data == null || data =="") {
			document.getElementById("descriptionError").innerHTML="* Description is required";
			valid = false;
		}
		else{
			document.getElementById("descriptionError").innerHTML="* ";
		}
		data = document.forms["saledata"]["email"].value;
		if (data == null || data =="") {
			document.getElementById("emailError").innerHTML="* Email is required";
			valid = false;
		}
		else{
			document.getElementById("emailError").innerHTML="* ";
		}
		var confirmData = document.forms["saledata"]["confirmedEmail"].value;
		if (data == null || data =="" || data != confirmData) {
			document.getElementById("confirmError").innerHTML="* Email doesn't match";
			valid = false;
		}
		else{
			document.getElementById("confirmError").innerHTML="*";
		}

		data = document.getElementById("agree").checked;
		if (data == null || data =="" || data == false) {
			document.getElementById("termsError").innerHTML="* You must agree terms and conditions";
			valid = false;
		}
		else{
			document.getElementById("termsError").innerHTML="* ";
		}
		return valid;
	}

	function reset(){
		document.forms["saledata"]["title"].value = "";
		document.forms["saledata"]["price"].value = "";
		document.forms["saledata"]["description"].value = "";
		document.forms["saledata"]["email"].value = "";
		document.forms["saledata"]["confirmedEmail"].value = "";
		document.getElementById("agree").checked=false;
	}
</script>


<?php
//Connect to sql and store posts into sql
		$servername = "localhost";
		$username = "lamp";
		$password = "";
		$dbname = "lamp_homework";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "SELECT SubCategory_ID, SubCategoryName FROM subcategory";
		$result_subcategory = $conn->query($sql);

		

		$sql = "SELECT Location_ID, LocationName FROM location";
		$result_location = $conn->query($sql);	

		$conn->close();

?>

<section>
	<form name="saledata" method="post" action="preview.php" enctype=multipart/form-data accept-charset=utf-8 onsubmit="return validateForm();">
		<table class="table table-condensed">
			<tr>
				<td>Sub-Category:</td>
				<td>
				<div class="form-group">
				<select class="form-control" name="subCategory">

				<?php
					if ($result_subcategory->num_rows > 0) {
					    // output data of each row
					    while($row = $result_subcategory->fetch_assoc()) {
					    	echo "<option value=\"" . $row["SubCategory_ID"] . "\">" . $row["SubCategoryName"] ."</option>";
					        //echo "id: " . $row["SubCategory_ID"]. " - Name: " . $row["SubCategoryName"] . "<br>";
					    }
					} else {
					    echo "0 results";
					}

				?>
					
				</select>
				</div>
				</td>
				<td>Select a sub-category</td>
			</tr>
			<tr>
				<td>Location:</td>
				<div class="form-group">
				<td><select class="form-control" name="location">
				<?php
					if ($result_location->num_rows > 0) {
					    // output data of each row
					    while($row = $result_location->fetch_assoc()) {
					    	echo "<option value=\"" . $row["Location_ID"] . "\">" . $row["LocationName"] ."</option>";
					    }
					} else {
					    echo "0 results";
					}

				?>
				</select>
				</div>
				</td>
				<td>Select a location</td>
			</tr>
			<tr>
				<td>Title:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="text" size="40" name="title">
				</div>
				</td>
				<td><span class="error" id="titleError">* </span></td>
			</tr>	
			<tr>
				<td>Price:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="number" name="price">
				</div>
				</td>
				<td><span class="error" id="priceError">* </span></td>
			</tr>				
			<tr>
				<td>Description:</td>
				<td>
				<div class="form-group">
				<textarea class="form-control" rows="6" cols="42" name="description" ></textarea>
				</div>
				</td>
				<td><span class="error" id="descriptionError">* </span></td>
			</tr>		
			<tr>
				<td>Email:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="email" size="40" name="email" >
				</div>
				</td>
				<td><span class="error" id="emailError">* </span></td>
			</tr>			
			<tr>
				<td>Confirm Email:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="email" size="40" name="confirmedEmail" >
				</div>
				</td>
				<td><span class="error" id="confirmError">* </span></td>
			</tr>
		</table>
		
		<p>I agree with terms and conditions<input type="checkbox" id="agree" name="terms" ><span class="error" id="termsError">* </span></p>
		<br>
		Optional fields:

		<table>
			<tr>
				<td>Image 1 (max 5MB):</td>
				<td></td>
				<td><input type="file" name="image[]"></td>
			</tr>
			<tr>
				<td>Image 2 (max 5MB):</td>
				<td></td>
				<td><input type="file" name="image[]"></td>
			</tr>		
			<tr>
				<td>Image 3 (max 5MB):</td>
				<td></td>
				<td><input type="file" name="image[]"></td>
			</tr>
			<tr>
				<td>Image 4 (max 5MB):</td>
				<td></td>
				<td><input type="file" name="image[]"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Preview"> <input type="button" value="Reset" onclick="reset();">
	</form>


</section>

</body>
</html>
