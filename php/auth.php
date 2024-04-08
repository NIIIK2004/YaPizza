<?php
session_start();

include '../php/includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['auth'])) {
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    $stmt = pdo()->prepare("SELECT * FROM Users WHERE phone_number = ?");
    $stmt->execute([$phone_number]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];

        header("Location: profile.php");
        exit();
    } else {
        flash("Неверный номер телефона или пароль");
    }
}
?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
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

<body>
    <div class="auth__wrapper">
        <div class="landing-decor-gradient"></div>
        <?php flash(); ?>

        <form action="" method="post" class="auth__wrapper-form">
            <input type="text" id="phone_number" name="phone_number" required><br>
            <input type="text" name="name" placeholder="Имя" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button class="auth__btn" type="submit" name="auth">Войти</button>
        </form>
    </div>
</body>