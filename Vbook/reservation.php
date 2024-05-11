<?php
session_start();
include("config.php");
include("avatar_component.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
}

// Ensure the venue_id parameter is set and is numeric
if(isset($_GET['venue_id']) && is_numeric($_GET['venue_id'])) {
    $venue_id = $_GET['venue_id'];
} else {
    // Handle the case where venue_id is not provided or not valid
    header("location:activity.php");
    echo "Invalid venue ID!";
    exit; // Exit the script or redirect as necessary
}

$query = "SELECT * FROM venue WHERE venue_id = $venue_id";
$stmt = $conn->prepare("SELECT * FROM venue WHERE venue_id = ?");
$stmt->bind_param("i", $venue_id); // Assuming venue_id is an integer
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$userID = $row['userID'];
$venue_name = $row['venue_name'];
$venue_type = $row['venue_type'];
$venue_price = $row['venue_price'];
$venue_location = $row['venue_location'];
$venue_size = $row['venue_size'];
$venue_description = $row['venue_description'];
$venue_media = $row['venue_media'];

?>

<!DOCTYPE html>
<html>
<title>Reservation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="css/style.css">
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

<style>
.rating-section .star.active {
    color: gold;  /* Change color to indicate active star */
}
</style>

<!-- Page Content -->
<div style="margin-left:20%">

<div class="topsearch">
  <div class="search-container">
      <h1 class="dashboard-title"><?= $venue_name ?></h1>
  </div>

  <div style="margin-bottom: 10px" class="header_avatar profile-icon-container">
      <a href="profile.php">
          <div class="profile-icon">
              <?php echo displayAvatar($conn); ?>
          </div>
      </a>
  </div>
</div>

<div class="vbkcontainer">

