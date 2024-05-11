<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);
    $userRoles = "";
    $userRoles = 1;

    $sql = "SELECT * FROM user WHERE userEmail='$userEmail' OR userName='$userName' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        echo "<p ><b>Error: </b> User exists, please register a new user.</p>";
    } else {
        $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));

        $sql = "INSERT INTO user (userName, userEmail, userPwd, userRoles) VALUES ('$userName', '$userEmail', '$pwdHash', '$userRoles')";

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
