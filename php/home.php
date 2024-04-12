<?php
include '../php/includes/database.php';

session_start();

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$stmt_pizza = pdo()->prepare("SELECT pizza_id, name, price, description, image_path FROM Pizzas");
$stmt_pizza->execute();
$pizzas = $stmt_pizza->fetchAll(PDO::FETCH_ASSOC);

$stmt_drink = pdo()->prepare("SELECT * FROM Drinks");
$stmt_drink->execute();
$drinks = $stmt_drink->fetchAll(PDO::FETCH_ASSOC);

$stmt_zakuski = pdo()->prepare("SELECT * FROM Snacks");
$stmt_zakuski->execute();
$zakuskis = $stmt_zakuski->fetchAll(PDO::FETCH_ASSOC);

$stmt_donat = pdo()->prepare("SELECT * FROM Donuts");
$stmt_donat->execute();
$donats = $stmt_donat->fetchAll(PDO::FETCH_ASSOC);

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_pizza'])) {
    // Получаем идентификатор пиццы для удаления
    $pizza_id = isset($_POST['pizza_id']) ? $_POST['pizza_id'] : null;

    if ($pizza_id) {
        try {
            pdo()->beginTransaction();

            $stmt_delete_basket = pdo()->prepare("DELETE FROM Basket WHERE pizza_id = ?");
            $stmt_delete_basket->execute([$pizza_id]);

            $stmt_delete_pizza = pdo()->prepare("DELETE FROM Pizzas WHERE pizza_id = ?");
            $stmt_delete_pizza->execute([$pizza_id]);

            pdo()->commit();

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (PDOException $e) {
            pdo()->rollBack();
            echo "Ошибка удаления пиццы: " . $e->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_drink'])) {
    $drink_id = isset($_POST['drink_id']) ? $_POST['drink_id'] : null;

    if ($drink_id) {
        try {
            pdo()->beginTransaction();

            $stmt_delete_basket = pdo()->prepare("DELETE FROM Basket WHERE drink_id = ?");
            $stmt_delete_basket->execute([$drink_id]);

            $stmt_delete_drink = pdo()->prepare("DELETE FROM Drinks WHERE drink_id = ?");
            $stmt_delete_drink->execute([$drink_id]);

            pdo()->commit();

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (PDOException $e) {
            pdo()->rollBack();
            echo "Ошибка удаления напитка: " . $e->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_snack'])) {
    $snack_id = isset($_POST['snack_id']) ? $_POST['snack_id'] : null;

    if ($snack_id) {
        try {
            pdo()->beginTransaction();

            $stmt_delete_basket = pdo()->prepare("DELETE FROM Basket WHERE snack_id = ?");
            $stmt_delete_basket->execute([$snack_id]);

            $stmt_delete_snack = pdo()->prepare("DELETE FROM Snacks WHERE snack_id = ?");
            $stmt_delete_snack->execute([$snack_id]);

            pdo()->commit();

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (PDOException $e) {
            pdo()->rollBack();
            echo "Ошибка удаления закуски: " . $e->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_donut'])) {
    $donut_id = isset($_POST['donut_id']) ? $_POST['donut_id'] : null;

    if ($donut_id) {
        try {
            pdo()->beginTransaction();

            $stmt_delete_basket = pdo()->prepare("DELETE FROM Basket WHERE donut_id = ?");
            $stmt_delete_basket->execute([$donut_id]);

            $stmt_delete_donut = pdo()->prepare("DELETE FROM Donuts WHERE donut_id = ?");
            $stmt_delete_donut->execute([$donut_id]);

            pdo()->commit();

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (PDOException $e) {
            pdo()->rollBack();
            echo "Ошибка удаления пончика: " . $e->getMessage();
        }
    }
}


?>

<style>
    footer {
        position: unset !important;
        bottom: 0;
    }
</style>
<?php include '../php/fragments/head.php'; ?>

<body>

    <section class="ads-banner">
        <div class="container">
            <img src="../assets/images/home/ads.png">
        </div>
    </section>

    <section class="category">
        <div class="container">
            <div class="category__wrapper">
                <div class="category-all">
                    <h1 class="title">Категории (Beta)</h1>
                    <ul>
                        <li><a href="#pizza">Пиццы</a></li>
                        <li><a href="#drink">Напитки</a></li>
                        <li><a href="#zakuski">Закуски</a></li>
                        <li><a href="#donat">Пончики</a></li>
                    </ul>
                </div>

                <div class="category category-pizza" id="pizza">
                    <h1 class="title">Пиццы</h1>
                    <ul class="product_list">
                        <?php if ($is_admin) : ?>
                            <a class="product_admin-add-btn" href="add_pizza.php">Добавить пиццу</a>
                        <?php endif; ?>

                        <?php foreach ($pizzas as $pizza) : ?>
                            <li class="product">
                                <a class="product_links" href="product_details.php?pizza_id=<?php echo $pizza['pizza_id']; ?>">
                                    <div class="product_wrapper-for-image">
                                        <img class="product_image" src="<?php echo $pizza['image_path']; ?>">
                                        <img class="product_image" src="<?php echo $pizza['image_path']; ?>">
                                    </div>
                                    <h2 class="product_name"><?php echo $pizza['name']; ?></h2>
                                    <p class="product_desc"><?php echo $pizza['description']; ?></p>
                                    <div class="product_cost">
                                        <p><?php echo $pizza['price']; ?> ₽</p>
                                        <form action="" method="POST">
                                            <input type="hidden" name="pizza_id" value="<?php echo $pizza['pizza_id']; ?>">
                                            <button type="submit" name="add_to_cart" class="add_card-btn"></button>
                                        </form>
                                        <?php if ($is_admin) : ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="pizza_id" value="<?php echo $pizza['pizza_id']; ?>">
                                                <button class="delete_admin" type="submit" name="delete_pizza">Del</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="category category-drink" id="drink">
                    <h1 class="title">Напитки</h1>
                    <ul class="product_list">
                        <?php if ($is_admin) : ?>
                            <a class="product_admin-add-btn" href="add_drink.php">Добавить напиток</a>
                        <?php endif; ?>
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
                                        <form action="" method="POST">
                                            <input type="hidden" name="drink_id" value="<?php echo $drink['drink_id']; ?>">
                                            <button type="submit" name="add_to_cart" class="add_card-btn"></button>
                                        </form>
                                        <?php if ($is_admin) : ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="drink_id" value="<?php echo $drink['drink_id']; ?>">
                                                <button class="delete_admin" type="submit" name="delete_drink">Del</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="category category-zakuski" id="zakuski">
                    <h1 class="title">Закуски</h1>
                    <ul class="product_list">
                        <?php if ($is_admin) : ?>
                            <a class="product_admin-add-btn" href="add_zakuski.php">Добавить закуску</a>
                        <?php endif; ?>
                        <?php foreach ($zakuskis as $zakuski) : ?>
                            <li class="product">
                                <a class="product_links" href="zakuski_details.php?snack_id=<?php echo $zakuski['snack_id']; ?>">
                                    <div class="product_wrapper-for-image product_wrapper-drinks">
                                        <img class="product_image" src="<?php echo $zakuski['image_path']; ?>">
                                    </div>
                                    <h2 class="product_name"><?php echo $zakuski['name']; ?></h2>
                                    <p class="product_desc"><?php echo $zakuski['description']; ?></p>
                                    <div class="product_cost">
                                        <p><?php echo $zakuski['price']; ?> ₽</p>
                                        <form action="" method="POST">
                                            <input type="hidden" name="snack_id" value="<?php echo $zakuski['snack_id']; ?>">
                                            <button type="submit" name="add_to_cart" class="add_card-btn"></button>
                                        </form>
                                        <?php if ($is_admin) : ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="snack_id" value="<?php echo $zakuski['snack_id']; ?>">
                                                <button class="delete_admin" type="submit" name="delete_snack">Del</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="category category-donat" id="donat">
                    <h1 class="title">Пончики</h1>
                    <ul class="product_list">
                        <?php if ($is_admin) : ?>
                            <a class="product_admin-add-btn" href="add_donat.php">Добавить пончики</a>
                        <?php endif; ?>
                        <?php foreach ($donats as $donat) : ?>
                            <li class="product">
                                <a class="product_links" href="donat_details.php?donut_id=<?php echo $donat['donut_id']; ?>">
                                    <div class="product_wrapper-for-image product_wrapper-drinks">
                                        <img class="product_image" src="<?php echo $donat['image_path']; ?>">
                                    </div>
                                    <h2 class="product_name"><?php echo $donat['name']; ?></h2>
                                    <div class="product_cost">
                                        <p><?php echo $donat['price']; ?> ₽</p>
                                        <form action="" method="POST">
                                            <input type="hidden" name="donut_id" value="<?php echo $donat['donut_id']; ?>">
                                            <button type="submit" name="add_to_cart" class="add_card-btn"></button>
                                        </form>
                                        <?php if ($is_admin) : ?>
                                            <form action="" method="POST">
                                                <input type="hidden" name="donut_id" value="<?php echo $donat['donut_id']; ?>">
                                                <button class="delete_admin" type="submit" name="delete_donut">Del</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</body>

<?php include '../php/fragments/footer.php'; ?>

<script>
</script>