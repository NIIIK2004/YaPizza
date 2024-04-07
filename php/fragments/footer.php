<?php

require_once('includes/db.php');

$stmt = pdo()->query("SELECT * FROM categories LIMIT 8");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$countQuery = "SELECT COUNT(*) AS place_count FROM places WHERE category_id = ?";
$stmt = $conn->prepare($countQuery);
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $placeCount = $row['place_count'];
} else {
    $placeCount = 0;
}

?>

<footer class="footer">
    <div class="container">
        <div class="footer__wrapper">

            <div class="footer_top">
                <div class="footer_left">
                    <h1 class="footer_title">Советуем посмотреть другие категории</h1>
                    <ul>
                        <li><a href="category.php?id=1">
                                <h2 class="footer_category-name"><?= $categories[0]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=2">
                                <h2 class="footer_category-name"><?= $categories[1]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=3">
                                <h2 class="footer_category-name"><?= $categories[2]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=4">
                                <h2 class="footer_category-name"><?= $categories[3]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=5">
                                <h2 class="footer_category-name"><?= $categories[4]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=6">
                                <h2 class="footer_category-name"><?= $categories[5]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=7">
                                <h2 class="footer_category-name"><?= $categories[6]['category_name'] ?></h2>
                            </a>
                        </li>
                        <li><a href="category.php?id=8">
                                <h2 class="footer_category-name"><?= $categories[7]['category_name'] ?></h2>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="footer_right">
                    <p class="footer_desc">Может хотите персональную рассылку на новые отзывы?</p>
                    <form action="#" method="post">
                        <input type="email" placeholder="Введите свою почту">
                        <button class="footer_button" type="submit">Подписаться</button>
                    </form>
                </div>
            </div>

            <ul class="footer_links">
                <li><a href=""><img src="../assets/images/youtube.svg" alt=""></a></li>
                <li><a href=""><img src="../assets/images/vk.svg" alt=""></a></li>
                <li><a href=""><img src="../assets/images/figma.svg" alt=""></a></li>
                <li><a href=""><img src="../assets/images/telegram.svg" alt=""></a></li>
            </ul>
        </div>
    </div>
</footer>