function goBackToHome() {
  window.location.href = '../Pages/Index.php';
}

document.getElementById('bookingForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('../php/booking.php', {
      method: 'POST',
      body: formData,
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === 'success') {
          document.getElementById('thank-you-box').style.display = 'block';

          document.getElementById('bookingForm').reset();
      } else {
          alert(data.message); 
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
});