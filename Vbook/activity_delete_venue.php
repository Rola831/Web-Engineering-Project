<?php
session_start();
include('config.php');

if(isset($_GET['venue_id']) && isset($_GET['book_id'])) {
    $venue_id = $_GET['venue_id'];
    $book_id = $_GET['book_id'];

    // Corrected SQL query string
    $sql = "DELETE FROM booking WHERE venue_id = ? AND book_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $venue_id, $book_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect or send a success message as per your requirement
        echo "Booking deleted successfully!";
        header("location: activity.php");
        exit; // Ensuring script stops execution after redirection
    } else {
        echo "Error deleting booking: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>
