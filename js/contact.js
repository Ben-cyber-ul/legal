document.getElementById("contactForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("contact.php", {
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
    alert("Server error. Please try later.");
  });
});