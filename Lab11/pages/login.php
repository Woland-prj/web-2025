<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Войти</title>
        <link rel="stylesheet" href="../styles/fonts.css" />
        <link rel="stylesheet" href="../styles/login_styles.css" />
        <script src="../scripts/login.js" defer></script>
    </head>

    <body>
        <div class="login">
            <div class="login__content">
                <h1 class="login__title">Войти</h1>
                <img
                    src="../images/login_image.png"
                    alt="Счастливый путешественник"
                    class="login__image"
                />
            </div>
            <form class="login__form">
                <div class="login__error">Error message</div>
                <label class="login__label" for="email">Электропочта</label>
                <input class="login__input" type="email" id="email" />
                <span class="login__hint"
                    >Введите электропочту в формате *****@***.**</span
                >

                <label class="login__label" for="password">Пароль</label>
                <div class="login__password-container">
                    <input class="login__input" type="password" id="password" />
                    <button type="button" class="login__toggle-password">
                        <object
                            data="../images/icons/eye_off.svg"
                            type="image/svg+xml"
                            class="login__toggle-icon"
                        ></object>
                    </button>
                </div>

                <button class="login__button" type="submit">Продолжить</button>
            </form>
        </div>
    </body>
</html>

