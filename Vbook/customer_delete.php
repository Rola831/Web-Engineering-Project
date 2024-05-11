<?php
session_start();
include('config.php');

if(isset($_GET["userID"]) && $_GET["userID"] != "" && isset($_GET["book_id"]) && $_GET["book_id"] != ""){
  $userID = $_GET["userID"];
  $book_id = $_GET["book_id"];

    // SQL statement to delete user based on userID and userEmail
    $sql = "DELETE FROM booking WHERE userID = ? AND book_id = ?";

    // Using prepared statements for security
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $userID, $book_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Close the statement

        // Redirect user after successful deletion
        header('Location: customer.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn) . "<br>";
        echo '<a href="customer.php">Back</a>';
    }
} else {
    echo "Invalid parameters provided.<br>";
    echo '<a href="customer.php">Back</a>';
}

mysqli_close($conn);
?>
