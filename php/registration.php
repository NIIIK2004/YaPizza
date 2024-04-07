<?php
require_once 'includes/db.php';
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $user_level = 1;
    $insertQuery = "INSERT INTO users (first_name, last_name, email, password, level) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('ssssi', $name, $surname, $email, $hashedPassword, $user_level);
    if ($stmt->execute()) {
        $_SESSION["user_id"] = $stmt->insert_id;
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $name;
        $_SESSION['user_surname'] = $surname;
        $_SESSION['user_email'] = $email;

        header("Location: profile.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReView - Регистрация</title>
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
                <a href="index.php">
                    <img src="../assets/images/logo.svg" alt="logo">
                </a>
            </div>
        </div>
    </div>
</header>

<body style="background: var(--black)">
<div class="auth__wrapper">
    <div class="landing-decor-gradient"></div>
    <form action="registration.php" method="post" class="auth__wrapper-form">
        <div class="auth__title">
            <h1>Создайте свой аккаунт</h1>
            <div class="auth__title-link">
                <span>Есть аккаунт?</span>
                <a href="authorization.php">Войдите!</a>
            </div>
        </div>
        <ul class="auth__input">
            <li onclick="activateInput(this)">Имя: <input type="text" id="name" name="name" required
                                                          placeholder="Например Никита"></li>
            <li onclick="activateInput(this)">Фамилия: <input type="text" id="surname" name="surname" required
                                                              placeholder="Ну словно Мешков"></li>
            <li onclick="activateInput(this)">Почта: <input type="email" id="email" name="email" required
                                                            placeholder="Может свою? А не чужую"></li>
            <li onclick="activateInput(this)">Пароль: <input type="password" id="password" name="password" required
                                                             placeholder="Придумайте сложный)"></li>
        </ul>
        <span class="auth__warn">При регистрации вы получаете второй уровень (+2) сразу</span>
        <div class="block_politika">
            <input type="checkbox" id="test2" checked="checked"/>
            <label for="test2">Регистрируясь вы соглашаетесь с политикой сервиса</label>
        </div>
        <button class="auth__btn" type="submit">Создать аккаунт</button>
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