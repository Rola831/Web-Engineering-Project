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
<title>Edit Reservation</title>
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
    // Fetch book_id and venue_id from URL
      $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : '';
      $venue_id = isset($_GET['venue_id']) ? $_GET['venue_id'] : '';

      // Display book_id and venue_id for debugging
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

  $event_name = isset($event_name) ? $event_name : '';
  $event_type = isset($event_type) ? $event_type : '';
  $event_date = isset($event_date) ? $event_date : '';
  $event_alt_date = isset($event_alt_date) ? $event_alt_date : '';
  ?>



<!-- Page Content -->
<div style="margin-left:20%">

  <div class="topsearch">
  <h1 class="dashboard-title">Booked Venue</h1>
  </div>
  <div class="container">
  <div class="admin_account_edit">
    <h3>Edit Booked Venue</h3>
    <form method="POST" action="book_edit_action.php" style="padding-bottom: 70px;" id="myForm" enctype="multipart/form-data">
      <input type="hidden" name="userID" value="<?= $userID ?>">
      <input type="hidden" name="venue_id" value="<?= $venue_id ?>">
      <input type="hidden" name="book_id" value="<?= $book_id ?>">
      <table border="0" id="myTable">
        <tr>
          <td>Username</td>
          <td>:</td>
          <td>
            <?php echo $userID; ?>
            -
            <?php echo $userName; ?>
          </td>
        </tr>
        <tr>
          <td>Event Name</td>
          <td>:</td>
          <td>
            <input type="text" name="event_name" value="<?= htmlspecialchars($event_name) ?>">
          </td>
        </tr>
        <tr>
          <td>Event Type</td>
          <td>:</td>
          <td>
            <select size="1" id="event_type" name="event_type"value="<?= htmlspecialchars($event_type) ?>" required>
              <option value="">&nbsp;</option>;
			        <option value="Meeting">Meeting</option>;
              <option value="Conference">Conference</option>;
              <option value="Seminar">Seminar</option>;
              <option value="Festival">Festival</option>;
              <option value="Wedding">Wedding</option>;
              <option value="Workshop">Workshop</option>;
            </select>
          </td>
        </tr>
        <tr>
         <td>Event Date</td>
         <td>:</td>
         <td>
           <input type="date" name="event_date" value="<?= htmlspecialchars($event_date) ?>">
         </td>
       </tr>
       <tr>
        <td>Event Alt Date</td>
        <td>:</td>
        <td>
          <input type="date" name="event_alt_date" value="<?= htmlspecialchars($event_alt_date) ?>">
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
