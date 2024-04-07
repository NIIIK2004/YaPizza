<?php
$servername = "localhost";
$username = "admin4";
$password = "admin4";
$dbname = "review";

$mysqli = new mysqli($servername, $username, $password, $dbname);


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function pdo(): PDO {
    static $pdo;
    $servername = "localhost";
    $username = "admin4";
    $password = "admin4";
    $dbname = "review";

    if (!$pdo) {
        $dsn = 'mysql:dbname='.$dbname.';host='.$servername;
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

function flash(?string $message = null): void
{
    if ($message) {
        $_SESSION['flash'] = $message;
    } else {
        if (!empty($_SESSION['flash'])) { ?>
            <div class="alert alert-danger mb-3">
                <?=$_SESSION['flash']?>
            </div>
        <?php }
        unset($_SESSION['flash']);
    }
}