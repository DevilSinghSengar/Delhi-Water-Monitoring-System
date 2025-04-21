<?php
// Start a PHP session to maintain user state across pages
session_start();

// Include the database configuration file that contains connection details
include './db/config.php';

// Enable error reporting to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data from POST request
    // The ?? operator provides a default empty string if the field is not set
    $name = $_POST['name'] ?? '';        // Get sender's name
    $email = $_POST['email'] ?? '';      // Get sender's email
    $subject = $_POST['subject'] ?? '';  // Get message subject
    $message = $_POST['message'] ?? '';  // Get message content
    $created_at = date('Y-m-d H:i:s');   // Get current date and time
    
    // Validate that all required fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "Please fill in all required fields.";
        exit;  // Stop execution if validation fails
    }
    
    // Validate email format using PHP's built-in filter
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please enter a valid email address.";
        exit;  // Stop execution if email is invalid
    }
    
    try {
        // Prepare SQL statement to prevent SQL injection
        // The ? placeholders will be replaced with actual values
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, ?)");
        
        // Check if statement preparation failed
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        // Bind parameters to the prepared statement
        // "sssss" means all five parameters are strings
        $stmt->bind_param("sssss", $name, $email, $subject, $message, $created_at);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        // Close the prepared statement to free up resources
        $stmt->close();
    } catch (Exception $e) {
        // Log the error to the server's error log
        error_log("Contact form error: " . $e->getMessage());
        // Display error message to user
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the request method is not POST, show error
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?> 