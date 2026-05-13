<?php
// Projects API Endpoint
// This script fetches projects from the database and returns them as JSON

require_once '../config.php';

// Set content type to JSON
header('Content-Type: application/json');

// Get database connection
$conn = getDBConnection();

// Prepare SQL statement to fetch all projects ordered by creation date
$sql = "SELECT id, title, description, tags, link, image_url, created_at 
        FROM projects 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

$projects = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Parse tags from comma-separated string to array
        $tags = !empty($row['tags']) ? explode(',', $row['tags']) : [];
        $row['tags'] = array_map('trim', $tags);
        
        $projects[] = $row;
    }
}

// Return projects as JSON
echo json_encode($projects);

$conn->close();
?>
