<!DOCTYPE html>
<html>
<head>
	<title>Mini criaglist - Summited</title>
</head>
<style type="text/css">
	
body{

background-color: #9E9E9E;
}

.error{
	color: red;
}
</style>

<body>

<?php
// define variables and set to empty values
$subcategory = $location = $title = $email = $price = $description = $confirmedEmail = $terms = $img1 = $img2 = $img3 = $imge = $img5 = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$subcategoryID = $_POST["subcategoryID"];
		$locationID = $_POST["locationID"];
		$title = test_input($_POST["title"]);
		$email = test_input($_POST["email"]);
		$price = test_input($_POST["price"]);
		$description = test_input($_POST["description"]);
		$img1 = test_input($_POST["img1"]);
		$img2 = test_input($_POST["img2"]);
		$img3 = test_input($_POST["img3"]);
		$img4 = test_input($_POST["img4"]);
		$timestamp = $_POST["timestamp"];
		

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
		echo "Connected successfully<br>";

		$sql = "INSERT INTO posts (Title, Price, Description, Email, Timestamp, SubCategory_ID, Location_ID, Image_1, Image_2, Image_3, Image_4)
				VALUES ('$title', $price, '$description', '$email', $timestamp, $subcategoryID, $locationID,'$img1','$img2','$img3','$img4')";

		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully<br>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
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
	<h1>Your post is submitted</h1>
	<input type="button" onclick="location.href='index.html';" value="Go back" />
</section>

</body>
</html>
