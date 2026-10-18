<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msg = "";

// Xử lý submit Đăng nhập
if (isset($_POST["btnDangNhap"])) {
    $name = $_POST["txtUsername"] ?? "";
    $pass = $_POST["txtPassword"] ?? "";

    if ($name === "admin" && $pass === "admin") {
        // 1. Lưu Session phục vụ xác thực phiên làm việc
        $_SESSION["Username"] = $name;
        $_SESSION["Password"] = $pass;

        // 2. Lưu Cookie (thời hạn 30 ngày) để ghi nhớ cho lần sau
        $expire = time() + (30 * 24 * 60 * 60);
        setcookie("SavedUser", $name, $expire, "/");
        setcookie("SavedPass", $pass, $expire, "/");

        // Chuyển hướng sang trang quản trị của Nhiệm vụ 6
        header("location: admin/nhiemvu6.php");
        exit();
    } else {
        $msg = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}

// Lấy thông tin đã lưu trong Cookie (nếu có) để tự động điền vào Form
$cookie_user = $_COOKIE["SavedUser"] ?? "";
$cookie_pass = $_COOKIE["SavedPass"] ?? "";

$page = $_GET['page'] ?? 'home';

include "includes/header.php";
?>

<div style="background-color: #333; padding: 8px 12px; margin-bottom: 20px; border-radius: 4px;">
    <a href="nhiemvu6.php?page=home" style="color: #fff; text-decoration: none; padding: 6px 12px; font-weight: bold;">Home</a>
    <a href="nhiemvu6.php?page=login" style="color: #fff; text-decoration: none; padding: 6px 12px; font-weight: bold;">Login</a>
</div>

<div style="background: #fafafa; border: 1px solid #ddd; padding: 25px; border-radius: 4px;">
<?php if ($page === 'login'): ?>
    <h3 style="text-align: center;">Đăng Nhập</h3>
    <?php if ($msg): ?>
        <p style="color: red; text-align: center;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <?php if (!empty($cookie_user)): ?>
        <p style="text-align: center; color: green; font-size: 13px;">
            <i>(Dữ liệu Username và Password được tự động điền từ Cookie)</i>
        </p>
    <?php endif; ?>

    <form method="POST" action="nhiemvu6.php?page=login">
        <table align="center" cellpadding="8">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="txtUsername" value="<?php echo htmlspecialchars($cookie_user ?: 'admin'); ?>" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="txtPassword" value="<?php echo htmlspecialchars($cookie_pass ?: 'admin'); ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="reset" value="Nhập Lại">&nbsp;&nbsp;
                    <input type="submit" name="btnDangNhap" value="Đăng Nhập">
                </td>
            </tr>
        </table>
    </form>
    <p style="text-align: center; color: #666; font-size: 13px; margin-top: 10px;">
        <i>Tài khoản mẫu: <b>admin / admin</b>. Đăng nhập thành công sẽ ghi Cookie tồn tại 30 ngày.</i>
    </p>

<?php else: ?>
    <h2>Trang Home - Nhiệm vụ 6: Cookie</h2>
    <div style="line-height: 1.8; margin-top: 15px;">
        <p><strong>1. Khái niệm Cookie:</strong></p>
        <p>Cookie là một mẩu thông tin ngắn được máy chủ web gửi đến và lưu trữ trên máy Client (trình duyệt của người dùng). Trình duyệt sẽ tự động gửi kèm cookie ngược lên server trong mỗi lượt HTTP Request tiếp theo.</p>

        <p style="margin-top: 10px;"><strong>2. Đặc điểm và ứng dụng:</strong></p>
        <ul>
            <li>Không nên lưu trữ dữ liệu nhạy cảm chưa mã hóa vào Cookie vì có thể bị can thiệp ở phía Client.</li>
            <li>Thường dùng để: Ghi nhớ thông tin đăng nhập (Remember me), thời điểm truy cập gần nhất, lưu giỏ hàng tạm, hoặc danh sách liên kết ưa thích (Favourite Links).</li>
            <li>Tạo cookie: <code>setcookie("ten_cookie", "gia_tri", time() + thoi_gian_song);</code>.</li>
            <li>Truy xuất cookie: Mảng siêu toàn cục <code>$_COOKIE["ten_cookie"]</code>.</li>
            <li>Xóa cookie: Thiết lập thời điểm hết hạn về quá khứ (ví dụ: <code>time() - 3600</code>).</li>
        </ul>

        <p style="margin-top: 15px;">
            👉 Vào menu <a href="nhiemvu6.php?page=login" style="color: #2196F3; font-weight: bold;">Login</a> để trải nghiệm chức năng ghi nhớ đăng nhập và chuyển hướng sang phân vùng quản trị.
        </p>
    </div>
<?php endif; ?>
</div>

<?php
include "includes/footer.php";
?>