document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault(); 
    
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
  
    
    if (email === "" || password === "") {
      document.getElementById("message").innerHTML = "Please fill out all fields.";
      return;
    }
  
  
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/adlogin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById("message").innerHTML = xhr.responseText;
        if (xhr.responseText === "Success") {
          window.location.href = "admin.php"; 
        }
      }
    };
  
    
    xhr.send("e=" + encodeURIComponent(email) + "&p=" + encodeURIComponent(password));
  });