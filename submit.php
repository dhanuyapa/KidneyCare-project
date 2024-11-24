<?php
// Include the database connection file
include('db_connection.php');

// Enable error reporting to debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_type = trim($_POST['blood_type']); // Trim any extra spaces
    $address = $_POST['address'];
    $nic = $_POST['nic'];

    // Debugging: Check the blood type value
    echo "Blood Type: " . $blood_type;  // This will print the blood type value

    // Check if blood type is empty or invalid
    if (empty($blood_type) || !in_array($blood_type, ["A", "B", "AB", "O", "A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"])) {
        die("Invalid blood type");
    }

    // Prepare the SQL query with placeholders for security (prevent SQL injection)
    $sql = "INSERT INTO kidney_patients (first_name, last_name, dob, gender, email, phone, blood_type, address, nic) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the form data to the SQL statement
        $stmt->bind_param("sssssssss", $first_name, $last_name, $dob, $gender, $email, $phone, $blood_type, $address, $nic);

        // Execute the statement
        if ($stmt->execute()) {
            // Record added successfully, redirect or show success message
            echo "Record added successfully.";
            header("Location: submit.php"); // Redirect to index.php after success
            exit(); // Always call exit() after header redirection
        } else {
            // Show any SQL errors
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Show error if preparation fails
        echo "Error: " . $conn->error;
    }
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/submit.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>




    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
</head>
<body>

<div class="Title">Kidney Patient Registration Form</div>


<div class="container">
        <!-- First Grid Section -->
        <div class="grid1">
         
            <div class="image">
            <img src="image 2.png" alt="Yoga Image" ></div>
            
            <form method="POST" action="submit.php">
        <div class="first">
       
        <input type="text" name="first_name" placeholder="First Name" required style="width: 280px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br>


     
        <input type="text" name="last_name"  placeholder="Last Name" required style="width: 240px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br>
</div>


<div class="first">
       
        <input type="date" name="dob" placeholder="Date of Birth" required style="width: 220px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br>
        <input type="text" name="nic" placeholder="NIC" required style="width: 280px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br></div>

        <div class="first">
    <div class="gender">
        <select name="gender" required style="width: 270px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div class="first">
    <label for="blood_type" style="margin-top: 10px; font-size: 16px;">Blood </label>
    <select name="blood_type" required style="width: 225px; height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="AB">AB</option>
        <option value="O">O</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
</div></div>


    <div class="first">
        <input type="email" name="email" placeholder="Email" required style="width: 280px; height: 40px;margin-top: 10px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br>

      
        <input type="text" name="phone" placeholder="Phone" required style="width: 280px; margin-top: 10px; ;height: 40px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px;"><br><br>
</div>

      
        

<div class="address">
        <textarea name="address" placeholder="Address" required style="width: 580px; height: 60px; padding: 5px; font-size: 16px; border: 1px solid #ddd; border-radius: 4px; margin-left:-10px"></textarea><br><br></div>


       
<div class="submit-button">
        <button type="submit">Register Needer</button></div>

        <p  class="line">Click to see the Needer Details<span style="color: red;">Needer</span</p> 
    </form>
        </div>

        <!-- Second Grid Section -->
        <div class="grid2">
          
            <p>TWhen adding your kidney Need details to our plattorm,
"it is essential that all
information provided is accurate and true to the best of your knowledge.
Participation is entirely voluntary, and we encourage only those who are genuinely willing to share their information to proceed.
Individuals in need of a kidney can register their need on our platform. By registering, you none to rovide on ratardio yeter
condition and requirements. Please be aware that Renalwise serves as a platform to code ting potential not verify one
intedonation proided by users</p>
            
        </div>
    </div>



</div>
</body>
</html>
