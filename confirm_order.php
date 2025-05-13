<?php
session_start();
include('header.php');

// ถ้าไม่มีข้อมูลตะกร้า กลับไปยังหน้าหลัก
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

// เก็บข้อมูลคำสั่งซื้อก่อนล้าง cart
$orderDetails = $_SESSION['cart'];
$orderTotal = 0;
foreach ($orderDetails as $item) {
    $orderTotal += $item['price'] * $item['quantity'];
}

// สร้างหมายเลขออเดอร์จำลอง
$orderID = rand(10000, 99999);

// ล้างข้อมูลตะกร้า
unset($_SESSION['cart']);
?>

<div class="container my-5" style="max-width: 800px;">
    <h2 class="text-center mb-4" style="font-size: 2.5rem; color: #4e342e;">🎉 ขอบคุณสำหรับการสั่งซื้อ!</h2>
    <p class="text-center" style="font-size: 1.2rem; color: #6d4c41;">การสั่งซื้อของคุณได้รับการยืนยันแล้ว</p>
    
    <h4 class="mt-4 text-center" style="font-size: 1.5rem; color: #4e342e;">รายละเอียดการสั่งซื้อ</h4>
    <table class="table table-bordered mt-3">
        <thead style="background-color: #a1887f; color: white;">
            <tr>
                <th class="text-center">ชื่อเมนู</th>
                <th class="text-center">ราคา/หน่วย</th>
                <th class="text-center">จำนวน</th>
                <th class="text-center">ราคารวม</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails as $item): ?>
            <tr>
                <td class="text-center"><?= htmlspecialchars($item['name']) ?></td>
                <td class="text-center"><?= number_format($item['price'], 2) ?> บาท</td>
                <td class="text-center"><?= (int)$item['quantity'] ?></td>
                <td class="text-center"><?= number_format($item['price'] * $item['quantity'], 2) ?> บาท</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="text-center text-success mt-3">รวมทั้งหมด: <?= number_format($orderTotal, 2) ?> บาท</h4>
    <p class="text-center mt-3">หมายเลขคำสั่งซื้อของคุณคือ <strong>#<?= $orderID ?></strong></p>

    <div class="text-center my-4">
        <h5>กรุณาชำระเงินผ่าน QR Code</h5>
        <img src="qrcode.jpg" alt="QR Code" width="200" class="my-3">
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary px-5 py-2" style="font-size: 1.1rem; border-radius: 25px; background-color: #6d4c41; border: none;">กลับหน้าหลัก</a>
    </div>

    <p class="text-center mt-4" style="font-size: 1rem; color: #555;">
        หากมีข้อสงสัย สามารถติดต่อเราได้ที่ 
        <a href="mailto:contact@oneddcafe.com" style="color: #5d4037;">contact@oneddcafe.com</a>
    </p>
</div>
