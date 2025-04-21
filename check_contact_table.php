<?php
require_once 'config.php';

// Check if table exists
$table_check = $conn->query("SHOW TABLES LIKE 'contact_messages'");

if ($table_check->num_rows == 0) {
    // Create the table if it doesn't exist
    $create_table = "CREATE TABLE contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME NOT NULL,
        is_read BOOLEAN DEFAULT FALSE
    )";
    
    if ($conn->query($create_table) === TRUE) {
        echo "Contact messages table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Contact messages table already exists";
}

$conn->close();
?> 