<?php
session_start();

include '../php/includes/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $personal_promo_code = $_POST['personal_promo_code'];
    $phone_number = $_POST['phone_number'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $delivery_address = $_POST['delivery_address'];
    
    if ($password !== $confirm_password) {
        flash("Пароли не совпадают");
        header("Location: registration.php");
        exit();
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt_check_phone = pdo()->prepare("SELECT * FROM Users WHERE phone_number = ?");
    $stmt_check_phone->execute([$phone_number]);
    $user = $stmt_check_phone->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        flash("Номер телефона уже используется. Пожалуйста, укажите другой номер.");
        header("Location: registration.php");
        exit();
    }
    
    $stmt = pdo()->prepare("INSERT INTO Users (personal_promo_code, phone_number, name, password, delivery_address, registration_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$personal_promo_code, $phone_number, $name, $hashed_password, $delivery_address]);

    flash("Регистрация прошла успешно! Можете войти на сайт.");
    header("Location: auth.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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

<body>
    <div class="auth__wrapper">
        <div class="landing-decor-gradient"></div>
        <?php flash(); ?>
        <form action="registration.php" method="POST">
            <label for="personal_promo_code">Персональный Промокод:</label><br>
            <input type="text" id="personal_promo_code" name="personal_promo_code" required><br>
            <label for="phone_number">Номер телефона:</label><br>
            <input type="text" id="phone_number" name="phone_number" required><br>
            <label for="name">Имя:</label><br>
            <input type="text" id="name" name="name" required><br>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Подтверждение пароля:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <label for="delivery_address">Адрес доставки:</label><br>
            <input type="text" id="delivery_address" name="delivery_address" required><br>
            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>

</body>