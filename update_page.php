<?php
include('header.php');
include('dbconn.php');

// ตรวจสอบว่าได้รับ id หรือไม่จาก URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ดึงข้อมูลเมนูจากฐานข้อมูล
    $query = "SELECT * FROM menu WHERE id = '$id'";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connect));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
} else {
    die("No menu ID provided");
}

// ตรวจสอบว่าได้รับการส่งข้อมูลจากฟอร์มหรือไม่
if (isset($_POST['update_menu'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $price = $_POST['price'];
    $comment = mysqli_real_escape_string($connect, $_POST['comment']);

    // อัปโหลดรูปภาพใหม่หากมีการเลือกไฟล์
    if ($_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTemp = $_FILES['image']['tmp_name'];
        $uploadDir = 'uploads/';
        $fileExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newImageName = uniqid('img_', true) . '.' . $fileExtension;
            $imagePath = $newImageName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            move_uploaded_file($imageTemp, $uploadDir . $newImageName);
        } else {
            die("Invalid image file type.");
        }
    } else {
        $imagePath = $row['image']; // ใช้รูปเดิมถ้าไม่อัปโหลดใหม่
    }

    // SQL สำหรับการอัปเดตเมนู
    $query = "UPDATE menu SET name = '$name', category = '$category', price = '$price', image = '$imagePath', comment = '$comment' WHERE id = '$id'";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connect));
    } else {
        header('Location: index.php?update_msg=Menu Updated Successfully');
        exit();
    }
}
?>

<!-- ฟอร์มอัปเดตเมนู -->
<form action="update_page.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($row['category']); ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($row['price']); ?>" required>
    </div>

    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea name="comment" class="form-control" rows="4"><?php echo htmlspecialchars($row['comment']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control">
        <small>Current Image: <?php echo htmlspecialchars($row['image']); ?></small><br>
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="150">
    </div>

    <input type="submit" class="btn btn-success" name="update_menu" value="Update Menu">
</form>

<?php
include('footer.php');
?>
