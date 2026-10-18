<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'home';

// 1. Xử lý LOGOUT
if ($page === 'logout') {
    unset($_SESSION["Username"]);
    unset($_SESSION["Password"]);
    header("location: ../nhiemvu6.php?page=login");
    exit();
}

// 2. Xử lý THÊM LINK MỚI VÀO COOKIE
$cookie_links_raw = $_COOKIE["FavLinks"] ?? "";
$link_list = array_filter(explode("|", $cookie_links_raw));

if (isset($_POST["btnAddLink"])) {
    $new_title = trim($_POST["title"] ?? "");
    $new_url = trim($_POST["url"] ?? "");

    if (!empty($new_title) && !empty($new_url)) {
        // Lưu theo định dạng: Title^URL
        $link_item = $new_title . "^" . $new_url;
        $link_list[] = $link_item;
        
        // Cập nhật lại cookie (thời hạn 30 ngày)
        $new_cookie_val = implode("|", $link_list);
        setcookie("FavLinks", $new_cookie_val, time() + (30 * 24 * 60 * 60), "/");
        
        header("location: nhiemvu6.php?page=weblinks");
        exit();
    }
}

// Xử lý XÓA toàn bộ danh sách Favourite links
if (isset($_GET["action"]) && $_GET["action"] === "clearlinks") {
    setcookie("FavLinks", "", time() - 3600, "/");
    header("location: nhiemvu6.php?page=weblinks");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khu vực Quản trị - Nhiệm vụ 6 (Cookie)</title>
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
        .admin-nav a:hover, .admin-nav a.active {
            background-color: #34495e;
            border-radius: 3px;
        }
        .admin-content {
            background: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            min-height: 280px;
            border-radius: 4px;
        }
        .fav-list {
            margin: 15px 0;
            padding-left: 20px;
        }
        .fav-list li {
            margin-bottom: 8px;
        }
        .fav-list a {
            color: #0066cc;
            font-weight: bold;
            text-decoration: none;
        }
        .fav-list a:hover {
            text-decoration: underline;
        }
        .form-add-link input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 250px;
        }
        .form-add-link input[type="submit"] {
            padding: 6px 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .form-add-link input[type="submit"]:hover {
            background: #219150;
        }
    </style>
</head>
<body style="padding: 20px; background: #f4f4f4; font-family: Arial, sans-serif;">

<div style="max-width: 900px; margin: 0 auto;">
    <div class="admin-nav">
        <a href="../nhiemvu6.php?page=home">Return Home</a>
        <a href="nhiemvu6.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Admin Home</a>
        <a href="nhiemvu6.php?page=weblinks" class="<?php echo ($page == 'weblinks') ? 'active' : ''; ?>">Favourite Links (Cookie)</a>
        <a href="nhiemvu6.php?page=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Logout</a>
    </div>

    <div class="admin-content">
        <?php
        // KIỂM TRA QUYỀN TRUY CẬP: Nếu chưa có session Username thì chặn
        if (!isset($_SESSION["Username"])) {
            echo "<h3 style='color: red; text-align: center;'>Chưa đăng nhập</h3>";
            echo "<p style='text-align: center;'>Bạn không có quyền truy cập khu vực này. Vui lòng đăng nhập trước.</p>";
            echo "<div style='text-align: center; margin-top: 15px;'><a href='../nhiemvu6.php?page=login' style='color: #2196F3; font-weight: bold;'>Đến trang đăng nhập</a></div>";
        } else {
            switch ($page) {
                // Trang quản lý Favourite Web Links từ Cookie
                case 'weblinks':
                    ?>
                    <h3>Danh Sách Web Links Ưa Thích (Lưu trữ trong Cookie)</h3>
                    <p><i>Các liên kết dưới đây được đọc từ Cookie máy Client. Dữ liệu vẫn được giữ nguyên khi tắt trình duyệt.</i></p>

                    <h4>Các liên kết hiện có:</h4>
                    <?php if (empty($link_list)): ?>
                        <p style="color: #888;">Chưa có link nào trong danh sách Cookie. Vui lòng thêm link bên dưới.</p>
                    <?php else: ?>
                        <ul class="fav-list">
                            <?php foreach ($link_list as $item): ?>
                                <?php
                                $parts = explode("^", $item);
                                $title = $parts[0] ?? "";
                                $url = $parts[1] ?? "#";
                                ?>
                                <li>
                                    <a href="<?php echo htmlspecialchars($url); ?>" target="_blank">🌐 <?php echo htmlspecialchars($title); ?></a>
                                    <span style="color: #777; font-size: 13px;">(<?php echo htmlspecialchars($url); ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p><a href="nhiemvu6.php?action=clearlinks" onclick="return confirm('Xóa sạch danh sách link đã lưu trong Cookie?')" style="color: red; font-size: 13px;">[Xóa tất cả Links trong Cookie]</a></p>
                    <?php endif; ?>

                    <hr style="margin: 20px 0;">

                    <h4>Thêm liên kết mới vào Cookie:</h4>
                    <form method="POST" action="nhiemvu6.php?page=weblinks" class="form-add-link">
                        <table cellpadding="6">
                            <tr>
                                <td>Tiêu đề trang:</td>
                                <td><input type="text" name="title" placeholder="Ví dụ: Google" required></td>
                            </tr>
                            <tr>
                                <td>Địa chỉ URL:</td>
                                <td><input type="text" name="url" placeholder="https://google.com" required></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="btnAddLink" value="Thêm Link Vào Cookie"></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    break;

                // Trang Admin Home
                case 'home':
                default:
                    ?>
                    <h3>Khu vực Quản trị - Nhiệm vụ 6</h3>
                    <p><b>Tên đăng nhập:</b> <?php echo htmlspecialchars($_SESSION["Username"]); ?></p>
                    <p><b>Mật khẩu:</b> <?php echo htmlspecialchars($_SESSION["Password"]); ?></p>
                    <p><b>Cookie đã lưu trên máy:</b></p>
                    <ul>
                        <li><b>SavedUser:</b> <?php echo htmlspecialchars($_COOKIE["SavedUser"] ?? "Chưa lưu"); ?></li>
                        <li><b>SavedPass:</b> <?php echo htmlspecialchars($_COOKIE["SavedPass"] ?? "Chưa lưu"); ?></li>
                        <li><b>FavLinks:</b> <?php echo htmlspecialchars($_COOKIE["FavLinks"] ?? "Chưa có link"); ?></li>
                    </ul>
                    <?php
                    break;
            }
        }
        ?>
    </div>
</div>

</body>
</html>