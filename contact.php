<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $fullname = trim($_POST["fullname"]);
  $email    = trim($_POST["email"]);
  $service  = trim($_POST["service"]);
  $message  = trim($_POST["message"]);

  // Basic validation
  if (empty($fullname) || empty($email) || empty($service) || empty($message)) {
    exit;
  }

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit;
  }

  // Prepare SQL
  $stmt = mysqli_prepare(
    $conn,
    "INSERT INTO contact_messages (fullname, email, service, message)
     VALUES (?, ?, ?, ?)"
  );

  mysqli_stmt_bind_param($stmt, "ssss",
    $fullname,
    $email,
    $service,
    $message
  );

  mysqli_stmt_execute($stmt);

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  // ✅ Redirect to thank you page
  header("Location: thank-you.html");
  exit;
}