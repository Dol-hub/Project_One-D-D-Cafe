<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $total = $_POST['total'];

    // ล้างตะกร้า
    unset($_SESSION['cart']);
}
?>

<h2>สรุปคำสั่งซื้อ</h2>
<p>ชื่อลูกค้า: <?= htmlspecialchars($fname) ?> <?= htmlspecialchars($lname) ?></p>
<p>ที่อยู่: <?= nl2br(htmlspecialchars($address)) ?></p>
<p>ยอดรวม: <?= number_format($total, 2) ?> บาท</p>

<h3>QR Code สำหรับชำระเงิน</h3>
<img src="https://promptpay.io/0987654321/<?= $total ?>" alt="QR Code" width="250">
<p>กรุณาสแกนเพื่อชำระเงิน</p>
