<?php
session_start();
include("config.php");

if(!isset($_SESSION["UID"])){
  header("location:index.php");
}

$venue_id = "";
$venue_name = "";
$venue_type = "";
$venue_price = "";
$venue_location = "";
$venue_size = "";
$venue_description = "";

if(isset($_GET['venue_id'])) {
    $venue_id = $_GET['venue_id'];

    $sql = "SELECT * FROM venue WHERE venue_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $venue_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $venue_name = $row["venue_name"];
            $venue_type = $row["venue_type"];
            $venue_price = $row["venue_price"];
            $venue_location = $row["venue_location"];
            $venue_size = $row["venue_size"];
            $venue_description = $row["venue_description"];
        } else {
            echo "No venue found with the provided ID.";
            exit;
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

<!DOCTYPE html>
<html>
<title>Update Venue</title>
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

<!-- Page Content -->
<div style="margin-left:20%">

  <div class="topsearch">
  <h1 class="dashboard-title">Update Venue</h1>
  </div>
  <div class="container">
  <div class="admin_account_edit">
    <h3>Edit Venue</h3>
    <form method="POST" action="update_venue_action.php" style="padding-bottom: 70px;" id="myForm" enctype="multipart/form-data">
      <input type="hidden" name="userID" value="<?= $userID ?>">
      <input type="hidden" name="venue_id" value="<?= $venue_id ?>">
      <table border="0" id="myTable">
        <tr>
          <td>Venue Name</td>
          <td>:</td>
          <td>
            <input type="text" id="venue_name" name="venue_name" csize="5">
          </td>
        </tr>
        <tr>
          <td>Venue Type</td>
          <td>:</td>
          <td>
            <select class="custom-select" size="1" id="venue_type" name="venue_type" required>
              <option value="" disabled selected hidden>Select Venue Type</option>
              <option value="Hotels">Hotels</option>;
              <option value="Resorts">Resorts</option>;
              <option value="Restaurants">Restaurants</option>;
              <option value="Convention Centers">Convention Centers</option>;
              <option value="Conference Centers">Conference Centers</option>;
              <option value="Community Centers">Community centers</option>;
              <option value="Theaters">Theaters</option>;
              <option value="Clubs">Clubs</option>;
            </select>
          </td>
        </tr>
        <tr>
         <td>Venue Price</td>
         <td>:</td>
         <td>
           <input type="text" id="venue_price" name="venue_price" size="5">
         </td>
       </tr>
       <tr>
        <td>Venue Location</td>
        <td>:</td>
        <td>
          <input type="text" id="venue_location" name="venue_location" size="5">
        </td>
      </tr>
      <tr>
       <td>Venue Size</td>
       <td>:</td>
       <td>
         <input type="text" id="venue_size" name="venue_size" size="5">
       </td>
     </tr>
     <tr>
      <td>Venue Description</td>
      <td>:</td>
      <td>
        <textarea id="venue_description" name="venue_description" rows="4"></textarea>
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

<script>
</script>

</body>
</html>
