<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">

  <style>

  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
  }

  /* Overall body styles */
  body {
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
  }

  </style>

  <script>
      function validateForm() {
          var userPwd = document.getElementById("userPwd").value;
          var confirmPwd = document.getElementById("confirmPwd").value;

          if (userPwd !== confirmPwd) {
              alert("Passwords do not match.");
              return false;
          }
          return true;
      }
  </script>

  <title>Registeration</title>
</head>
<body>

  <!-- Registration Form Start -->
    <div class="registration-container">
        <form action="register_action.php" method="POST" class="registration-form" onsubmit="return validateForm();">
            <h2 class="registration-title">Sign Up</h2>

            <!-- Dropdown for selecting user role -->
            <select name="userRoles" id="userRoles" class="registration-select" required>
                
                <option value="2" selected>User</option>
                <option value="3">Manager</option>
            </select>

            <!-- Input fields for email, name, password, and confirm password -->
            <input type="email" name="userEmail" placeholder="Email Address" required>
            <input type="text" name="userName" placeholder="Name" required>
            <input type="password" name="userPwd" id="userPwd" placeholder="Password" required>
            <input type="password" name="confirmPwd" id="confirmPwd" placeholder="Confirm Password" required>
            <input type="submit" value="Register"> <!-- Submit button -->

            <!-- Link to the login page for existing users -->
            <p class="login-link">Already have an account? <a href="index.php">Login</a></p>
        </form>
    </div>
</body>
</html>
