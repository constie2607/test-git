<?php
ob_start(); // Start output buffering

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "rentmycar";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching data from the form
$title = isset($_POST['title']) ? $_POST['title'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Proceed with database insertion
$sql = "INSERT INTO users (title, first_name, last_name, username, password, confirm_password, address, postcode, city, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind parameters to the statement
$stmt->bind_param("ssssssssss", $title, $fname, $lname, $username, $password, $confirm_password, $address, $postcode, $city, $email);

// Execute the statement
if ($stmt->execute()) {
   

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect to welcomePage.php
    header('Location: welcomePage.php');
    ob_end_flush(); // Flush output buffer and send the output to the browser
    exit; // Ensure that no other code gets executed after redirection
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
    ob_end_flush(); // Flush output buffer and send the output to the browser
}
?>
