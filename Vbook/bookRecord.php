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
<title>Booking Record</title>
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
        <h1 class="dashboard-title">Booking Record</h1>
        <input type="text" placeholder="Search.." id="myInput">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>

<div class="container">
  <div class="table-container">
    <table border="1" width="100%" id="activity_table">
     <tr>
         <th style="text-align: center;" width="2%">Id</th>
         <th width="15%">Username</th>
         <th width="15%">Venue Name</th>
         <th width="15%">Event Name</th>
         <th width="15%">Event Type</th>
         <th width="8%">Event Date</th>
         <th width="8%">Event Alt Date</th>
         <th style="text-align: center;" width="5%">Event No. Guest</th>
         <th style="text-align: center;" width="13%">Action</th>
     </tr>
     <?php
     $sql = "SELECT
                u.userID,
                u.userName,
                u.userEmail,
                b.book_id,
                b.venue_id,
                b.event_name,
                b.event_type,
                b.event_date,
                b.event_alt_date,
                b.event_no_guest,
                v.venue_name
            FROM
                user u
            LEFT JOIN
                booking b ON u.userID = b.userID
            LEFT JOIN
                venue v ON b.venue_id = v.venue_id
            WHERE
                b.userID IS NOT NULL
            ORDER BY
                u.userID, b.book_id;
            ";
     $result = mysqli_query($conn, $sql);

     if(mysqli_num_rows($result) > 0){
         //Output data of each rows
         while($row = mysqli_fetch_assoc($result)){
             echo "<tr>";
             echo "<td style='text-align: center;'>" . $row["userID"] . "</td><td>" . $row["userName"]. "</td><td>" . $row["venue_name"] . "</td><td>" . $row["event_name"] . "</td><td>" . $row["event_type"] . "</td><td>" . $row["event_date"] . "</td><td>" . $row["event_alt_date"] . "</td><td>" . $row["event_no_guest"] . "</td>";
             echo '<td style="text-align: center;"> <a href="book_edit.php?id=' . $row["userID"] . '&userEmail=' . $row["userEmail"] . '&book_id=' . $row["book_id"] . '&venue_id=' . $row["venue_id"] .'">Edit</a>&nbsp;| ';
             echo '<a href="book_delete.php?userID=' . $row["userID"] . '&userEmail=' . $row["userEmail"] . '&book_id=' . $row["book_id"] . '&venue_id=' . $row["venue_id"] .'" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
             echo "</tr>" . "\n\t\t";
         }
     } else {
         echo '<tr><td colspan="6">0 results</td></tr>';
     }

     mysqli_close($conn);
     ?>
  </table>

  </div>
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
