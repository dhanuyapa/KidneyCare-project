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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kidney Patient Registration</title>
</head>
<body>
    <h1>Kidney Patient Registration Form</h1>
    <form method="POST" action="submit.php">
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" required><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" name="dob" required><br><br>

        <label for="gender">Gender:</label><br>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <label for="blood_type">Blood Type:</label><br>
        <select name="blood_type" required>
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
        </select><br><br>

        <label for="address">Address:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label for="nic">NIC:</label><br>
        <input type="text" name="nic" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
