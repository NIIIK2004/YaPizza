<?php
session_start();
include '../php/includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && isset($_POST['itemId'])) {
    $type = $_POST['type'];
    $itemId = $_POST['itemId'];

    $table = '';
    $field = '';
    switch ($type) {
        case 'pizza':
            $table = 'Pizzas';
            $field = 'pizza_id';
            break;
        case 'drink':
            $table = 'Drinks';
            $field = 'drink_id';
            break;
        case 'snack':
            $table = 'Snacks';
            $field = 'snack_id';
            break;
        case 'donut':
            $table = 'Donuts';
            $field = 'donut_id';
            break;
        default:
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
    }

    $stmt = pdo()->prepare("DELETE FROM Basket WHERE user_id = ? AND $field = ?");
    $stmt->execute([$user_id, $itemId]);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
    $stmt = pdo()->prepare("DELETE FROM Basket WHERE user_id = ?");
    $stmt->execute([$user_id]);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}


$stmt_pizza = pdo()->prepare("SELECT B.*, P.name, P.price, P.image_path FROM Basket B INNER JOIN Pizzas P ON B.pizza_id = P.pizza_id WHERE B.user_id = ?");
$stmt_pizza->execute([$user_id]);
$basket_pizzas = $stmt_pizza->fetchAll(PDO::FETCH_ASSOC);

$stmt_drink = pdo()->prepare("SELECT B.*, D.name, D.price, D.image_path FROM Basket B INNER JOIN Drinks D ON B.drink_id = D.drink_id WHERE B.user_id = ?");
$stmt_drink->execute([$user_id]);
$basket_drinks = $stmt_drink->fetchAll(PDO::FETCH_ASSOC);

$stmt_snack = pdo()->prepare("SELECT B.*, S.name, S.price, S.image_path FROM Basket B INNER JOIN Snacks S ON B.snack_id = S.snack_id WHERE B.user_id = ?");
$stmt_snack->execute([$user_id]);
$basket_snacks = $stmt_snack->fetchAll(PDO::FETCH_ASSOC);

$stmt_donut = pdo()->prepare("SELECT B.*, D.name, D.price, D.image_path FROM Basket B INNER JOIN Donuts D ON B.donut_id = D.donut_id WHERE B.user_id = ?");
$stmt_donut->execute([$user_id]);
$basket_donuts = $stmt_donut->fetchAll(PDO::FETCH_ASSOC);

$basket_items = array_merge($basket_pizzas, $basket_drinks, $basket_snacks, $basket_donuts);

$total_price = 0;
foreach ($basket_items as $item) {
    $total_price += $item['price'];
}


// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
//     if (empty($basket_items)) {
//         header("Location: cart.php?error=empty_cart");
//         exit();
//     }

//     $stmt_order = pdo()->prepare("INSERT INTO Orders (user_id, total_price, order_date) VALUES (?, ?, NOW())");
//     $stmt_order->execute([$user_id, $total_price]);

//     $order_id = pdo()->lastInsertId();

//     foreach ($basket_items as $item) {
//         $stmt_order_item = pdo()->prepare("INSERT INTO Order_Items (order_id, item_id, item_type, quantity, price) VALUES (?, ?, ?, ?, ?)");
//         $stmt_order_item->execute([$order_id, $item['id'], $item['type'], 1, $item['price']]);
//     }

//     $stmt_clear_basket = pdo()->prepare("DELETE FROM Basket WHERE user_id = ?");
//     $stmt_clear_basket->execute([$user_id]);

//     header("Location: order_confirmation.php?order_id=$order_id");
//     exit();
// }


// ?>

<?php include '../php/fragments/head.php'; ?>


<body>

    <section class="checkout-section">
        <div class="container">
            <div class="checkout-header">
                <h1 class="title">Оформление заказа</h1>
                <form method="post">
                    <input type="hidden" name="delete_all" value="true">
                    <button class="delete_all" type="submit">Удалить все</button>
                </form>
            </div>
            <div class="checkout-wrapper">
                <div class="checkout-items">
                    <?php if (empty($basket_items)) : ?>
                        <p>Ваша корзина пуста.</p>
                    <?php else : ?>
                        <?php if (empty($basket_items)) : ?>
                            <div class="error-message">Ваша корзина пуста. Нельзя совершить заказ.</div>
                        <?php endif; ?>
                        <?php foreach ($basket_items as $item) : ?>
                            <div class="checkout-item">
                                <div class="checkout-item-left">
                                    <div class="checkout-item-image">
                                        <img src="<?php echo $item['image_path']; ?>" alt="<?php echo $item['name']; ?>">
                                    </div>
                                    <div class="checkout-item-info">
                                        <h2><?php echo $item['name']; ?></h2>
                                        <span class="checkout-item-price"><?php echo $item['price']; ?> ₽</span>
                                    </div>
                                </div>
                                <div class="checkout-item-right">
                                    <div class="checkout-item-quantity">
                                        <button class="checkout-item-quantity-btn">-</button>
                                        <input type="number" value="1" min="1" class="checkout-item-quantity-input">
                                        <button class="checkout-item-quantity-btn">+</button>
                                    </div>
                                    <div class="checkout-item-delete">
                                        <form method="post">
                                            <input type="hidden" name="type" value="<?php echo isset($item['type']) ? $item['type'] : ''; ?>">
                                            <input type="hidden" name="itemId" value="<?php echo isset($item['id']) ? $item['id'] : ''; ?>">
                                            <!-- <button type="submit">Удалить</button> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="summary">
                    <h1 class="summary-title">Предварительный чек</h1>
                    <div class="summary-value">
                        <span>Количество товаров:</span>
                        <span><?php echo count($basket_items); ?> шт.</span>
                    </div>
                    <div class="summary-promocode">
                        <input type="text" placeholder="Введите промокод">
                        <button></button>
                    </div>
                    <div class="summary-skidka">
                        <span>Скидка:</span>
                        <span class="slidka-value">0%</span>
                    </div>
                    <div class="summary-summa">
                        <span>Общая сумма:</span>
                        <span class="summa-value"><?php echo $total_price; ?>руб</span>
                    </div>
                    <form method="post">
                        <!-- Возможно, здесь будут другие поля для ввода информации о доставке, контактной информации и т.д. -->
                        <button class="summary-btn" type="submit" name="checkout">Оформить заказ</button>
                    </form>
                </div>
            </div>
    </section>
</body>

</html>