<?php
function displayAvatar($conn) {
    // Check if the user is logged in
    if(!isset($_SESSION["UID"])){
        return '<img src="img/avatar.png" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">';
    }

    $userID = $_SESSION["UID"];
    $fetchSql = "SELECT user_avatar FROM user WHERE userID = ?";
    $fetchStmt = mysqli_prepare($conn, $fetchSql);
    if ($fetchStmt) {
        mysqli_stmt_bind_param($fetchStmt, "i", $userID);
        mysqli_stmt_execute($fetchStmt);
        $result = mysqli_stmt_get_result($fetchStmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $user_avatar = $row['user_avatar'];
            $avatarPath =  $user_avatar;

            if (file_exists($avatarPath)) {
                return '<img src="' . $avatarPath . '" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">';
            } else {
                return '<img src="img/avatar.png" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">';
            }
        }
        mysqli_stmt_close($fetchStmt);
    }

    return '<img src="img/avatar.png" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%;">';
}
?>
