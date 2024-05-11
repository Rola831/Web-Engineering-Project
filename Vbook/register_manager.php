<!DOCTYPE html>
<html>
<title>reservation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<body>

  <style>
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px; /* Adjust width as needed */
        margin: 0 auto; /* This will center the form */
      }

      label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }

      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px; /* Adjust font size as needed */
      }

      input[type="email"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box; /* This ensures that padding and border are included in the element's total width and height */
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

      input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
      }

      input[type="reset"] {
        background-color: #af4cab;
        color: #fff;
      }

      input[type="button"] {
        background-color: #af4cab;
        color: #fff;
      }

      /* Hover effect for buttons */
      input[type="submit"]:hover,
      input[type="reset"]:hover,
      input[type="button"]:hover {
        opacity: 0.9;
      }
  </style>

  <form class="" action="register_manager_action.php" method="post" autocomplete="off">
    <label for="userName">Username:</label>
    <input type="text" id="userName" name="userName" required><br><br>
      <label for="userEmail">Email:</label>
      <input type="email" id="userEmail" name="userEmail" required><br><br>
      <label for="userPwd">Password:</label>
      <input type="password" id="userPwd" name="userPwd" required><br><br>
      <label for="userPwd">Confirm Password:</label>
      <input type="password" id="confirmPwd" name="confirmPwd" required><br><br>
      <input type="submit" value="Register" style="cursor: pointer;">
      <input type="reset" value="Reset">
      <input type="reset" value="Cancel" onClick="cancelRegister()">
    </form>

</body>
</html>
