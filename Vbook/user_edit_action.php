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

    // File upload handling
    if (isset($_FILES["filetoUpload"]) && $_FILES["filetoUpload"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["filetoUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["filetoUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size (e.g., 5MB)
        if ($_FILES["filetoUpload"]["size"] > 5000000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed.<br>";
            $uploadOk = 0;
        }

        // Attempt to move the uploaded file
        if ($uploadOk == 1 && move_uploaded_file($_FILES["filetoUpload"]["tmp_name"], $target_file)) {
            // File uploaded successfully
        } elseif ($uploadOk == 0) {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }

    // Construct SQL query for updating user details
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

    if (isset($target_file) && !empty($target_file)) {
        $sql .= "user_avatar = ?, ";
        $params[] = $target_file;
        $types .= "s";
    }

    // Remove trailing comma and space
    $sql = rtrim($sql, ", ");

    $sql .= " WHERE userEmail = ?";
    $params[] = $userEmail;
    $types .= "s";

    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement was prepared successfully
    if ($stmt) {
        // Dynamically bind parameters based on what's set
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "Form data updated successfully!<br>";
            header("location:profile.php");
            exit;
        } else {
            echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
            echo '<a href="setting.php">Back</a>';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
        echo '<a href="setting.php">Back</a>';
    }

    mysqli_close($conn);
}
?>
