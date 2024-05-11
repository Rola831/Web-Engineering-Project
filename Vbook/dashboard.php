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
            <input type="text" placeholder="Search.." id="myInput" onkeyup="mySearch()">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
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

<?php include 'venue_fetch.php'; ?>

    <div class="item">
    <?php foreach ($venues as $venue): ?>
       <div class="venueCol" data-type="<?php echo $venue['venue_type']; ?>">
         <a href="reservation.php?venue_id=<?php echo $venue['venue_id']; ?>" data-name="<?php echo $venue['venue_name']; ?>">
           <img src="<?php echo $venue['venue_media']; ?>" alt="<?php echo $venue['venue_name']; ?>">
           <p><?php echo $venue['venue_name']; ?></p>
           <p>Type: <?php echo $venue['venue_type']; ?></p> <!-- Display venue type -->
         </a>
       </div>
    <?php endforeach; ?>
    </div>

  </div>
</div>



<script>
function mySearch() {
    var input, filter, venues, venue, venueType, i, txtValue, typeValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    venues = document.getElementsByClassName("venueCol");

    for (i = 0; i < venues.length; i++) {
        venue = venues[i].getElementsByTagName("a")[0];
        txtValue = venue.getAttribute("data-name");
        venueType = venues[i].getAttribute("data-type"); // Get venue type

        typeValue = venueType.toUpperCase();

        if (txtValue.toUpperCase().indexOf(filter) > -1 || typeValue.indexOf(filter) > -1) {
            venues[i].style.display = "";
        } else {
            venues[i].style.display = "none";
        }
    }
}


</script>

</body>
</html>
