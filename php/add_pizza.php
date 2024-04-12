<?php
session_start();
include '../php/includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $weight = $_POST['weight'];
    $fats = $_POST['fats'];
    $carbohydrates = $_POST['carbohydrates'];
    $calories = $_POST['calories'];
    $proteins = $_POST['proteins'];
    $sizes = $_POST['sizes'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image = $_FILES['image'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "png") {
        echo "Извините, разрешены только файлы PNG.";
        exit();
    }
    move_uploaded_file($image["tmp_name"], $target_file);

    $stmt = pdo()->prepare("INSERT INTO Pizzas (name, weight, fats, carbohydrates, calories, proteins, sizes, price, image_path, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $weight, $fats, $carbohydrates, $calories, $proteins, $sizes, $price, $target_file, $description]);

    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить пиццу</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<?php include '../php/fragments/head.php'; ?>

<body>
    <div class="add-product-form">
        <div class="container">
            <h1 class="title">Добавить пиццу</h1>

            <form action="" class="product-form" method="post" enctype="multipart/form-data">

                <div class="product-form-img">
                    <label for="image">
                        <div id="preview">Изображение (PNG):</div>
                    </label>
                    <input type="file" id="image" name="image" accept="image/png" required>
                </div>

                <div class="product-form-textInfo">
                    <input type="text" id="name" name="name" required placeholder="Название:">
                    <textarea id="description" name="description" required placeholder="Состав & Описание:"></textarea>
                    <input type="number" id="price" name="price" required placeholder="Цена (руб):">
                </div>

                <div class="product-form-digitalInfo">
                    <div class="digitalInfo-top">
                        <input type="number" id="proteins" name="proteins" required placeholder="Белки (г):">
                        <input type="number" id="fats" name="fats" required placeholder="Жиры (г):">
                        <input type="number" id="carbohydrates" name="carbohydrates" required placeholder="Углеводы (г):">
                    </div>
                    <div class="digitalInfo-bottom">
                        <input type="number" id="weight" name="weight" required placeholder="Вес (г):">
                        <input type="number" id="calories" name="calories" required placeholder="Калории (г):">
                        <input type="text" id="sizes" name="sizes" required placeholder="Размеры (см):">
                    </div>
                    <input type="submit" value="Добавить пиццу">

                </div>
            </form>

        </div>
    </div>
</body>

</html>