<?php
// Подключение к базе данных
include '../php/includes/database.php';

session_start();

$stmt_drinks = pdo()->prepare("SELECT * FROM Drinks LIMIT 5");
$stmt_drinks->execute();
$drinks = $stmt_drinks->fetchAll(PDO::FETCH_ASSOC);


$stmt_pizzas = pdo()->prepare("SELECT * FROM Pizzas LIMIT 5");
$stmt_pizzas->execute();
$pizzas = $stmt_pizzas->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['donut_id']) && !empty($_GET['donut_id'])) {
    $donut_id = $_GET['donut_id'];

    $stmt = pdo()->prepare("SELECT * FROM Donuts WHERE donut_id = ?");
    $stmt->execute([$donut_id]);
    $donut = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: auth.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $pizza_id = isset($_POST['pizza_id']) ? $_POST['pizza_id'] : null;
    $drink_id = isset($_POST['drink_id']) ? $_POST['drink_id'] : null;
    $snack_id = isset($_POST['snack_id']) ? $_POST['snack_id'] : null;
    $donut_id = isset($_POST['donut_id']) ? $_POST['donut_id'] : null;

    $stmt = pdo()->prepare("INSERT INTO Basket (user_id, pizza_id, drink_id, snack_id, donut_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $pizza_id, $drink_id, $snack_id, $donut_id]);


    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подробная информация о пончиках</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<?php include '../php/fragments/head.php'; ?>

<body>
    <div class="container">
        <div class="product_details_wrapper">

            <div class="product_details-left">
                <img src="<?php echo $donut['image_path']; ?>" alt="<?php echo $donut['name']; ?>">
            </div>

            <div class="product_details-middle">
                <h1 class="product_details-title"><?php echo $donut['name']; ?></h1>
                <p class="product_details-description">Описание отсутсвует это эже пончики =)</p>
                <div class="product_details-middle-bottom">
                    <p class="product_details-cost"><?php echo $donut['price']; ?> ₽</p>
                    <div class="product_details-view">
                        <span><?php echo $donut['quantity']; ?> шт</span>
                    </div>
                </div>
            </div>

            <div class="product_details-right">
                <h1 class="product_details-right-title">Важные составляющие</h1>
                <ul class="product_details-info">
                    <li>
                        <?php echo isset($donut['proteins']) ? $donut['proteins'] : '?'; ?>
                        <span>Белки</span>
                    </li>
                    <li>
                        <?php echo isset($donut['fats']) ? $donut['fats'] : '?'; ?>
                        <span>Жиры</span>
                    </li>
                    <li>
                        <?php echo isset($donut['carbohydrates']) ? $donut['carbohydrates'] : '?'; ?>
                        <span>Углеводы</span>
                    </li>
                    <li>
                        <?php echo isset($donut['calories']) ? $donut['calories'] : '?'; ?>
                        <span>Калории</span>
                    </li>
                </ul>
                <form action="" method="POST">
                    <input type="hidden" name="donut_id" value="<?php echo $donut['donut_id']; ?>">
                    <button class="add_basket-btn" type="submit" name="add_to_cart" class="add_card-btn">Добавить в корзину</button>
                </form>
            </div>
        </div>

        <div class="products_other">
            <h1 class="title">Вместе с этим советуем</h1>
            <ul class="product_list">
                <?php foreach ($drinks as $drink) : ?>
                    <li class="product">
                        <a class="product_links" href="drink_details.php?drink_id=<?php echo $drink['drink_id']; ?>">
                            <div class="product_wrapper-for-image product_wrapper-drinks">
                                <img class="product_image" src="<?php echo $drink['image_path']; ?>">
                            </div>
                            <h2 class="product_name"><?php echo $drink['name']; ?></h2>
                            <p class="product_desc"><?php echo $drink['description']; ?></p>
                            <div class="product_cost">
                                <p><?php echo $drink['price']; ?> ₽</p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="products_other">
            <h1 class="title">Другие пиццы</h1>
            <ul class="product_list">
                <?php foreach ($pizzas as $pizza) : ?>
                    <li class="product">
                        <a class="product_links" href="product_details.php?pizza_id=<?php echo $pizza['pizza_id']; ?>">
                            <div class="product_wrapper-for-image product_wrapper-drinks">
                                <img class="product_image" src="<?php echo $pizza['image_path']; ?>">
                            </div>
                            <h2 class="product_name"><?php echo $pizza['name']; ?></h2>
                            <p class="product_desc"><?php echo $pizza['description']; ?></p>
                            <div class="product_cost">
                                <p><?php echo $pizza['price']; ?> ₽</p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <div style="margin-top: 80px;"></div>

    </div>
</body>

</html>