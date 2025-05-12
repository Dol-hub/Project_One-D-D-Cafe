<?php
include('dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $comment = $_POST['comment'];

    $imageName = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($ext), $allowed)) {
            $imageName = uniqid('img_', true) . '.' . $ext;
            $uploadDir = 'uploads/';
            $uploadPath = $uploadDir . $imageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // สร้างโฟลเดอร์ถ้ายังไม่มี
            }

            move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
        }
    }

    $stmt = $connect->prepare("INSERT INTO menu (name, category, price, image, comment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $category, $price, $imageName, $comment);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
