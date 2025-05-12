<?php 
include('dbconn.php'); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM menu WHERE id = $id";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header('Location: index.php?delete_msg=ลบเมนูเรียบร้อยแล้ว');
    } else {
        die("Query failed: " . mysqli_error($connect));
    }
}
?>