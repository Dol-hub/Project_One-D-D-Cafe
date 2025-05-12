<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่าน
$dbname = "crud_student"; // ชื่อฐานข้อมูล

// เชื่อมต่อกับฐานข้อมูล
$connect = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>