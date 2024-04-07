<?php
require_once('includes/db.php');
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: authorization.php");
    exit();
}

if (isset($_SESSION["avatar_path"])) {
    $avatar_path = $_SESSION["avatar_path"];
} else {
    $avatar_path = "https://img.freepik.com/premium-vector/user-icon-human-person-symbol-social-profile-icon-avatar-login-sign-web-user-symbol-neumorphic-ui-ux-white-user-interface-web-button-neumorphism-vector-eps-10_399089-2757.jpg";
}


$user_id = $_SESSION["user_id"];
$selectQuery = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($selectQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header("Location: error_page.php");
    exit();
}

$stmt->close();
$conn->close();
?>

<?php
include '../php/fragments/head-light.php';
?>

<body style="background: #1d1d1f">

<section class="profile">
    <div class="container">
        <h1 class="title">Профиль</h1>
        <div class="container_profile">
            <div class="profile_ava">
                <div class="profile_gradient"></div>
                <img class="profile__tools-ava" src="<?php echo $avatar_path; ?>" alt="Аватар">
            </div>
            <div class="profile_info">
                <h2 class="profile_info-name"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h2>
                <p class="profile_info-lvl">Уровень <?php echo $user['level']; ?></p>
            </div>
            <div class="profile_link">
                <a href="setting.php" class="profile__tools-setting">Расширенный настройки</a>
                <a href="logout.php" class="profile__tools-logoutprofile" style="color: white">Выйти из аккаунта</a>
            </div>
        </div>
    </div>
</section>
</body>