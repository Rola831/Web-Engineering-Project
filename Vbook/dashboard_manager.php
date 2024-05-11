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
<title>Dashboard</title>
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
      <form action="#" onsubmit="return false;">
        <h1 class="dashboard-title">Dashboard</h1>
        <input type="text" placeholder="Search.." id="myInput">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>

    <div style="margin-bottom: 10px" class="header_avatar profile-icon-container">
        <a href="profile.php">
            <div class="profile-icon">
                <?php echo displayAvatar($conn); ?>
            </div>
        </a>
    </div>
  </div>

  <div class="container">
    <div class="gallery-container">
    <?php
    $sql = "SELECT * FROM venue WHERE userID=" . $_SESSION["UID"];
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<a style='background: white; border-radius: 15px;' href='update_venue.php?venue_id=" . $row["venue_id"] . '&userID=' . $row["userID"] . "' class='venue-card-link'>";
            echo "<div class='venue-card'>";
            echo "<img src='uploads/" . $row["venue_media"] . "' alt='Venue Media' class='venue-image' style='width:550px; height:350px; object-fit: cover;'>";
            echo "<div class='venue-details'>";
            echo "<h3>" . $row["venue_name"] . "</h3>";
            echo "<p>Type: " . $row["venue_type"] . "</p>";
            echo "<p>Price: " . $row["venue_price"] . "</p>";
            echo "<p>Location: " . $row["venue_location"] . "</p>";
            echo "<p>Size: " . $row["venue_size"] . "</p>";
            echo "<p>Description: " . $row["venue_description"] . "</p>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
        }
    } else {
        echo '<p>No venues found.</p>';
    }

    mysqli_close($conn);
    ?>
</div>
  </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#myInput').keyup(function() {
        var searchText = $(this).val().toLowerCase();
        $('.venue-card-link').each(function() {
            var venueName = $(this).find('.venue-card h3').text().toLowerCase();
            if (venueName.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>


</body>
</html>
