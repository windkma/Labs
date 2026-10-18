<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msg = "";
// Xử lý đăng nhập
if (isset($_POST["btnDangNhap"])) {
    $name = $_POST["txtUsername"] ?? "";
    $pass = $_POST["txtPassword"] ?? "";

    if ($name === "admin" && $pass === "admin") {
        $_SESSION["Username"] = $name;
        $_SESSION["Password"] = $pass;

        // Chuyển hướng sang trang index trong thư mục admin đúng như giáo trình yêu cầu
        header("location: admin/nhiemvu5.php");
        exit();
    } else {
        $msg = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}

$page = $_GET['page'] ?? 'home';

include "includes/header.php";
?>

<div style="background-color: #333; padding: 8px 12px; margin-bottom: 20px; border-radius: 4px;">
    <a href="nhiemvu5.php?page=home" style="color: #fff; text-decoration: none; padding: 6px 12px; font-weight: bold;">Home</a>
    <a href="nhiemvu5.php?page=login" style="color: #fff; text-decoration: none; padding: 6px 12px; font-weight: bold;">Login</a>
</div>

<div style="background: #fafafa; border: 1px solid #ddd; padding: 25px; border-radius: 4px;">
<?php if ($page === 'login'): ?>
    <h3 style="text-align: center;">Đăng nhập</h3>
    <?php if ($msg): ?>
        <p style="color: red; text-align: center;"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" action="nhiemvu5.php?page=login">
        <table align="center" cellpadding="8">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="txtUsername" value="admin" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="txtPassword" value="admin" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="reset" value="Nhập Lại">&nbsp;&nbsp;
                    <input type="submit" name="btnDangNhap" value="Đăng Nhập">
                </td>
            </tr>
        </table>
    </form>
<?php else: ?>
    <h2>Trang Home (End User)</h2>
    <p>Session: Là 1 phiên làm việc của người dùng. Bắt đầu từ khi tiến trình client gửi request và kết nối đến web server, kết thúc khi ngắt kết nối (thường là đóng trình duyệt).</p>
    <p>Biến session: Lưu trữ thông tin trong 1 phiên làm việc của người dùng. Phạm vi nhận biết là toàn cục.</p>
    <p>👉 Vào menu <a href="nhiemvu5.php?page=login">Login</a> để đăng nhập với tài khoản <b>admin / admin</b>.</p>
<?php endif; ?>
</div>

<?php
include "includes/footer.php";
?>