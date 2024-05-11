<?php
session_start();
include('config.php');

if(isset($_GET["userID"]) && $_GET["userID"] != "" && isset($_GET["userEmail"]) && $_GET["userEmail"] != ""){
  $userID = $_GET["userID"];
  $userEmail = $_GET["userEmail"];

    // SQL statement to delete user based on userID and userEmail
    $sql = "DELETE FROM User WHERE userID = ? AND userEmail = ?";

    // Using prepared statements for security
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "is", $userID, $userEmail);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Close the statement

        // Redirect user after successful deletion
        header('Location: accVerify.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn) . "<br>";
        echo '<a href="accVerify.php">Back</a>';
    }
} else {
    echo "Invalid parameters provided.<br>";
    echo '<a href="accVerify.php">Back</a>';
}

mysqli_close($conn);
?>
