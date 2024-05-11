<?php
session_start();
include('config.php');

if(isset($_GET["userID"]) && $_GET["userID"] != "" && isset($_GET["venue_id"]) && $_GET["venue_id"] != ""){
  $userID = $_GET["userID"];
  $venue_id = $_GET["venue_id"];

    // SQL statement to delete user based on userID and userEmail
    $sql = "DELETE FROM venue WHERE userID = ? AND venue_id = ?";

    // Using prepared statements for security
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $userID, $venue_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Close the statement

        // Redirect user after successful deletion
        header('Location: venueRecord.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn) . "<br>";
        echo '<a href="venueRecord.php">Back</a>';
    }
} else {
    echo "Invalid parameters provided.<br>";
    echo '<a href="venueRecord.php">Back</a>';
}

mysqli_close($conn);
?>
