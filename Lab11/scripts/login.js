async function loginListener(e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
        const response = await fetch("http://localhost:8080/api/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        if (response.ok) {
            window.location.href = "home";
        } else {
            document.querySelector(".login__error").textContent = data.message || "Ошибка входа";
            document.querySelector(".login__error").style.display = "block";
        }
    } catch (error) {
        console.error("Error:", error);
        document.querySelector(".login__error").textContent = "Ошибка соединения с сервером";
        document.querySelector(".login__error").style.display = "block";
    }
}

window.onload = () => {
    const form = document.querySelector(".login__form");
    form.addEventListener("submit", loginListener);
};