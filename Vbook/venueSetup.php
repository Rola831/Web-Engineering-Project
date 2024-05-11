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
<title>Venue Setup</title>
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
  <div class="search-container">
      <h1 class="dashboard-title">Venue Setup</h1>
  </div>

  <div class="header_avatar profile-icon-container">
      <a href="profile.php">
          <div class="profile-icon">
              <?php echo displayAvatar($conn); ?>
          </div>
      </a>
  </div>
</div>
  <div class="container">
      <div class="venue-setup-container">
        <!-- Booking Form -->
        <form action="venueSetup_action.php" method="post" enctype="multipart/form-data">
            <label for="venue_name">Name of Venue:</label>
            <input type="text" id="venue_name" name="venue_name" required>

            <label for="venue_type">Type of Venue:</label>
            <select size="1" id="venue_type" name="venue_type" required>
              <option value="">&nbsp;</option>;
              <option value="Hotels">Hotels</option>;
              <option value="Resorts">Resorts</option>;
              <option value="Restaurants">Restaurants</option>;
              <option value="Convention Centers">Convention Centers</option>;
              <option value="Conference Centers">Conference Centers</option>;
              <option value="Community Centers">Community centers</option>;
              <option value="Theaters">Theaters</option>;
              <option value="Clubs">Clubs</option>;
            </select>

            <label for="venue_price">Venue Price:</label>
            <input type="number" id="venue_price" name="venue_price" required>

            <label for="venue_location">Venue Location:</label>
            <input type="text" id="venue_location" name="venue_location" required>

            <label for="venue_size">Venue Size (People):</label>
            <input type="number" id="venue_size" name="venue_size" required>

            <label for="venue_description">Additional Information:</label>
            <textarea id="venue_description" name="venue_description" rows="4"></textarea>

            <label for="filetoUpload">Venue Media:</label>
            <input type="file" name="filetoUpload" id="filetoUpload" accept=".jpg, .jpeg, png">

            <input type="submit" value="Setup" class="Setup-button">
        </form>
    </div>
  </div>

<script>
</script>

</body>
</html>
