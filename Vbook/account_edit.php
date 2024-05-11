<?php
session_start();
include("config.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html>
<title>Account Edit</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
<!-- Sidebar -->
<div class="sidebar" style="width:20%">
  <div class="imglogo">
    <img src="img/logo_white.png" alt="logo" class="logo">
  </div>
  <?php
      include 'menu.php';
   ?>
</div>


  <?php
  $userID = "";
  $userName = "";
  $userEmail = "";
  $contact = "";

  // Check if ID and userEmail are present in the URL
  if(isset($_GET['id']) && isset($_GET['userEmail'])) {
      $userID = $_GET['id'];
      $userEmail = $_GET['userEmail'];

      // Prepare and execute the SQL query
      $sql = "SELECT * FROM user WHERE userEmail = ?";
      $stmt = mysqli_prepare($conn, $sql);

      // Check if statement was prepared successfully
      if($stmt) {
          mysqli_stmt_bind_param($stmt, "s", $userEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          // Check if any rows were returned
          if(mysqli_num_rows($result) > 0){
              $row = mysqli_fetch_assoc($result);
              $userID = $row["userID"];
              $userEmail = $row["userEmail"];
              $userName = $row["userName"];
              $userRoles = $row["userRoles"]; // Assuming this column exists in your table
              $contact = $row["contact"];
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

<!-- Page Content -->
<div style="margin-left:20%">

  <div class="topsearch">
  <h1 class="dashboard-title">User Account</h1>
  </div>
  <div class="container">
  <div class="admin_account_edit">
    <h3>Edit User</h3>
    <form method="POST" action="account_edit_action.php" style="padding-bottom: 70px;" id="myForm" enctype="multipart/form-data">
      <input type="hidden" name="userEmail" value="<?= $userEmail ?>">
      <table border="0" id="myTable">
        <tr>
          <td>Username</td>
          <td>:</td>
          <td>
            <input type="text" name="userName" csize="5">
          </td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td>
            <?php echo $userEmail; ?>
          </td>
        </tr>
        <tr>
         <td>Contact</td>
         <td>:</td>
         <td>
           <input type="text" name="contact" size="5">
         </td>
       </tr>
       <tr>
         <td>User Roles</td>
         <td>:</td>
         <td>
           <?php echo $userRoles; ?>
         </td>
       </tr>
       <tr>
         <td colspan="3" align="right">
           <input type="submit" value="Submit" name="B1">
           <input type="button" value="Reset" name="B2" onclick="resetForm()">
           <input type="button" value="Clear" name="B3" onclick="clearForm()">
         </td>
       </tr>
     </form>
   </div>
  </div>
</div>
