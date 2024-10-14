<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Caravan Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30;
            padding: 30;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: aliceblue;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin: 15px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
            margin: 15px;
        }
        .discard-button {
            background-color: #dc3545;
        }
        .discard-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Caravan</h1>

    <?php
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $databasename1 = "rentmycar";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $databasename1);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $vehicleId = $_POST['vehicleId'];
        $vehicleMake = $_POST['vehicleMake'];
        $vehicleModel = $_POST['vehicleModel'];
        $vehicleBodyType = $_POST['vehicleBodyType'];
        $fuelType = $_POST['fuelType'];
        $mileage = $_POST['mileage'];
        $location = $_POST['location'];
        $year = $_POST['year'];
        $numberOfDoors = $_POST['numberOfDoors'];
        $image_url = $_POST['image_url'];

        // Prepare SQL statement to update the database
        $sql = "UPDATE vehicle_details SET 
                vehicle_make = '$vehicleMake', 
                vehicle_model = '$vehicleModel', 
                vehicle_bodytype = '$vehicleBodyType', 
                fuel_type = '$fuelType', 
                mileage = '$mileage', 
                location = '$location', 
                year = '$year', 
                num_doors = '$numberOfDoors', 
                image_url = '$image_url' 
                WHERE vehicle_id = '$vehicleId'";

        // Execute SQL statement
        if (mysqli_query($conn, $sql)) {
            // Redirect to CaravanList.php after successful update
            header("Location: CaravanList.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        // Fetch existing data from the database based on vehicleId
        if(isset($_GET['vehicleId'])){
            $vehicleId = $_GET['vehicleId']; // Corrected variable name

            $sql = "SELECT * FROM vehicle_details WHERE vehicle_id = '$vehicleId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    $vehicleId = $row['vehicle_id'];
                    $vehicleMake = $row['vehicle_make'];
                    $vehicleModel = $row['vehicle_model'];
                    $vehicleBodyType = $row['vehicle_bodytype'];
                    $fuelType = $row['fuel_type'];
                    $mileage = $row['mileage'];
                    $location = $row['location'];
                    $year = $row['year'];
                    $numberOfDoors = $row['num_doors'];
                }
            } else {
                echo "0 results";
            }
        }
    }
    ?>

    <form method="post">
        <label for="vehicleId">Vehicle ID:</label>
        <input type="text" id="vehicleId" name="vehicleId" value="<?php if(isset($vehicleId)) echo $vehicleId; ?>" placeholder="Enter Vehicle ID">

        <label for="vehicleMake">Vehicle Make:</label>
        <input type="text" id="vehicleMake" name="vehicleMake" value="<?php if(isset($vehicleMake)) echo $vehicleMake; ?>" placeholder="Enter Vehicle Make" required>

        <label for="vehicleModel">Vehicle Model:</label>
        <input type="text" id="vehicleModel" name="vehicleModel" value="<?php if(isset($vehicleModel)) echo $vehicleModel; ?>" placeholder="Enter Vehicle Model" required>

        <label for="vehicleBodyType">Vehicle Body Type:</label>
        <input type="text" id="vehicleBodyType" name="vehicleBodyType" value="<?php if(isset($vehicleBodyType)) echo $vehicleBodyType; ?>" placeholder="Enter Vehicle Body Type" required>

        <label for="fuelType">Fuel Type:</label>
        <input type="text" id="fuelType" name="fuelType" value="<?php if(isset($fuelType)) echo $fuelType; ?>" placeholder="Enter Fuel Type" required>

        <label for="mileage">Mileage:</label>
        <input type="text" id="mileage" name="mileage" value="<?php if(isset($mileage)) echo $mileage; ?>" placeholder="Enter Mileage" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php if(isset($location)) echo $location; ?>" placeholder="Enter Location" required>

        <label for="year">Year:</label>
        <input type="text" id="year" name="year" value="<?php if(isset($year)) echo $year; ?>" placeholder="Enter Year" required>

        <label for="numberOfDoors">Number of Doors:</label>
        <input type="text" id="numberOfDoors" name="numberOfDoors" value="<?php if(isset($numberOfDoors)) echo $numberOfDoors; ?>" placeholder="Enter Number of Doors" required>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php if(isset($image_url)) echo $image_url; ?>" placeholder="Enter Image URL">

        <button type="submit" class="save-Changes">Submit</button>
        <button type="button" class="discard-button" onclick="discardChanges()">Discard Changes</button>
    </form>
</div>

<script>
    function discardChanges() {
        if (confirm("Are you sure you want to discard changes?")) {
            window.location.href = "homepage.html";
        }
    }
</script>

</body>
</html>
