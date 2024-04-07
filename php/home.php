<?php

session_start();

require_once('includes/db.php');

$stmt = pdo()->query("SELECT * FROM categories LIMIT 8");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Создайте массив для хранения количества мест для каждой категории
$placeCounts = [];

foreach ($categories as $category) {
    $categoryId = $category['category_id'];

    $countQuery = "SELECT COUNT(*) AS place_count FROM places WHERE category_id = ?";
    $stmt = pdo()->prepare($countQuery);
    $stmt->execute([$categoryId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $placeCounts[$categoryId] = $result['place_count'];
}

$sql_last_reviews = "SELECT r.*, u.first_name, u.last_name, p.place_name, p.image_url 
                     FROM reviews r
                     INNER JOIN users u ON r.user_id = u.id
                     INNER JOIN places p ON r.place_id = p.place_id
                     ORDER BY r.date_created DESC LIMIT 4";
$stmt_last_reviews = pdo()->query($sql_last_reviews);
$last_reviews = $stmt_last_reviews->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../php/fragments/head.php'; ?>

<body>
<section class="category">
        <div class="container">
            <h1 class="title" style="color: var(--black)">Категории для просмотра отзывов</h1>
            <div class="category__wrapper">
                <ul class="category__wrapper-list">
                    <?php foreach ($categories as $category) : ?>
                        <li><a href="category.php?id=<?= $category['category_id'] ?>">
                                <div class="category-decor decor-cl-<?= $category['category_id'] ?>">
                                    <img src="../assets/images/category-<?= $category['category_id'] ?>.svg">
                                </div>
                                <h2 class="category-name"><?= $category['category_name'] ?></h2>
                                <!-- Используйте сохраненное значение для отображения количества мест -->
                                <span class="check"><?= $placeCounts[$category['category_id']] ?> штук </span>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <section class="last_news">
        <div class="container">
            <h1 class="title" style="color: var(--black)">Последние отзывы</h1>
            <ul class="last_news-list">
                <?php foreach ($last_reviews as $review) : ?>
                    <li style="width: 838px; /*height: 360px;*/">
                        <div class="last_news-top">
                            <div class="last_news-top-left">
                                <div class="last_news-top-left-ava">Н</div>
                                <?= $review['first_name'] ?> <?= $review['last_name'] ?>
                            </div>
                            <div class="last_news-top-right">
                                <?= date("d.m.Y", strtotime($review['date_created'])) ?>, <?= $review['place_name'] ?>
                            </div>
                        </div>

                        <div class="textInfo-rating" style="margin-top: 10px">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if ($i <= $review['rating']) : ?>
                                    <img src="../assets/images/star-active.svg" alt="star" class="star">
                                <?php else : ?>
                                    <img src="../assets/images/star-inactive.svg" alt="star" class="star">
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <p class="last_news-message">
                            <span class="comment"></span>
                            <?= $review['overall_impression'] ?>
                        </p>
                        <div class="last_news-bottom">
                            <ul class="last_news-bottom-btn">
                                <li>Спасибо</li>
                                <li>Не согласен</li>
                                <li>Ответить</li>
                            </ul>
                            <div class="last_news-bottom-right">
                                <div class="textInfo-likes">
                                    <p class="likes"><?= $review['likes'] ?></p>
                                    <p class="dislikes"><?= $review['dislikes'] ?></p>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="last_news"></section>

</body>
<script>
</script>