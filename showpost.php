<!DOCTYPE html>
<html>
<head>
	<title>Mini Craiglist - posts</title>
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
if ($_SERVER["REQUEST_METHOD"] == "GET") {


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


		//Get mapping of location name and category name
		$sql = "SELECT SubCategory_ID, SubCategoryName FROM subcategory";
		$result_subcategory = $conn->query($sql);

		

		$sql = "SELECT Location_ID, LocationName FROM location";
		$result_location = $conn->query($sql);	

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








		//Get posts
		$sql = "SELECT Title,Price,Description,Email,Image_1,Image_2,Image_3,Image_4,SubCategory_ID, Location_ID FROM posts WHERE ";

		if(!empty($_GET["location"])){
			$sql = $sql . "Location_ID = " . test_input($_GET["location"]);
		}
		else if(!empty($_GET["subcategory"])){
			$sql = $sql . "SubCategory_ID = " . test_input($_GET["subcategory"]);
		}
		else if(!empty($_GET["keyword"])){
			$sql = $sql . "Title LIKE " . '\'%' . test_input($_GET["keyword"]) . '%\' OR ';
			$sql = $sql . "Description LIKE " . '\'%' . test_input($_GET["keyword"]) . '%\'';	
		}
		else
			echo "No data";

		$result = $conn->query($sql);

		

		$conn->close();




}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<section>
<?php
	if(empty($result)){
			echo "<h1> No Result </h1>";
		}
		else{
		if ($result->num_rows <= 0) {
				    // output data of each row
			echo "<h1> No Result </h1>";
					    
		} else {
			while ($row = $result->fetch_assoc()) {
			echo "<div class=\"table-responsive\">";			
			echo "<table class=\"table table-bordered\">";
			echo "<tr>";
			echo "<td>Sub-Category</td>";
			echo "<td>" . $subcategoryMapping[$row["SubCategory_ID"]] . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td>Location</td>";
			echo "<td>" . $locationMapping[$row["Location_ID"]] . "</td>";
			echo "</tr>";		

			echo "<tr>";
			echo "<td>Title</td>";
			echo "<td>" . $row["Title"] . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td>Price</td>";
			echo "<td>" . $row["Price"] . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td>Description</td>";
			echo "<td><textarea class=\"form-control\" rows=\"6\" cols=\"42\" readonly>" . $row["Description"] . "</textarea></td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td>Email</td>";
			echo "<td>" . $row["Email"] . "</td>";
			echo "</tr>";

			echo "</table>";

			echo "<table>";

			if(!empty($row["Image_1"])){
				echo "<td>";
				echo "<img class=\"img-responsive\" src=";
				echo $row["Image_1"];
				echo ">"; 
				echo "</td>";
			}
			if(!empty($row["Image_2"])){
				echo "<td>";
				echo "<img class=\"img-responsive\" src=";
				echo $row["Image_2"];
				echo ">"; 
				echo "</td>";
			}
			if(!empty($row["Image_3"])){
				echo "<td>";
				echo "<img  class=\"img-responsive\" src=";
				echo $row["Image_3"];
				echo ">"; 
				echo "</td>";
			}

			if(!empty($row["Image_4"])){
				echo "<td>";
				echo "<img class=\"img-responsive\" src=";
				echo $row["Image_4"];
				echo ">"; 
				echo "</td>";
			}

			echo "</table>";
			echo "</div>";
			echo "<HR style=\"border:3 double #987cb9\" width=\"80%\" color=#987cb9 SIZE=3>";
		}
		}
	}
?>
</section>

</body>
</html>
