<?php
session_start();
include('config.php');

// Check if logged-in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
  exit; // Ensuring script stops execution after redirection
}

$id = "";
$userID = "";
$userName = "";
$userEmail = "";
$contact = "";

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = isset($_GET['userID']);
    $userName = trim($_POST["userName"]);
    $userEmail = trim($_POST["userEmail"]);
    $contact = trim($_POST["contact"]);

    $sql = "UPDATE user SET ";

    $params = [];
    $types = "";

    if (!empty($userName)) {
        $sql .= "userName = ?, ";
        $params[] = $userName;
        $types .= "s";
    }

    if (!empty($contact)) {
        $sql .= "contact = ?, ";
        $params[] = $contact;
        $types .= "s";
    }

    // Remove trailing comma and space
    $sql = rtrim($sql, ", ");

    $sql .= " WHERE userEmail = ?";
    $params[] = $userEmail;
    $types .= "s";

    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement was prepared successfully
    if($stmt) {
        // Dynamically bind parameters based on what's set
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "Form data updated successfully!<br>";
            header("location:accVerify.php");
            exit;
        } else {
            echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
            echo '<a href="accVerify.php">Back</a>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
        echo '<a href="accVerify.php">Back</a>';
    }
} else {
    echo "Invalid request method.<br>";
    echo '<a href="accVerify.php">Back</a>';
}

mysqli_close($conn);
?>
