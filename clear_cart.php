<?php
session_start();

// ล้างตะกร้า
unset($_SESSION['cart']);

// ส่งกลับไปหน้าเมนู
header("Location: index.php"); // หรือเปลี่ยนเป็นชื่อไฟล์หน้ารายการเมนูของคุณ
exit();
?>
