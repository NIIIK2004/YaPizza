<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReView - Отзывы</title>
    <link rel="shortcut icon" href="../assets/images/icon.ico" type="images/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<header class="header">
    <div class="container">
        <div class="header__wrapper">
            <div class="header-left-part">
                <a href="home.php">
                    <img src="../assets/images/logo.svg" alt="logo">
                </a>
            </div>
            <div class="header-right-part">
                <ul class="header_list">
                    <a href="/php/home.php">
                        <li>Главная</li>
                    </a>
                    <a href="/php/FAQ.php">
                        <li>FAQ</li>
                    </a>
                    <a href="/php/contacts.php">
                        <li>Контакты</li>
                    </a>
                    <a href="/php/system_level.php">
                        <li>Достижения</li>
                    </a>
                </ul>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a class="header-login" href="profile.php">Профиль</a>';
                } else {
                    echo '<a class="header-login" href="authorization.php">Войти</a>';
                }
                ?>
            </div>
        </div>
    </div>
</header>
