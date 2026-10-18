<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'home';

// Xử lý Logout: Hủy session và chuyển về trang login ngoài
if ($page === 'logout') {
    unset($_SESSION["Username"]);
    unset($_SESSION["Password"]);
    header("location: ../nhiemvu5.php?page=login");
    exit();
}

// Xử lý upload file nếu submit ở trang upload
$upload_msg = "";
if (isset($_POST["btnUpload"]) && isset($_FILES["file1"])) {
    $folder = "../uploads/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
    $name = basename($_FILES["file1"]["name"]);
    if (!empty($name)) {
        $path = $folder . $name;
        if (move_uploaded_file($_FILES["file1"]["tmp_name"], $path)) {
            $upload_msg = "<p style='color:green;'>✔️ Tải file thành công: <a href='$path' download>$name</a></p>";
        } else {
            $upload_msg = "<p style='color:red;'>❌ Tải file thất bại!</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khu vực Quản trị - Nhiệm vụ 5</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-nav {
            background-color: #2c3e50;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .admin-nav a {
            color: #fff;
            text-decoration: none;
            padding: 8px 14px;
            font-weight: bold;
            display: inline-block;
        }
        .admin-nav a:hover {
            background-color: #34495e;
            border-radius: 3px;
        }
        .admin-content {
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 250px;
            border-radius: 4px;
        }
    </style>
</head>
<body style="padding: 20px; background: #f4f4f4; font-family: Arial, sans-serif;">

<div style="max-width: 900px; margin: 0 auto;">
    <div class="admin-nav">
        <a href="../nhiemvu5.php?page=home">Return Home</a>
        <a href="nhiemvu5.php?page=home">Admin Home</a>
        <a href="nhiemvu5.php?page=upload">Upload</a>
        <a href="nhiemvu5.php?page=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Logout</a>
    </div>

    <div class="admin-content">
        <?php
        // KIỂM TRA QUYỀN TRUY CẬP: Nếu chưa có session Username thì chặn
        if (!isset($_SESSION["Username"])) {
            echo "<h3 style='color: red; text-align: center;'>Chưa đăng nhập</h3>";
            echo "<p style='text-align: center;'>Bạn không có quyền truy cập khu vực này. Vui lòng quay lại đăng nhập.</p>";
            echo "<div style='text-align: center; margin-top: 15px;'><a href='../nhiemvu5.php?page=login' style='color: #2196F3; font-weight: bold;'>Đến trang đăng nhập</a></div>";
        } else {
            // Khi đã đăng nhập hợp lệ
            switch ($page) {
                case 'upload':
                    ?>
                    <h3>Trang upload Files (Admin)</h3>
                    <?php echo $upload_msg; ?>
                    <form method="POST" action="nhiemvu5.php?page=upload" enctype="multipart/form-data">
                        <table cellpadding="6">
                            <tr>
                                <td>Chọn file:</td>
                                <td><input type="file" name="file1" required></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset">&nbsp;&nbsp;
                                    <input type="submit" name="btnUpload" value="Upload">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    break;

                case 'home':
                default:
                    ?>
                    <h3>Khu vực Quản trị (Admin Home)</h3>
                    <p><b>Tên đăng nhập:</b> <?php echo htmlspecialchars($_SESSION["Username"]); ?></p>
                    <p><b>Mật khẩu:</b> <?php echo htmlspecialchars($_SESSION["Password"]); ?></p>
                    <p style="color: green;">Phiên làm việc hợp lệ. Dữ liệu được duy trì qua biến Session.</p>
                    <?php
                    break;
            }
        }
        ?>
    </div>
</div>

</body>
</html>