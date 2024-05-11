<!DOCTYPE html>
<html>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<body>

<style>
body{
  background-color: rgba(7, 2, 13, 0.85);
}

  /* Sidebar Styles */
.sidebar {
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #f4F4F9;
    overflow-x: hidden;
    padding-top: 20px;
}

/* Container Styles */
.container {
    padding: 0 16px;
}

/* Logo Styles */
.imglogo {
    text-align: center;
    margin-bottom: 20px;
}

.logo {
    width: 80px;
    height: auto;
}

/* Login Form Styles */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px; /* Adjust font size as needed */
}

input[type="submit"],
input[type="reset"],
input[type="button"] {
  width: 100%;
  padding: 10px 5px;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 10px; /* Space between buttons */
}

input[type="submit"]:hover {
    background-color: #ff7f11;
}

  </style>

<div class="sidebar" style="width:20%">
  <form action="login_action.php" method="post" id="login">
  <div class="container">
    <div class="imglogo">
      <img id="login_logo" src="img\black_logo.png" alt="logo" class="logo">
    </div>
    <label for="userName"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="userName" required>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="userPwd" required>
    <input type="submit" value="Login">
    <label style="text-align: center;"> <input type="checkbox" checked="checked" name="remember"> Remember me </label>
    <div style="text-align: center;">
      <span class="psw">
        <a href="register.php" style="cursor: pointer;">Register</a>
        <a style="cursor: pointer;">Forgot password?</a>
      </span>
    </div>
  </div>
  </form>
</div>

 <!-- Page Content -->
<div style="margin-left:20%;">
  <div class="img_collage">
      <div class="row">
          <img src="img/outdoor.jpeg" alt="outdoor">
          <img src="img/meeting_room.jpg" alt="meetingroom1">
      </div>
      <div class="row">
          <img src="img/ballroom.jpg" alt="ballroom">
          <img src="img/meetingroom1.png" alt="meetingroom2">
      </div>
      <div class="row">
          <img src="img/weddingroom.jpg" alt="weddingroom">
          <img src="img/showroom.jpg" alt="showroom">
      </div>
  </div>
</div>





</body>
</html>
