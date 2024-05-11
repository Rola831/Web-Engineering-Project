<?php
session_start();
include('config.php');

// Check if logged-in
if (!isset($_SESSION["UID"]) || empty($_SESSION["UID"])) {
    header("location: index.php");
    exit; // Ensuring script stops execution after redirection
}

$userID = $_SESSION["UID"];

// Using prepared statements for security
$sql = "DELETE FROM User WHERE userID = ?";

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "i", $userID);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Close the statement
        mysqli_stmt_close($stmt);

        // Redirect user after successful deletion
        header('Location: index.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn) . "<br>";
        echo '<a href="index.php">Back</a>';
    }
} else {
    echo "Error preparing statement: " . mysqli_error($conn) . "<br>";
    echo '<a href="index.php">Back</a>';
}

mysqli_close($conn);
?>
