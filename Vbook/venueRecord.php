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
<title>Venue Record</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
      <h1 class="dashboard-title">Venue Record</h1>
      <input type="text" placeholder="Search.." id="myInput">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>
  <div class="container">
      <div class="table-container">
        <!-- Booking Table -->
        <table border="1" width="100%" id="venue_table">
          <tr>
              <th>VenueID</th>
              <th>UserID</th>
              <th>User Email</th>
              <th>Venue Name</th>
              <th>Venue Type</th>
              <th>Venue Price</th>
              <th>Venue Size</th>
              <th>Venue Location</th>
              <th>Venue Description</th>
              <th>Action</th>
          </tr>
            <?php
            $sql = "SELECT
                        v.venue_id,
                        v.userID,
                        u.userEmail,
                        v.venue_name,
                        v.venue_type,
                        v.venue_price,
                        v.venue_size,
                        v.venue_location,
                        v.venue_description
                    FROM
                        venue v
                    JOIN
                        user u ON v.userID = u.userID
                    ORDER BY
                        v.venue_id";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $row["venue_id"] . "</td>";
                    echo "<td style='text-align: center;'>" . $row["userID"] . "</td>";
                    echo "<td>" . $row["userEmail"] . "</td>";
                    echo "<td>" . $row["venue_name"] . "</td>";
                    echo "<td>" . $row["venue_type"] . "</td>";
                    echo "<td>" . $row["venue_price"] . "</td>";
                    echo "<td>" . $row["venue_size"] . "</td>";
                    echo "<td>" . $row["venue_location"] . "</td>";
                    echo "<td>" . $row["venue_description"] . "</td>";
                    echo '<td style="text-align: center;"> <a href="venue_delete.php?userID=' . $row["userID"] . '&venue_id=' . $row["venue_id"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
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
          $("#venue_table tr").each(function() {
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
