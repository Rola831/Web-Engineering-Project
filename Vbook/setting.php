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
<title>Setting</title>
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

    <div class="topsearch" style="background: white">
      <div class="search-container">
          <h1 class="dashboard-title">Setting</h1>
      </div>

      <!-- Profile Icon -->
      <div style="margin-bottom: 10px" class="header_avatar profile-icon-container">
          <a href="profile.php">
              <div class="profile-icon">
                  <?php echo displayAvatar($conn); ?>
              </div>
          </a>
      </div>

    </div>

  <div class="vbkcontainer">

    <div class="settingContainer" style="padding: 0 50px;">

      <div class="settingItem">
      </div>

      <!-- Edit Profile -->
      <div class="settingItem">
          <strong>Edit your profile</strong>
          <a href="user_edit.php" class="editButton">Edit</a>
      </div>

      <!-- Location Setting -->
      <div class="settingItem">
          <strong>Location Setting</strong>
          <p>Allow to use location on your device</p>
          <label class="switch">
              <input type="checkbox" checked>
              <span class="slider round"></span>
          </label>
      </div>

      <!-- Push Notification -->
      <div class="settingItem">
          <strong>Push Notification</strong>
          <p>Allow to send push notification to your device</p>
          <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
          </label>
      </div>

      <!-- Support -->
      <h2>Support</h2>

      <div class="settingItem">
          <p>About Us</p>
          <button>&gt;</button>
      </div>

      <div class="settingItem">
          <p>FAQ / Help</p>
          <button>&gt;</button>
      </div>

      <div class="settingItem">
          <p>Contact Us</p>
          <button>&gt;</button>
      </div>

      <!-- Delete Account -->
      <div class="deleteUAcc" style="padding: 0;">
          <a href="user_delete_action.php">
              <input class="deleteUButton" type="submit" value="Delete Account" style="background: #ff7f11">
          </a>
      </div>

  </div>

  </div>

</body>
</html>

</body>
</html>
