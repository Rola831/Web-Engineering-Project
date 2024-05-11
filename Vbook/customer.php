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
<title>Customer</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <form action="#" onsubmit="return false;">
      <h1 class="dashboard-title">Customer</h1>
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
      <div class="table-container">
        <!-- Booking Table -->
        <table border="1" width="100%" id="activity_table">
          <tr>
            <th>BID</th>
            <th>VID</th>
            <th>UID</th>
            <th>User Name</th>
            <th>Event Name</th>
            <th>Event Type</th>
            <th>No. of Guests</th>
            <th>Event Date</th>
            <th>Alternate Event Date</th>
            <th>Event Description</th>
            <th>Action</th>
          </tr>
         <?php
          $sql = "SELECT
                      b.book_id,
                      b.event_name,
                      b.event_type,
                      b.event_no_guest,
                      b.event_date,
                      b.event_alt_date,
                      b.event_description,
                      u.userID,
                      u.userName,
                      v.venue_id
                  FROM
                      booking b
                  INNER JOIN
                      user u ON b.userID = u.userID
                  INNER JOIN
                      venue v ON b.venue_id = v.venue_id
                  WHERE
                      v.userID = ?";

          $stmt = mysqli_prepare($conn, $sql);

          if ($stmt) {
              $uid = $_SESSION["UID"]; // Assuming $_SESSION["UID"] is an integer
              mysqli_stmt_bind_param($stmt, "i", $uid); // "i" because both are integers
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);

              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td style='text-align: center;'>" . $row["book_id"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["venue_id"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["userID"] . "</td>";
                  echo "<td>" . $row["userName"] . "</td>";
                  echo "<td>" . $row["event_name"] . "</td>";
                  echo "<td>" . $row["event_type"] . "</td>";
                  echo "<td style='text-align: center;'>" . $row["event_no_guest"] . "</td>";
                  echo "<td>" . $row["event_date"] . "</td>";
                  echo "<td>" . $row["event_alt_date"] . "</td>";
                  echo "<td>" . $row["event_description"] . "</td>";
                  echo '<td style="text-align: center;"> <a href="customer_delete.php?userID=' . $row["userID"] . '&book_id=' . $row["book_id"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';

                  echo "</tr>";
              }
              echo "</table>";

              mysqli_stmt_close($stmt);
          } else {
                echo '<p>No venues found.</p>' . mysqli_error($conn);
          }

          mysqli_close($conn);
          ?>

      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  $(document).ready(function(){
      $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#activity_table tr").each(function() {
              if ($(this).text().toLowerCase().includes(value)) {
                  $(this).show();
              } else {
                  // Hide the row only if it's not the table header
                  if (!$(this).find('th').length) {
                      $(this).hide();
                  }
              }
          });
      });
  });
  </script>

</body>
</html>
