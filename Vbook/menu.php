<?php
// Check if a session is already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']); // Get the current PHP file name

// Assume $conn is your database connection

if (isset($_SESSION["UID"])) {
    $userID = $_SESSION["UID"];
    $sql = "SELECT userRoles FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userRoles = $row["userRoles"] ?? '';
    }

    $menu_items_logged_in = [
        'Dashboard' => 'dashboard.php',
        'Reservation' => 'reservation.php',
        'Activities' => 'activity.php',
        'Setting' => 'setting.php',
        'Logout' => 'logout.php'
    ];

    $menu_items_admin_logged_in = [
        'User Account' => 'accVerify.php',
        'Booking Record' => 'bookRecord.php',
        'Venue Record' => 'venueRecord.php',
        'Logout' => 'logout.php'
    ];

    $menu_items_manager_logged_in = [
      'Dashboard' => 'dashboard_manager.php',
      'Venue Setup' => 'venueSetup.php',
      'Customer' => 'customer.php',
      'Setting' => 'setting.php',
      'Logout' => 'logout.php'
    ];

    if ($userRoles == 1) {
      $menu_items = $menu_items_admin_logged_in;
    } elseif ($userRoles == 2) {
      $menu_items = $menu_items_logged_in;
    } elseif ($userRoles == 3) {
      $menu_items = $menu_items_manager_logged_in;
    }
} else {
    $menu_items = [
        'Login' => 'index.php',
        'Register' => 'register.php'
    ];
}

echo '<nav class="topnav" id="myTopnav">';

foreach ($menu_items as $label => $url) {
    $class = ($current_page == $url) ? 'active' : '';

    // Special logic for 'User Account' item
    if ($label == 'User Account' && strpos($current_page, 'account_edit.php') !== false) {
        $class = 'active';
    } elseif ($label == 'Booking Record' && strpos($current_page, 'book_edit.php') !== false) {
        $class = 'active';
    } elseif ($label == 'Venue Setup' && strpos($current_page, 'update_venue.php') !== false) {
        $class = 'active';
    } elseif ($label == 'Setting' && strpos($current_page, 'user_edit.php') !== false) {
        $class = 'active';
    } elseif ($label == 'Setting' && strpos($current_page, 'profile.php') !== false) {
        $class = 'active';
    }

    // Extracting the class name from the label
    $icon_class = ucfirst($label);

    echo '<a href="' . $url . '" class="' . $class . ' ' . $icon_class . '">';

    // Display the image next to the menu label
    echo '<img src="img/' . strtolower($label) . '.png" alt="' . $label . ' icon">';

    echo $label . '</a>';
}

echo '</nav>';
?>
