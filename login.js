const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.text()) 
    .then(data => {
        console.log(data); 
        try {
            const parsedData = JSON.parse(data);
            if (parsedData.status === "success") {
                if (parsedData.role === "student") {
                    window.location.href = "main.html";
                } else if (parsedData.role === "admin") {
                    window.location.href = "admin_view.php";
                }
            } else {
                document.getElementById("invalid").style.display = "block";
                document.getElementById('username').value = "";
                document.getElementById('password').value = "";
            }
        } catch (e) {
            console.error('Error parsing JSON:', e, data);
        }
    })
    .catch(error => console.error('Error:', error));    
});

