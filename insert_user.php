<?php
$connect = new mysqli('localhost', 'root', '', 'login'); // เปลี่ยนชื่อฐานข้อมูลให้ตรง
if ($connect->connect_error) {
    die('เชื่อมต่อฐานข้อมูลไม่ได้: ' . $connect->connect_error);
}

$username = 'Doleiei';
$password = 'doldoldol';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

// ลบผู้ใช้นี้ถ้ามีอยู่ก่อน
$connect->query("DELETE FROM users WHERE username = '$username'");

$stmt = $connect->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "เพิ่มผู้ใช้สำเร็จ!";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}
?>