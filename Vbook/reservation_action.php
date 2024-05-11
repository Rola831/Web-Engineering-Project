<?php
session_start();
include('config.php');

//variables
$action = "";
$venue_id = "";
$eventName = "";
$eventType = "";
$eventnoGuest = "";
$eventDate = "";
$eventaltDate = "";
$eventDesc = "";
$hotelRooms = "";

//this block is caleld when button Submit is clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //value for add or edit
  $venue_id = trim($_POST["venue_id"]);
  $eventName = trim($_POST["event_name"]);
  $eventType = trim($_POST["event_type"]);
  $eventDate = trim($_POST["event_date"]);
  $eventaltDate = trim($_POST["event_alt_date"]);
  $eventnoGuest = trim($_POST["event_no_guest"]);
  $hotelRooms = trim($_POST["hotel_room"]);
  $eventDesc = trim($_POST["event_description"]);


  // Prepare an SQL statement
  $stmt = $conn->prepare("INSERT INTO booking (venue_id, userID, event_name, event_type, event_date, event_alt_date, event_no_guest, hotel_room, event_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  // Bind parameters and execute the statement
  $stmt->bind_param("iissssiis", $venue_id, $_SESSION["UID"], $eventName, $eventType, $eventDate, $eventaltDate, $eventnoGuest, $hotelRooms, $eventDesc);

  // Set parameter values
  // Set other variables...

  if ($stmt->execute()){
    echo "Form data saved successfully!<br>";
    header("location:activity.php");
    exit;
  } else {
    // Insert failed
    echo "Error: " . $stmt->error;
    echo '<a href="activity.php">Back</a>';
  }
}

  // Close the statement
  $stmt->close();

  //function to insert data to database table
  function insertTo_DBTable($conn, $sql){
    if(mysqli_query($conn, $sql)){
      return true;
    } else {
      echo "Error: " . $sql . ":" . mysqli_error($conn) . "<br>";
      return false;
    }
  }

 ?>
