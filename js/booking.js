document.getElementById("bookingForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("book.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    if (data.trim() === "success") {
      window.location.href = "thank-you.html";
    } else {
      alert("Booking failed. Please try again.");
    }
  })
  .catch(() => {
    alert("Server error. Try again later.");
  });
});