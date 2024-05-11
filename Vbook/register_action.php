<?php
include("config.php");

// Function to check password strength
function isStrongPassword($password) {
    // Check if password length is at least 8 characters
    if (strlen($password) < 8) {
        return false;
    }

    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check for at least one number
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // Check for at least one special character
    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        return false;
    }

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userRoles = mysqli_real_escape_string($conn, $_POST['userRoles']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    // Validate pwd and confirmPwd
    if ($userPwd !== $confirmPwd) {
        echo '<a href="register.php">Back<br></a>';
        die("Password and confirm password do not match.");
    }

    // Check if password meets criteria
    if (!isStrongPassword($userPwd)) {
        echo '<a href="register.php">Back<br></a>';
        die("Password does not meet complexity requirements.");
    }

    $sql = "SELECT * FROM user WHERE userEmail='$userEmail' OR userName='$userName' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        echo "<p ><b>Error: </b> User exists, please register a new user.</p>";
    } else {
        $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));

        $sql = "INSERT INTO user (userName, userEmail, userRoles, userPwd) VALUES ('$userName', '$userEmail', '$userRoles', '$pwdHash')";

        if (mysqli_query($conn, $sql)) {
            echo "<p>New user record created successfully.</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <p><a href="index.php"> | Login |</a></p>
</body>
</html>
