<?php
require_once 'config/dbconfig.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


function uploadImage($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = 'img_' . date('Ymd_His') . '_' . uniqid() . '.' . $ext;
        $target = 'uploads/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return $target; // Save this in the DB
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $imagePath = isset($_FILES['image']) ? uploadImage($_FILES['image']) : null;

    if ($action == "Insert") {
        $stmt = $pdo->prepare("INSERT INTO product_items (productname, price, quantity, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['productname'], $_POST['price'], $_POST['quantity'], $imagePath]);

    } elseif ($action == "Update") {
        if ($imagePath) {
            $stmt = $pdo->prepare("UPDATE product_items SET productname=?, price=?, quantity=?, image=?, update_at=NOW() WHERE id=?");
            $stmt->execute([$_POST['productname'], $_POST['price'], $_POST['quantity'], $imagePath, $_POST['id']]);
        } else {
            $stmt = $pdo->prepare("UPDATE product_items SET productname=?, price=?, quantity=?, update_at=NOW() WHERE id=?");
            $stmt->execute([$_POST['productname'], $_POST['price'], $_POST['quantity'], $_POST['id']]);
        }

    } elseif ($action == "Delete") {
        $stmt = $pdo->prepare("DELETE FROM product_items WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

header("Location: index.php");
exit;
?>
