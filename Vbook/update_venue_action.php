<?php
session_start();
include("config.php");

// Redirect to index if not logged in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
  exit; // Ensure the script stops execution after redirection
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION["UID"];
    $venue_id = $_POST['venue_id'];

    // Construct the update SQL and parameters based on the form data
    $updateSql = "UPDATE venue SET ";
    $params = [];
    $types = "";

    if (isset($_POST['venue_name']) && !empty($_POST['venue_name'])) {
        $updateSql .= "venue_name=?, ";
        $params[] = $_POST['venue_name'];
        $types .= "s";
    }

    if (isset($_POST['venue_type']) && !empty($_POST['venue_type'])) {
        $updateSql .= "venue_type=?, ";
        $params[] = $_POST['venue_type'];
        $types .= "s";
    }

    if (isset($_POST['venue_price']) && !empty($_POST['venue_price'])) {
        $updateSql .= "venue_price=?, ";
        $params[] = $_POST['venue_price'];
        $types .= "s";
    }

    if (isset($_POST['venue_location']) && !empty($_POST['venue_location'])) {
        $updateSql .= "venue_location=?, ";
        $params[] = $_POST['venue_location'];
        $types .= "s";
    }

    if (isset($_POST['venue_size']) && !empty($_POST['venue_size'])) {
        $updateSql .= "venue_size=?, ";
        $params[] = $_POST['venue_size'];
        $types .= "s";
    }

    if (isset($_POST['venue_description']) && !empty($_POST['venue_description'])) {
        $updateSql .= "venue_description=?, ";
        $params[] = $_POST['venue_description'];
        $types .= "s";
    }

    // Remove trailing comma and space
    $updateSql = rtrim($updateSql, ", ");
    $updateSql .= " WHERE venue_id=? AND userID=?";
    $params[] = $venue_id;
    $params[] = $userID;
    $types .= "ii";

    // Prepare and execute the dynamic update statement
    $updateStmt = mysqli_prepare($conn, $updateSql);
    if($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, $types, ...$params);
        if(mysqli_stmt_execute($updateStmt)) {
            echo "Venue updated successfully.";
            header("location:dashboard_manager.php");
            exit;
        } else {
            echo "Error updating venue: " . mysqli_error($conn);
        }
        mysqli_stmt_close($updateStmt);
    } else {
        echo "Error preparing SQL statement for update.";
    }
}

mysqli_close($conn);
?>
