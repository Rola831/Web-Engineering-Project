<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $venue_id = $_POST['venue_id'];
    $comment = $_POST['comment'];      // Changed from 'userComment' to 'comment'
    $rating = $_POST['rating'];        // Changed from 'ratingInput' to 'rating'

    $sql = "INSERT INTO comments (venue_id, userID, comment_text, star_rating) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisi", $venue_id, $userID, $comment, $rating);
        if (mysqli_stmt_execute($stmt)) {
            echo "Comment added successfully!";
        } else {
            echo "Error executing statement: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} else {
    echo "Error: Invalid request method.";
}
?>