<!-- Venue Image from uploads directory -->
    <img id="reservation_Img" src="uploads/<?= $venue_media ?>" alt="<?= $venue_name ?>">

      <h2 id="venueText">Description of the Venue</h2>
      <table id="venueDesc">
        <tr>
          <td>Type<td>
          <td><?= $venue_type ?><td>
        </tr>
        <tr>
          <td>Price<td>
          <td><?= $venue_price ?><td>
        </tr>
        <tr>
          <td>Location<td>
          <td><?= $venue_location ?><td>
        </tr>
        <tr>
          <td>Size<td>
          <td><?= $venue_size ?><td>
        </tr>
        <tr>
          <td>Description<td>
          <td><?= $venue_description ?><td>
        </tr>
      </table>

      <!-- Venue Description -->
      <div class="venue-description-container">

        <!-- Booking Form -->
        <form action="reservation_action.php" method="post" id="reservation_form">
            <input type="hidden" name="venue_id" id="venue_id" value="<?= $venue_id ?>">

            <label for="event_name">Name of Event:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="event_type">Type of Event:</label>
            <select size="1" id="event_type" name="event_type" required>
              <option value="">&nbsp;</option>;
			        <option value="Meeting">Meeting</option>;
              <option value="Conference">Conference</option>;
              <option value="Seminar">Seminar</option>;
              <option value="Festival">Festival</option>;
              <option value="Wedding">Wedding</option>;
              <option value="Workshop">Workshop</option>;
            </select>

            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>

            <label for="event_alt_date">Alternative Date:</label>
            <input type="date" id="event_alt_date" name="event_alt_date">

            <label for="event_no_guest">Number of Guests:</label>
            <input type="number" id="event_no_guest" name="event_no_guest" required>

            <label>Require Hotel Rooms:</label>
            <label><input type="radio" name="hotelRooms" value="yes"> Yes</label>
            <label><input type="radio" name="hotelRooms" value="no"> No</label>

            <div id="roomDetails" style="display:none;">
                <label for="hotel_room">Number of Rooms:</label>
                <input type="number" id="hotel_room" name="hotel_room">
            </div>

            <label for="event_description">Additional Information:</label>
            <textarea id="event_description" name="event_description" rows="4"></textarea>

            <input type="submit" value="Reserve" class="reservation-button">
        </form>
          <!-- Add more content as needed -->
      </div>
      <!-- Comment Input and Display Section -->
      <div class="comment-input-section">
        <form id="commentForm" action="comments_action.php" method="post">
              <input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>">
              <input type="hidden" name="userID" value="<?php echo $userID; ?>">
              <input type="hidden" id="ratingInput" name="rating" value="">

              <h3>Leave a Comment</h3>

              <!-- Rating Stars -->
              <div class="rating-section">
                  <span class="star" data-value="1">&#9733;</span>
                  <span class="star" data-value="2">&#9733;</span>
                  <span class="star" data-value="3">&#9733;</span>
                  <span class="star" data-value="4">&#9733;</span>
                  <span class="star" data-value="5">&#9733;</span>
              </div>

              <textarea name="userComment" id="userComment" style="width: 98.5%;" placeholder="Enter your comment here..." rows="4"></textarea>
              <button id="submitComment" type="submit">Submit Comment</button>
          </form>

          <div class="user-comment-display">
    <h3>Comments from Previous Reservations</h3>

    <?php
    $sql = "SELECT comments.*, user.userName, user.user_avatar
            FROM comments
            JOIN user ON comments.userID = user.userID
            WHERE comments.venue_id = ?
            ORDER BY comments.comment_date DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $venue_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $rating = $row['star_rating'];
            $comment = $row['comment_text'];
            $username = $row['userName'];
            $user_avatar = $row['user_avatar'];
            ?>

            <style>

            .comment_avatar {
                  object-fit: cover; /* This property prevents the image from stretching */
                  width: 50px;  /* Adjust the width as needed */
                  height: 50px; /* Adjust the height as needed */
                  border-radius: 50%; /* Optional: Make it a circular avatar */
              }

              .comment-info {
                  display: flex;
                  align-items: center; /* Align items vertically in the center */
              }

              .comment-info strong {
                  margin-left: 15px; /* Adjust the margin as needed */
              }

            </style>

            <!-- Comment Template -->
            <div class="comment">
                <div class="user-info">
                  <div class="comment-info">
                    <img class="comment_avatar" src="<?php echo htmlspecialchars($user_avatar); ?>" alt="User Avatar" class="avatar">
                      <strong><?php echo htmlspecialchars($username); ?></strong>
                    </div>
                    <div class="rating">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<span class="star selected">&#9733;</span>';
                            } else {
                                echo '<span class="star">&#9733;</span>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <p><?php echo htmlspecialchars($comment); ?></p>
            </div>

    <?php
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
    mysqli_close($conn);
    ?>
</div>



    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const hotelRooms = document.getElementsByName('hotelRooms');
  const roomDetails = document.getElementById('roomDetails');

  for (let i = 0; i < hotelRooms.length; i++) {
      hotelRooms[i].addEventListener('change', function() {
          if (this.value === 'yes') {
              roomDetails.style.display = 'block';
          } else {
              roomDetails.style.display = 'none';
          }
      });
  }
});

$(document).ready(function() {
    $('.star').click(function() {
        // Remove any active classes from all stars
        $('.star').removeClass('active');

        // Add active class to clicked star and all previous stars
        $(this).addClass('active').prevAll().addClass('active');

        // Set the value of the hidden ratingInput field to the clicked star's data-value
        $('#ratingInput').val($(this).data('value'));
    });

    $('#commentForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        let formData = {
            venue_id: $('input[name="venue_id"]').val(),
            userID: $('input[name="userID"]').val(),
            comment: $('#userComment').val(),
            rating: $('#ratingInput').val()
        };

        $.post('comments_action.php', formData, function(response) {
            console.log(response);
            // Reload the page after successful submission
            location.reload();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
        });
    });
});
</script>

</body>
</html>
