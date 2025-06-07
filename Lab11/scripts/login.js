const notificationSuccessClass = "login__notification_success";
const notificationErrorClass = "login__notification_error";

function drawSuccessMessage(text) {
    const notification = document.querySelector(".login__notification");
    notification.classList.add(notificationSuccessClass);
    notification.innerText = text;
}

function drawErrorMessage(text) {
    const notification = document.querySelector(".login__notification");
    notification.classList.add(notificationErrorClass);
    notification.innerText = text;
}

function hideMessage() {
    const notification = document.querySelector(".login__notification");
    notification.classList.remove(notificationSuccessClass);
    notification.classList.remove(notificationErrorClass);
}

async function loginListener(e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (!email || !password) {
        drawErrorMessage("🤓️ Поля обязательные");
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        drawErrorMessage("🤥 Неверный формат электропочты");
        return;
    }

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
        drawErrorMessage("🤥 Не те логин или пароль...")
    }
}

window.onload = () => {
    const form = document.querySelector(".login__form");
    form.addEventListener("submit", loginListener);
};