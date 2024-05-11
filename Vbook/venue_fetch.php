<?php
// Database connection details
$host = "localhost";
$dbname = "vbk";
$user = "root";
$pass = "";

// Create a PDO connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Fetch venues from the database
$query = "SELECT * FROM venue"; // Modify this query based on your actual table name and structure
$stmt = $conn->prepare($query);
$stmt->execute();

$venues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update the image path for each venue
foreach ($venues as &$venue) {
    $venue['venue_media'] = 'uploads/' . $venue['venue_media']; // Assuming the image path is stored in the 'image_path' column
}
unset($venue); // Unset the reference

function fetchVenueDetails($venue_id) {
    $query = "SELECT * FROM venue WHERE venue_id = $venue_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // Return null if no venue found
    }
}
?>
