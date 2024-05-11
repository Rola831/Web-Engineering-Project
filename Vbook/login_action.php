<?php
session_start();
include("config.php");

// Login values from login form
$userName = $_POST['userName'];
$userPwd = $_POST['userPwd'];

$sql = "SELECT * FROM user WHERE userName='$userName' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // Check password hash
    $row = mysqli_fetch_assoc($result);
    if (password_verify($_POST['userPwd'], $row['userPwd'])) {
        $_SESSION["UID"] = $row["userID"];
        $_SESSION["userName"] = $row["userName"];
        // Set logged in time
        $_SESSION['loggedin_time'] = time();

        // Fetch user's role
        $sqlRole = "SELECT userRoles FROM user WHERE userID = " . $_SESSION["UID"];
        $resultRole = mysqli_query($conn, $sqlRole);
        $rowRole = mysqli_fetch_assoc($resultRole);
        $userRole = $rowRole["userRoles"] ?? '';

        // Redirect based on role
        if ($userRole == 1) {
            header("location:accVerify.php");  // Replace with your admin page's URL
            exit;  // Ensure the script stops here after redirecting
        } elseif ($userRole == 2) {
          header("location:dashboard.php");
          exit;
        } elseif ($userRole == 3) {
          header("location:dashboard_manager.php");
          exit;
        }
    } else {
        echo 'Login error, user email and password is incorrect.<br>';
        echo '<a href="index.php?login=1"> | Login |</a> &nbsp;&nbsp;&nbsp; <br>';
    }
} else {
    echo "Login error, user <b>$userName</b> does not exist. <br>";
    echo '<a href="index.php?login=1"> | Login |</a>&nbsp;&nbsp;&nbsp; <br>';
}

mysqli_close($conn);
?>
