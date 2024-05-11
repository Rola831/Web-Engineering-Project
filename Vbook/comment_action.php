<?php
session_start();
include('config.php');

// Get userID, rating, and comment from POST data
$rating = $_POST['rating']; // Assuming the rating is passed as a POST parameter
$comment = $_POST['comment']; // Assuming the comment is passed as a POST parameter

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO comments (userID, rating, comment) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $_SESSION["UID"], $rating, $comment);

// Execute the SQL statement
if ($stmt->execute()) {
    echo "Comment submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}
 ?>
