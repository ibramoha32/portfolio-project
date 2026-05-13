<?php
// Contact Form Handler
// This script processes contact form submissions and saves them to the database

require_once '../config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Get and sanitize form data
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$subject = sanitizeInput($_POST['subject'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validate inputs
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
} elseif (strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address';
}

if (empty($subject)) {
    $errors[] = 'Subject is required';
} elseif (strlen($subject) < 3) {
    $errors[] = 'Subject must be at least 3 characters';
}

if (empty($message)) {
    $errors[] = 'Message is required';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters';
}

// Return errors if validation fails
if (!empty($errors)) {
    jsonResponse(false, implode(', ', $errors));
}

// Get database connection
$conn = getDBConnection();

// If DB is unavailable, return a friendly JSON error (prevents fatal errors)
if (!$conn) {
    jsonResponse(false, 'Database connection unavailable. Please start the database server.');
}

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
    if ($stmt->execute()) {
        jsonResponse(true, 'Message sent successfully!');
    } else {
        jsonResponse(false, 'Error saving message to database');
    }
    
    $stmt->close();
} else {
    jsonResponse(false, 'Database error: ' . $conn->error);
}

$conn->close();
?>
