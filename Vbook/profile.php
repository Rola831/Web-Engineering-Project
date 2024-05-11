<?php
session_start();
include("config.php");
include("avatar_component.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<title>Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body style="background: #d9d9d9">

<!-- Sidebar -->
<div class="sidebar" style="width:20%">
  <div class="imglogo">
    <img src="img/logo_white.png" alt="logo" class="logo">
  </div>
  <?php
      include 'menu.php';
   ?>
</div>


<!-- Page Content -->
<div style="margin-left:20%">

  <div class="topsearch">
    <div class="search-container">
        <h1 class="dashboard-title">Profile</h1>
    </div>

    <div style="margin-bottom: 10px" class="header_avatar profile-icon-container">
        <a href="profile.php">
            <div class="profile-icon">
                <?php echo displayAvatar($conn); ?>
            </div>
        </a>
    </div>
  </div>

  <?php
  $userID = "";
  $userName = "";
  $userEmail = "";
  $contact = "";

  if (isset($_SESSION["UID"])) {
    $userID = $_SESSION["UID"];

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement was prepared successfully
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userID = $row["userID"];
            $userEmail = $row["userEmail"];
            $userName = $row["userName"];
            $userRoles = $row["userRoles"];
            $contact = $row["contact"];
            $userImage = $row["user_avatar"]; // Fetch userImage path
        } else {
            echo "No user found with the provided email.";
            exit; // Stop further execution
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing SQL statement.";
        exit;
    }
} else {
    echo "Missing required parameters in the URL.";
    exit;
}
?>


<div class="vbkcontainer">
  <div class="container_profile">
    <div class="content_profile">
      <div class="content">
        <?php

        // Display avatar if available
        if (!empty($userImage) && file_exists($userImage)) {
            echo '<div class="avatar">';
            echo '<img src="' . $userImage . '" alt="Profile Avatar" style="width: 100%; height: 100%; border-radius: 50%;">';
            echo '</div>';
        }

        echo '<div class="card">';
        echo '<div class="card-detail">Username: ' . $row['userName'] . '</div>';
        echo '<div class="card-detail">Email: ' . $row['userEmail'] . '</div>';
        echo '<div class="card-detail">Contact: ' . $row['contact'] . '</div>';
        echo '</div>';
        ?>
    </div>
  </div>
</div>
</div>
</div>

</body>
</html>
