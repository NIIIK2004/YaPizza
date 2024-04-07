<?php
session_start();
require_once('includes/db.php');

if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit();
}

if (isset($_POST['auth'])) {

    // проверяем наличие пользователя с указанным юзернеймом
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `email` = :email");
    $stmt->execute(['email' => $_POST['email']]);
    if (!$stmt->rowCount()) {
        flash('Пароль или логин неверен');
        header("Location: {$_SERVER['HTTP_REFERER']}");
        die;
    }
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // проверяем пароль
    if (password_verify($_POST['password'], $user['password'])) {
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = pdo()->prepare('UPDATE `users` SET `password` = :password WHERE `email` = :email');
            $stmt->execute([
                'email' => $_POST['email'],
                'password' => $newHash,
            ]);
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: profile.php');
        die;
    }

    flash('Пароль или логин неверен');
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReView - Авторизация</title>
    <link rel="shortcut icon" href="../assets/images/icon.ico" type="images/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<header class="header">
    <div class="container">
        <div class="header__wrapper">
            <div class="header-left-part" style="margin: 0 auto;">
                <a href="landingPage.php">
                    <img src="../assets/images/logo.svg" alt="logo">
                </a>
            </div>
        </div>
    </div>
</header>

<body style="background: var(--black)">
    <div class="auth__wrapper">
        <div class="landing-decor-gradient"></div>
        <form action="" method="post" class="auth__wrapper-form">
            <div class="auth__title">
                <h1>Войдите в свой аккаунт</h1>
                <div class="auth__title-link">
                    <span>Нет аккаунта?</span>
                    <a href="registration.php">Зарегистрируйтесь!</a>
                </div>
            </div>
            <ul class="auth__input">
                <span class="error-text"><?php flash(); ?></span>
                <li onclick="activateInput(this)">Почта: <input type="email" id="email" name="email" required placeholder="Введите почту"></li>
                <li onclick="activateInput(this)">Пароль: <input type="password" id="password" name="password" required placeholder="Введите пароль"></li>
            </ul>
            <div class="block_politika">
                <label for="test2"><a href="#">Забыли пароль?</a></label>
            </div>
            <button class="auth__btn" style="background: #6561CE" type="submit" name="auth">Войти</button>
        </form>
    </div>

</body>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    function activateInput(li) {
        let input = li.querySelector('input');
        input.focus();
        li.classList.toggle('clicked');
    }
</script>