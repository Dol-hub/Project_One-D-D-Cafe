<?php
session_start();
session_unset(); // ล้างข้อมูล session
session_destroy(); // ทำลาย session
header("Location: login.php"); // ส่งผู้ใช้ไปยังหน้าล็อกอิน
exit();
?>