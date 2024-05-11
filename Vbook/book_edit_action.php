<?php
session_start();
include('config.php');

// Check if logged-in
if (!isset($_SESSION["UID"])) {
    header("location:index.php");
    exit; // Ensuring script stops execution after redirection
}

// Fetch data from POST or GET based on your form submission method
$book_id = isset($_POST['book_id']) ? $_POST['book_id'] : (isset($_GET['book_id']) ? $_GET['book_id'] : '');
$venue_id = isset($_POST['venue_id']) ? $_POST['venue_id'] : (isset($_GET['venue_id']) ? $_GET['venue_id'] : '');
$event_name = isset($_POST['event_name']) ? trim($_POST['event_name']) : '';
$event_type = isset($_POST['event_type']) ? trim($_POST['event_type']) : '';
$event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';
$event_alt_date = isset($_POST['event_alt_date']) ? trim($_POST['event_alt_date']) : '';


    // Construct the SQL UPDATE statement
    $sql = "UPDATE booking SET ";

    $params = [];
    $types = "";

    if (!empty($event_name)) {
        $sql .= "event_name = ?, ";
        $params[] = $event_name;
        $types .= "s";
    }

    if (!empty($event_type)) {
        $sql .= "event_type = ?, ";
        $params[] = $event_type;
        $types .= "s";
    }

    if (!empty($event_date)) {
        $sql .= "event_date = ?, ";
        $params[] = $event_date;
        $types .= "s";
    }

    if (!empty($event_alt_date)) {
        $sql .= "event_alt_date = ?, ";
        $params[] = $event_alt_date;
        $types .= "s";
    }

    // Remove trailing comma and space
    $sql = rtrim($sql, ", ");

    $sql .= " WHERE book_id = ? AND venue_id = ?";
    $params[] = $book_id;
    $params[] = $venue_id;
    $types .= "ii";

    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement was prepared successfully
    if ($stmt) {
        // Dynamically bind parameters based on what's set
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "Form data updated successfully!<br>";
            header("location:bookRecord.php");
            exit;
        } else {
            echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
            echo '<a href="bookRecord.php">Back</a>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
        echo '<a href="bookRecord.php">Back</a>';
    }

mysqli_close($conn);
?>
