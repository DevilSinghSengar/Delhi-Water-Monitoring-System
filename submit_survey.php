<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}

// Include your database config
include './db/config.php';

// Get form data
$username = $_SESSION['username'];
$location = $_POST['location'];
$color = $_POST['color'];
$odor = $_POST['odor'];
$waste = isset($_POST['waste']) ? implode(", ", $_POST['waste']) : '';
$comments = $_POST['comments'];

// insert
$sql = "INSERT INTO survey_responses (username, location, color, odor, waste, comments)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
  mysqli_stmt_bind_param($stmt, "ssssss", $username, $location, $color, $odor, $waste, $comments);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  echo "<script>alert('Survey submitted successfully!'); window.location.href = 'survey.php';</script>";
} else {
  echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
