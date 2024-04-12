<?php
session_start();
include '../php/includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = pdo()->prepare("SELECT * FROM Users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php
include '../php/fragments/head.php';
?>

<body>

    <section class="profile">
        <div class="container">
            <div class="profile__wrapper">
            <div class="profile__wrapper-top">
                <h1 class="title">Мой аккаунт</h1>
                <a href="logout.php">Выйти из аккаунта</a>
            </div>

                <ul class="profile_list">
                    <li>
                        <div class="profile_text">
                            <span>Профиль</span>
                            <img class="profile-icon" src="../assets/images/profile/name.svg">
                        </div>
                        <p class="profile_info"><?php echo $user['name']; ?></p>
                    </li>

                    <li>
                        <div class="profile_text">
                            <span>Заказы</span>
                            <img class="profile-icon" src="../assets/images/profile/order.svg">
                        </div>
                        <p class="profile_info"><?php echo $user['orders_count']; ?></p>
                    </li>

                    <li>
                        <div class="profile_text">
                            <span>Адрес</span>
                            <img class="profile-icon" src="../assets/images/profile/address.svg">
                        </div>
                        <p class="profile_info"><?php echo $user['delivery_address']; ?></p>
                    </li>

                    <li>
                        <div class="profile_text">
                            <span>Вы с нами</span>
                            <img class="profile-icon" src="../assets/images/profile/date.svg">
                        </div>
                        <p class="profile_info"><?php
                                                $registration_date = new DateTime($user['registration_date']);
                                                $current_date = new DateTime();
                                                $days_registered = $registration_date->diff($current_date)->days;
                                                ?><?php echo $days_registered; ?> дней</p>
                    </li>

                    <li>
                        <div class="profile_text">
                            <span>Ваш промокод</span>
                            <img class="profile-icon" src="../assets/images/profile/promocode.svg">
                        </div>
                        <p class="profile_info"><?php echo $user['personal_promo_code']; ?></p>
                    </li>
                </ul>

            </div>
        </div>
    </section>
</body>