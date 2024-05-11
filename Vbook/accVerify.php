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
<title>User Account</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<style>

</style>

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
        <h1 class="dashboard-title">User Account</h1>
        <input type="text" placeholder="Search.." id="myInput">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>
  <div class="container">
    <div class="table-container">
      <table border="1" width="100%" id="activity_table">
       <tr>
           <th style="text-align: center;" width="3%">Id</th>
           <th width="15%">Username</th>
           <th width="15%">Email</th>
           <th width="15%">Contact</th>
           <th width="10%">Roles</th>
           <th style="text-align: center;" width="10%">Action</th>
       </tr>
       <?php
       $sql = "SELECT * FROM user WHERE userRoles <> 1";
       $result = mysqli_query($conn, $sql);

       if(mysqli_num_rows($result) > 0){
           //Output data of each rows
           while($row = mysqli_fetch_assoc($result)){
               echo "<tr>";
               echo "<td style='text-align: center;'>" . $row["userID"] . "</td><td>" . $row["userName"]. "</td><td>" . $row["userEmail"] . "</td><td>" . $row["contact"] . "</td><td>" . $row["userRoles"] . "</td>";
               echo '<td style="text-align: center;"> <a href="account_edit.php?id=' . $row["userID"] . '&userEmail=' . $row["userEmail"] .'">Edit</a>&nbsp;| ';
               echo '<a href="account_delete.php?userID=' . $row["userID"] . '&userEmail=' . $row["userEmail"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

</body>
</html>
