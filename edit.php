<?php
// Include the database connection file
include('db_connection.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    } else {
        echo "Query preparation failed: " . $conn->error;
        exit();
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
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Query preparation failed: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/submit.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kidney Patient Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-group {
            width: 48%; /* Two columns with spacing */
            margin-bottom: 15px;
        }

        .form-group textarea {
            width: 100%;
            height: 100px;
            resize: none;
        }

        input, select, textarea {
            width: 100%;
            height: 40px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            margin-left:250px;
          
            justify-content: center;
            width: 50%;
            height: 45px;
            font-size: 18px;
            background-color: #d88080;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .form-group {
                width: 100%; /* Single column on smaller screens */
            }
        }
    </style>
</head>
<body>
    <h1>Edit Kidney Patient Record</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php echo $patient['gender'] == "Male" ? "selected" : ""; ?>>Male</option>
                <option value="Female" <?php echo $patient['gender'] == "Female" ? "selected" : ""; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label for="blood_type">Blood Type:</label>
            <input type="text" id="blood_type" name="blood_type" value="<?php echo htmlspecialchars($patient['blood_type']); ?>" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
        </div>

        <div class="form-group" style="width: 50%;">
            <button type="submit">Save</button>
        </div>
    </form>
</body>
</html>
