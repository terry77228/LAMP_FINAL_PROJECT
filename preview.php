<!DOCTYPE html>
<html>
<head>
	<title>Mini Craiglist - preview</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>		
</head>

<body>

<?php
// define variables and set to empty values
$subcategory = $location = $title = $email = $price = $description = $confirmedEmail = $terms = "";
$image = [0=>"", 1=>"",2=>"",3=>""];
$subcategoryMapping = [];
$locationMapping = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$subcategory = test_input($_POST["subCategory"]);
		$location = test_input($_POST["location"]);
		$title = test_input($_POST["title"]);
		$email = test_input($_POST["email"]);
		$price = test_input($_POST["price"]);
		$description = test_input($_POST["description"]);


		$timestamp = time();
		$target_dir = "uploads/" . sha1($email . $timestamp) . "/";
		if(!file_exists("uploads"))
			mkdir("uploads");

		mkdir($target_dir);

		foreach( $_FILES[ 'image' ][ 'name' ] as $index => $Name ){
			if(!empty($Name)){
				$filename = trim(addslashes($_FILES['image']['name'][$index])) ;
				$filename = str_replace(' ', '_', $filename);
	        $target_file = $target_dir . basename($filename);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image"]["tmp_name"][$index]);
			    if($check !== false) {
			        move_uploaded_file($_FILES["image"]["tmp_name"][$index], $target_file);
			        $image[$index] = $target_file;
			        $uploadOk = 1;
			    } else {
			        $uploadOk = 0;
			    }
			}
		}
    }


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

		if ($result_subcategory->num_rows > 0) {
					    // output data of each row
					    while($row = $result_subcategory->fetch_assoc()) {
					    	$subcategoryMapping[$row["SubCategory_ID"]] = $row["SubCategoryName"];
					    }
					} else {
					    echo "0 results";
					}
		if ($result_location->num_rows > 0) {
					    // output data of each row
					    while($row = $result_location->fetch_assoc()) {
					    	$locationMapping[$row["Location_ID"]] = $row["LocationName"];
					    	
					    }
					} else {
					    echo "0 results";
					}

}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<section>


	<h1>Your post preview</h1>
	<form method="post" action="submitted.php" enctype=multipart/form-data accept-charset=utf-8>

		<table>
			<tr>
				<td>Sub-Category:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="text" name="subcategory" value="<?php echo $subcategoryMapping[$subcategory]; ?>" readonly></input>
				</div>
					<input type="hidden" name="subcategoryID" value="<?php echo $subcategory; ?>"></input>
				</td>
			</tr>
			<tr>
				<td>Location:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="text" name="location" value="<?php echo $locationMapping[$location];?>" readonly>
				</div>
					<input type="hidden" name="locationID" value="<?php echo $location; ?>"></input>
				</input></td>
			</tr>
			<tr>
				<td>Title:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="text" size="40" name="title" value="<?php echo $title;?>" readonly>
				</div>
				</td>
			</tr>	
			<tr>
				<td>Price:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="number" name="price" value="<?php echo $price;?>" readonly>
				</div>
				</td>
			</tr>				
			<tr>
				<td>Description:</td>
				<td>
				<div class="form-group">
				<textarea class="form-control" rows="6" cols="42" name="description" readonly><?php echo $description;?></textarea>
				</div>
				</td>
			</tr>		
			<tr>
				<td>Email:</td>
				<td>
				<div class="form-group">
				<input class="form-control" type="email" size="40" name="email" value="<?php echo $email;?>" readonly>
				</td>
				<td>
					
				</td>
				</div>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="btn btn-info" name="submit" value="Submit"></input>
				</td>
			</tr>

		</table>

		<input type="hidden" name="timestamp" value="<?php echo $timestamp;?>"></input>
		</br>
		<table>
			<tr>
				
				<td>
				<?php
				if(!empty($image[0])){
				echo "<img class=\"img-responsive\" src=";
				echo $image[0];
				echo ">"; 
				}
				?>
				</td>
				<td><input type="hidden" name="img1" value="<?php echo $image[0];?>"></input></td>
			</tr>
			<tr>
				
				<td>
				<?php
				if(!empty($image[1])){
				echo "<img class=\"img-responsive\" src=";
				echo $image[1];
				echo ">"; 
				}
				?>
				</td>
				<td><input type="hidden" name="img2" value="<?php echo $image[1];?>"></input></td>
			</tr>		
			<tr>
				
				<td>
				<?php
				if(!empty($image[2])){
				echo "<img class=\"img-responsive\" src=";
				echo $image[2];
				echo ">"; 
				}
				?>
				</td>
				<td><input type="hidden" name="img3" value="<?php echo $image[2];?>"></input></td>
			</tr>
			<tr>
				
				
				<td>
				<?php
				if(!empty($image[3])){
				echo "<img class=\"img-responsive\" src=";
				echo $image[3];
				echo ">"; 
				}
				?>
				</td>
				<td><input type="hidden" name="img4" value="<?php echo $image[3];?>"></input></td>
			</tr>

		</table>
		
	</form>

</section>

</body>
</html>
