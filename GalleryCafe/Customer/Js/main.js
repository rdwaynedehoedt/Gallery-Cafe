const signInBtn = document.getElementById("signIn");
const signUpBtn = document.getElementById("signUp");
const container = document.querySelector(".container");

signInBtn.addEventListener("click", () => {
	container.classList.remove("right-panel-active");
});

signUpBtn.addEventListener("click", () => {
	container.classList.add("right-panel-active");
});

document.getElementById('form1').addEventListener('submit', function(e) {
    e.preventDefault();  
    const formData = new FormData(this);

    fetch('../php/signup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        
        if (data.message === "Sign up successful") {
            document.getElementById('form1').reset();
        }
    })
    .catch(error => console.error('Error:', error));
});

document.getElementById('form2').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        
        if (data.message === "Login successful") {
			 document.getElementById('form2').reset();
             window.location.href = 'Index.php'; 
        }
    })
    .catch(error => console.error('Error:', error));
});