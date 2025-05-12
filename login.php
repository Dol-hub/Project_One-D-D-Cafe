<?php
include('header.php');
include('dbconn.php');
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($username === 'Doleiei' && $password === 'doldoldol') {
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = 'Doleiei';
            $_SESSION['role'] = 'admin';
            header("Location: index.php");
            exit();
        } elseif ($username === 'customer' && $password === 'customerpass') {
            $_SESSION['user_id'] = 2;
            $_SESSION['username'] = 'customer';
            $_SESSION['role'] = 'customer';
            header("Location: index.php");
            exit();
        } else {
            $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #fef3dc; /* ครีมอ่อน */
            font-family: 'Prompt', sans-serif;
            height: 100vh;
        }

        .outer-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: #fff3cd; /* เหลืองนวล */
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 420px;
            text-align: center;
            border: 2px dashed #f8c291;
        }

        .brand-title {
            font-size: 2rem;
            font-weight: bold;
            color: #8B4513; /* น้ำตาลเข้ม */
            margin-bottom: 15px;
        }

        h2 {
            color: #d35400; /* ส้มเข้ม */
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ccc;
            padding: 12px;
            width: 100%;
            background-color: #fffefc;
            font-size: 1rem;
        }

        .btn {
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #8B4513; /* น้ำตาล */
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background-color: #a0522d;
        }

        .btn-secondary {
            background-color: #e67e22; /* ส้ม */
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #d35400;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        label {
            color: #5D4037;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="outer-wrapper">
        <div class="login-container">
            <!-- ชื่อร้าน -->
            <div class="brand-title">☕ One D D Cafe 🍞</div>

            <h2>🍰 เข้าสู่ระบบ 🍰</h2>

            <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
            </form>

            <form method="POST" action="">
                <input type="hidden" name="username" value="customer">
                <input type="hidden" name="password" value="customerpass">
                <button type="submit" class="btn btn-secondary">เข้าสู่ระบบในฐานะลูกค้า</button>
            </form>
        </div>
    </div>
</body>
</html>