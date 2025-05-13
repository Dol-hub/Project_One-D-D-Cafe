<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('dbconn.php');
include('header.php');

$selectedCategory = $_GET['category'] ?? 'ทั้งหมด';
$searchKeyword = trim($_GET['search'] ?? '');
$categories = ['ทั้งหมด', 'กาแฟ', 'ชา', 'อิตาเลี่ยนโซดา', 'นม', 'เมนูปั่น', 'เมนูพิเศษ', 'เมนูปังเย็น'];
?>

<div class="outer-wrapper">
  <div class="container">
    <!-- โลโก้และชื่อร้าน -->
    <div class="text-center my-4">
        <img src="logo.jpg" alt="One D D Cafe Logo" width="200">
        <h1 id="main_title">☕ One D D Cafe 🍞</h1>
    </div>

    <div class="box1">
        <h2>เมนูทั้งหมด</h2>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">เพิ่มเมนูเครื่องดื่ม</button>
        <?php endif; ?>
    </div>

    <!-- ปุ่มกรองหมวดหมู่ -->
    <div class="mb-4 text-center">
        <?php foreach ($categories as $cat): ?>
            <a href="index.php<?= $cat !== 'ทั้งหมด' ? '?category=' . urlencode($cat) : '' ?>" 
               class="btn btn<?= $selectedCategory === $cat ? ' btn-dark' : ' btn-outline-dark' ?> m-1">
               <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- แบบฟอร์มค้นหา -->
    <div class="mb-4 text-center">
        <form method="GET" action="index.php" class="d-inline-flex">
            <?php if ($selectedCategory !== 'ทั้งหมด'): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($selectedCategory) ?>">
            <?php endif; ?>
            <input type="text" name="search" class="form-control me-2" placeholder="ค้นหาเมนู..." value="<?= htmlspecialchars($searchKeyword) ?>">
            <button type="submit" class="btn btn-outline-success">ค้นหา</button>
        </form>
    </div>

    <!-- ปุ่มออกจากระบบ -->
    <form action="logout.php" method="post" class="text-center mt-4">
        <button type="submit" class="btn btn-danger">ออกจากระบบ</button>
    </form>

    <table class="table table-hover table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>ชื่อเมนู</th>
                <th>หมวดหมู่</th>
                <th>ราคา (บาท)</th>
                <th>รูปภาพ</th>
                <?php if ($_SESSION['role'] !== 'admin'): ?>
                    <th>เพิ่มลงตะกร้า</th>
                <?php endif; ?>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($selectedCategory !== 'ทั้งหมด' && $searchKeyword !== '') {
                $stmt = $connect->prepare("SELECT * FROM menu WHERE category = ? AND name LIKE ?");
                $likeKeyword = "%{$searchKeyword}%";
                $stmt->bind_param("ss", $selectedCategory, $likeKeyword);
                $stmt->execute();
                $result = $stmt->get_result();
            } elseif ($selectedCategory !== 'ทั้งหมด') {
                $stmt = $connect->prepare("SELECT * FROM menu WHERE category = ?");
                $stmt->bind_param("s", $selectedCategory);
                $stmt->execute();
                $result = $stmt->get_result();
            } elseif ($searchKeyword !== '') {
                $stmt = $connect->prepare("SELECT * FROM menu WHERE name LIKE ?");
                $likeKeyword = "%{$searchKeyword}%";
                $stmt->bind_param("s", $likeKeyword);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = mysqli_query($connect, "SELECT * FROM menu");
            }

            while ($row = mysqli_fetch_assoc($result)):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= number_format($row['price'], 2) ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="100"
                             onerror="this.onerror=null;this.src='no-image.png';">
                    <?php else: ?>
                        ไม่มีรูป
                    <?php endif; ?>
                </td>

                <?php if ($_SESSION['role'] !== 'admin'): ?>
                    <td>
                        <form method="post" action="cart.php" class="d-inline">
                            <input type="hidden" name="menu_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($row['name']) ?>">
                            <input type="hidden" name="price" value="<?= $row['price'] ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">เพิ่มลงตะกร้า</button>
                        </form>
                    </td>
                <?php endif; ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td><a href="update_page.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">แก้ไข</a></td>
                    <td><a href="delete_page.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('แน่ใจว่าจะลบเมนูนี้?')">ลบ</a></td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
  </div>
</div>

<!-- Modal สำหรับเพิ่มเมนูเครื่องดื่ม -->
<div class="modal fade" id="exampleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="insert_data.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h1 class="modal-title fs-5">เพิ่มเมนูเครื่องดื่ม</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-2">
              <label>ชื่อเมนูเครื่องดื่ม</label>
              <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group mb-2">
              <label>หมวดหมู่</label>
              <select name="category" class="form-control" required>
                  <?php foreach (array_slice($categories, 1) as $cat): ?>
                      <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                  <?php endforeach; ?>
              </select>
          </div>
          <div class="form-group mb-2">
              <label>ราคา</label>
              <input type="number" step="0.01" name="price" class="form-control" required>
          </div>
          <div class="form-group mb-2">
              <label>รูปภาพ</label>
              <input type="file" name="image" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">เพิ่มเมนู</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
