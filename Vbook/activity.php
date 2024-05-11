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
<title>Activty</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        <h1 class="dashboard-title">Activity</h1>
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
  // Fetch the userID from the session
$userID = $_SESSION["UID"];

$currentDate = date('Y-m-d');  // Get the current date

$sql = "SELECT booking.*, venue.venue_name, venue.venue_media
        FROM booking
        JOIN venue ON booking.venue_id = venue.venue_id
        JOIN user ON booking.userID = user.userID
        WHERE user.userID = ? AND booking.event_date >= ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind the parameters
mysqli_stmt_bind_param($stmt, "is", $userID, $currentDate);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Close the statement
mysqli_stmt_close($stmt);
?>

<div class="container">
  <section class="booking-active">
  <h2 class="booking_text">Active Reservation</h2>
  <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="booking-entry">
              <img src="uploads/<?php echo $row['venue_media']; ?>" alt="<?php echo $row['venue_name']; ?>" class="venue-image">
              <div class="booking-details">
                  <div class="booking-text-details">
                      <div class="venue-name"><?php echo $row['venue_name']; ?></div>
                      <div style="font-size: 16px;" class="venue-name"><?php echo $row['event_name']; ?></div>
                      <div class="booking-time"><?php echo $row['event_date']; ?></div>
                  </div>
                  <div>
                      <button id="cancelReserve" class="cancel"
                          data-venue-id="<?php echo $row['venue_id']; ?>"
                          data-book-id="<?php echo $row['book_id']; ?>">
                          <i class="fas fa-times"></i> Cancel
                      </button>
                  </div>
              </div>
          </div>
      <?php endwhile; ?>
  <?php else: ?>
    <div class="booking-entry">
      <div class="booking-details">
        <div class="booking-text-details">
      <p style="font-size: 24px;">No active Reservation found.</p>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php
// Fetch data from the database based on userID and join with venue table
$sql2 = "SELECT booking.*, venue.venue_name, venue.venue_media
         FROM booking
         JOIN venue ON booking.venue_id = venue.venue_id
         WHERE booking.userID = ?";
$stmt = mysqli_prepare($conn, $sql2);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $userID);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result2 = mysqli_stmt_get_result($stmt);

// Initialize an empty array to store past bookings
$pastBookings = [];

// Loop through the result set
while ($row = mysqli_fetch_assoc($result2)) {
    $bookingDate = strtotime($row['event_date']);
    $currentDate = strtotime(date('Y-m-d')); // Current date

    // Check if the booking date is in the past
    if ($bookingDate < $currentDate) {
        $pastBookings[] = $row;
    }
}

// Sort the past bookings by event_date in descending order
usort($pastBookings, function($a, $b) {
    return strtotime($b['event_date']) - strtotime($a['event_date']);
});

// Close the statement
mysqli_stmt_close($stmt);
?>


<section class="booking-history">
    <h2 class="booking_text">Reservation History</h2>
    <?php if (!empty($pastBookings)): ?>
        <?php foreach ($pastBookings as $booking): ?>
            <div class="booking-entry">
                <img src="uploads/<?php echo $booking['venue_media']; ?>" alt="<?php echo $booking['venue_name']; ?>" class="venue-image">
                <div class="booking-details">
                  <div class="booking-text-details">
                    <div class="venue-name"><?php echo $booking['venue_name']; ?></div>
                    <div style="font-size: 16px;" class="venue-name"><?php echo $booking['event_name']; ?></div>
                    <div class="booking-time"><?php echo $booking['event_date']; ?></div>
                  </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
      <div class="booking-entry">
        <div class="booking-details">
          <div class="booking-text-details">
        <p style="font-size: 24px;">No Reservation history found.</p>
          </div>
        </div>
      </div>
    <?php endif; ?>
</section>
  </div>
</div>

<script>
var buttons = document.querySelectorAll(".cancel");

buttons.forEach(function(button) {
    button.addEventListener("click", function() {
        var venueId = this.getAttribute("data-venue-id");
        var bookId = this.getAttribute("data-book-id");
        var confirmDelete = confirm("Are you sure you want to delete this booking?");

        if(confirmDelete) {
            window.location.href = "activity_delete_venue.php?venue_id=" + venueId + "&book_id=" + bookId;
        }
    });
});

</script>

</body>
</html>
