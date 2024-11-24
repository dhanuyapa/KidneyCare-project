<?php
// Include the database connection file
include('db_connection.php');

// Check if the NIC parameter is set in the URL
if (isset($_GET['nic'])) {
    // Sanitize the input
    $nic = $conn->real_escape_string($_GET['nic']);

    // Prepare the SQL query to delete the record
    $sql = "DELETE FROM kidney_patients WHERE nic = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nic);

        if ($stmt->execute()) {
            // Redirect to the fetch page after successful deletion
            header("Location: fetch.php?message=Record deleted successfully");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "NIC not provided.";
}

// Close the database connection
$conn->close();
?>
