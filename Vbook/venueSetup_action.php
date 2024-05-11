<?php
session_start();
include('config.php');

//variables
$action = "";
$id = "";
$venue_name = "";
$venue_type = "";
$venue_price = "";
$venue_location = "";
$venue_size = "";
$venue_description = "";

//for upload
$target_dir = "uploads/";
$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$uploadfileName = "";

//this block is caleld when button Submit is clicked
if($_SERVER["REQUEST_METHOD"] == "POST"){
  //value for add or edit
  $venue_name = $_POST["venue_name"];
  $venue_type = $_POST["venue_type"];
  $venue_price = $_POST["venue_price"];
  $venue_location = $_POST["venue_location"];
  $venue_size = $_POST["venue_size"];
  $venue_description = $_POST["venue_description"];

  $filetmp = $_FILES["filetoUpload"];
  //file of the image/photo file
  $uploadfileName = $filetmp["name"];

  //Check if there is an image to be uploaded
  //IF no image
  if(isset($_FILES["filetoUpload"]) && $_FILES["filetoUpload"]["name"] == ""){
    $sql = "INSERT INTO venue (userID, venue_name, venue_type, venue_price, venue_location, venue_size, venue_description, venue_media) VALUES (" . $_SESSION["UID"] . ", '" . $venue_name . "', '" . $venue_type . "', '" . $venue_price . "','" . $venue_location . "', '" . $venue_size . "', '" . $venue_description . "', '" . $uploadfileName . "')";
    $status = insertTo_DBTable($conn, $sql);

    if($status){
      echo "Form data saved successfully!<br>";
      echo '<a href="venueSetup.php">Back</a>';
    } else {
      echo '<a href="venueSetup.php">Back</a>';
    }
  }
  //IF there is image
  else if(isset($_FILES["filetoUpload"]) && $_FILES["filetoUpload"]["error"] == UPLOAD_ERR_OK){
    //Variable to determine for image upload is OK
    $uploadOk = 1;
    $filetmp = $_FILES["filetoUpload"];

    //file of the image/photo file
    $uploadfileName = $filetmp["name"];

    $target_file = $target_dir . basename($_FILES["filetoUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    //Check if file already exists
    if(file_exists($target_file)){
      echo "ERROR: Sorry, image file $uploadfileName already exists.<br>";
      $uploadOk = 0;
    }

    //Check file size <= 488.28KB or 500000 bytes
    if($_FILES["filetoUpload"]["size"] > 500000){
      echo "ERROR: Sorry, your file is too large. Try resizing your image.<br>";
      $uploadOk = 0;
    }

    //Allow only these file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
      echo "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
      $uploadOk = 0;
    }

    //If uploadOk, then try add to database first
    //uploadOk = 1 if there is image to be uploaded, file size is ok and format ok
    if($uploadOk){
      $sql = "INSERT INTO venue (userID, venue_name, venue_type, venue_price, venue_location, venue_size, venue_description, venue_media) VALUES (" . $_SESSION["UID"] . ", '" . $venue_name . "', '" . $venue_type . "', '" . $venue_price . "','" . $venue_location . "', '" . $venue_size . "', '" . $venue_description . "', '" . $uploadfileName . "')";

      $status = insertTo_DBTable($conn, $sql);

      if($status){
        if(move_uploaded_file($_FILES["filetoUpload"]["tmp_name"],$target_file)){
          //Image file successfully uploaded
          //Tell successfull record
          echo "Form data saved successfully!<br>";
          header("location:dashboard_manager.php");
          exit;
        } else {
          //There is an error while uplaoding image
          echo "Sorry, there was an error uploading your file.<br>";
          echo '<a href="javascript:history.back()">Back</a>';
        }
      } else {
        echo '<a href="javascript:history.back()">Back</a>';
      }
    }
  }
}

  //close db connection
  mysqli_close($conn);

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
