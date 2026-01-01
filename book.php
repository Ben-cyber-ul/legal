<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $fullname = trim($_POST["fullname"] ?? '');
  $email    = trim($_POST["email"] ?? '');
  $service  = trim($_POST["service"] ?? '');
  $message  = trim($_POST["message"] ?? '');

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
    "INSERT INTO bookings (fullname, email, service, message) VALUES (?, ?, ?, ?)"
  );

  mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $service, $message);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  $to = "ebenezerchibuzo3@gmail.com";

  /* ===============================
     CONFIRMATION EMAIL (USER)
  ================================= */

  $userSubject = "Booking Confirmation";
  $userMessage = "Hello $fullname,\n\nThank you for booking with us.\nWe have received your request for:\n\nService: $service\n\nWe will contact you shortly.\n\nBest regards,\nYour Company Name";

  $userHeaders = "From: Your Company <no-reply@yourwebsite.com>";

  @mail($email, $userSubject, $userMessage, $userHeaders);

  /* ===============================
     NOTIFICATION EMAIL (ADMIN)
  ================================= */
  $subject = "New booking received";

  $emailMessage = "You have received a new booking request.\n\n".
                  "Full Name: $fullname\n".
                  "Email: $email\n".
                  "Service: $service\n".
                  "Message: $message\n";

  $headers = "From: Booking system <booking@ebenezerlegalgroup.com>";

  @mail($to, $subject, $emailMessage, $headers);

  // ✅ Redirect to thank you page
  header("Location: thank-you.html");
  exit;
}
?>