<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || 
    !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Unauthorized access";
    exit;
}

include './db/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = $_POST['message_id'] ?? '';
    
    if (!empty($message_id)) {
        // Update the message status to read
        $sql = "UPDATE contact_messages SET is_read = TRUE WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $message_id);
        
        if ($stmt->execute()) {
            echo "Message marked as read";
        } else {
            echo "Error updating message status";
        }
        
        $stmt->close();
    } else {
        echo "Invalid message ID";
    }
} else {
    echo "Invalid request method";
}

$conn->close();
?> 