<?php
// Include the database connection file
include('db_connection.php');

// Check if the NIC parameter is set in the URL
if (isset($_GET['nic'])) {
    // Get and sanitize the NIC value
    $nic = $conn->real_escape_string($_GET['nic']);

    // Fetch the record with the given NIC
    $sql = "SELECT * FROM kidney_patients WHERE nic = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nic);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the record exists
        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
        } else {
            echo "No record found for NIC: $nic";
            exit();
        }
        $stmt->close();
    }
} else {
    echo "NIC not provided.";
    exit();
}

// Update the record if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_type = $_POST['blood_type'];
    $address = $_POST['address'];

    // Prepare the SQL query to update the record
    $update_sql = "UPDATE kidney_patients SET first_name = ?, last_name = ?, dob = ?, gender = ?, email = ?, phone = ?, blood_type = ?, address = ? WHERE nic = ?";
    if ($stmt = $conn->prepare($update_sql)) {
        $stmt->bind_param("sssssssss", $first_name, $last_name, $dob, $gender, $email, $phone, $blood_type, $address, $nic);
        if ($stmt->execute()) {
            // Redirect to the fetch page with a success message
            header("Location: fetch.php?message=Record updated successfully");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kidney Patient Record</title>
</head>
<body>
    <h1>Edit Kidney Patient Record</h1>
    <form method="POST" action="">
        <label for="first_name">First Name:</label><br>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required><br><br>

        <label for="gender">Gender:</label><br>
        <select name="gender" required>
            <option value="Male" <?php echo $patient['gender'] == "Male" ? "selected" : ""; ?>>Male</option>
            <option value="Female" <?php echo $patient['gender'] == "Female" ? "selected" : ""; ?>>Female</option>
        </select><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required><br><br>

        <label for="phone">Phone:</label><br>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required><br><br>

        <label for="blood_type">Blood Type:</label><br>
        <input type="text" name="blood_type" value="<?php echo htmlspecialchars($patient['blood_type']); ?>" required><br><br>

        <label for="address">Address:</label><br>
        <textarea name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea><br><br>

        <button type="submit">Save</button>
    </form>
</body>
</html>
