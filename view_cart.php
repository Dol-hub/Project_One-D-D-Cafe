<?php
session_start();
include('header.php');
?>

<div class="container my-5">
    <h2 class="text-center">🛒 ตะกร้าสินค้า</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p class="text-center">ยังไม่มีรายการในตะกร้า</p>
        <div class="text-center mt-3">
            <a href="menu.php" class="btn btn-primary">← กลับไปเลือกสินค้า</a>
        </div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ชื่อเมนู</th>
                    <th>ราคา/หน่วย</th>
                    <th>จำนวน</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= number_format($item['price'], 2) ?> บาท</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($subtotal, 2) ?> บาท</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">รวมทั้งหมด</th>
                    <th><?= number_format($total, 2) ?> บาท</th>
                </tr>
            </tfoot>
        </table>

        <div class="text-center mt-4">
            <!-- ปุ่มกลับไปหน้าเมนู -->
            <a href="index.php" class="btn btn-secondary me-2">← กลับไปเลือกสินค้า</a>

            <!-- ปุ่มล้างตะกร้า -->
            <form method="post" action="clear_cart.php" style="display: inline;">
                <button type="submit" class="btn btn-danger me-2">🗑️ ยกเลิกออเดอร์</button>
            </form>

            <!-- ปุ่มยืนยันการสั่งซื้อ -->
            <form method="post" action="confirm_order.php" style="display: inline;">
                <button type="submit" class="btn btn-success">✅ ยืนยันการสั่งซื้อ</button>
            </form>
        </div>
    <?php endif; ?>
</div>
