<?php
$pageTitle = 'Nhiệm vụ 14 - Quản trị cửa hàng';
$pageClass = 'task-14';
require_once __DIR__ . '/includes/database.php';
$conn = connect_database('laptop_shop', 'sql/laptop_shop.sql');

$tab = $_GET['tab'] ?? 'users';
$action = $_GET['action'] ?? 'list';

// Xử lý Xóa User
if ($tab === 'users' && $action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    header("Location: nhiemvu14.php?tab=users");
    exit();
}

// Xử lý Thêm User
if (isset($_POST['btnSaveUser'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullname = trim($_POST['fullname']);
    $birthday = $_POST['birthday'];
    $address = trim($_POST['address']);
    mysqli_query($conn, "INSERT INTO users (username, password, fullname, birthday, address) VALUES ('$username', '$password', '$fullname', '$birthday', '$address')");
    header("Location: nhiemvu14.php?tab=users");
    exit();
}

// Xử lý Xóa Category
if ($tab === 'categories' && $action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    header("Location: nhiemvu14.php?tab=categories");
    exit();
}

// Xử lý Thêm Category
if (isset($_POST['btnSaveCat'])) {
    $cat_name = trim($_POST['cat_name']);
    if (!empty($cat_name)) {
        mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$cat_name')");
    }
    header("Location: nhiemvu14.php?tab=categories");
    exit();
}

include "includes/header.php";
?>

<style>
.admin-tab { display: flex; gap: 8px; margin-bottom: 15px; border-bottom: 2px solid #333; }
.admin-tab a { padding: 8px 14px; text-decoration: none; font-size: 13px; font-weight: bold; color: #333; border-radius: 3px 3px 0 0; }
.admin-tab a.active { background: #333; color: #fff; }
.admin-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 13px; }
.admin-table th, .admin-table td { border: 1px solid #ccc; padding: 6px 10px; }
.admin-table th { background: #eee; }
.btn-adm { padding: 4px 10px; background: #2196F3; color: white; text-decoration: none; border-radius: 3px; font-size: 12px; border: none; cursor: pointer; }
.btn-red { background: #d32f2f; }
.btn-green { background: #27ae60; }
</style>

<h3>Nhiệm vụ 14: Web Bán Laptop (End Administration)</h3>

<div class="admin-tab">
    <a href="nhiemvu14.php?tab=users" class="<?php echo ($tab == 'users') ? 'active' : ''; ?>">Quản lý Người dùng (Users)</a>
    <a href="nhiemvu14.php?tab=categories" class="<?php echo ($tab == 'categories') ? 'active' : ''; ?>">Quản lý Danh mục (Categories)</a>
    <a href="nhiemvu14.php?tab=products" class="<?php echo ($tab == 'products') ? 'active' : ''; ?>">Quản lý Sản phẩm (Products)</a>
</div>

<?php if ($tab === 'users'): ?>
    <?php if ($action === 'add'): ?>
        <h4>Thêm người dùng mới</h4>
        <form method="POST" action="nhiemvu14.php?tab=users">
            <table cellpadding="6">
                <tr><td>Username:</td><td><input type="text" name="username" required></td></tr>
                <tr><td>Password:</td><td><input type="password" name="password" required></td></tr>
                <tr><td>Fullname:</td><td><input type="text" name="fullname" required></td></tr>
                <tr><td>Birthday:</td><td><input type="date" name="birthday" value="2000-01-01" required></td></tr>
                <tr><td>Address:</td><td><input type="text" name="address" required></td></tr>
                <tr><td></td><td><button type="submit" name="btnSaveUser" class="btn-adm btn-green">Lưu</button> <a href="nhiemvu14.php?tab=users" class="btn-adm" style="background:#777;">Hủy</a></td></tr>
            </table>
        </form>
    <?php else: ?>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <b>Danh sách Users</b>
            <a href="nhiemvu14.php?tab=users&action=add" class="btn-adm btn-green">➕ Thêm User</a>
        </div>
        <table class="admin-table">
            <tr>
                <th>ID</th><th>Tài khoản</th><th>Họ tên</th><th>Ngày sinh</th><th>Địa chỉ</th><th>Thao tác</th>
            </tr>
            <?php
            $rs = mysqli_query($conn, "SELECT * FROM users");
            while ($u = mysqli_fetch_assoc($rs)):
            ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><b><?php echo htmlspecialchars($u['username']); ?></b></td>
                    <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                    <td><?php echo $u['birthday']; ?></td>
                    <td><?php echo htmlspecialchars($u['address']); ?></td>
                    <td><a href="nhiemvu14.php?tab=users&action=delete&id=<?php echo $u['id']; ?>" class="btn-adm btn-red" onclick="return confirm('Xóa người dùng này?')">Xóa</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

<?php elseif ($tab === 'categories'): ?>
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <b>Danh sách Danh mục Laptop</b>
    </div>
    <form method="POST" action="nhiemvu14.php?tab=categories" style="margin: 10px 0;">
        <input type="text" name="cat_name" placeholder="Tên hãng laptop mới..." required style="padding: 4px 8px;">
        <button type="submit" name="btnSaveCat" class="btn-adm btn-green">Thêm</button>
    </form>
    <table class="admin-table">
        <tr><th>ID</th><th>Tên Hãng</th><th>Thao tác</th></tr>
        <?php
        $rs = mysqli_query($conn, "SELECT * FROM categories");
        while ($c = mysqli_fetch_assoc($rs)):
        ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><b><?php echo htmlspecialchars($c['name']); ?></b></td>
                <td><a href="nhiemvu14.php?tab=categories&action=delete&id=<?php echo $c['id']; ?>" class="btn-adm btn-red" onclick="return confirm('Xóa danh mục này?')">Xóa</a></td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php elseif ($tab === 'products'): ?>
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <b>Danh sách Laptop trong hệ thống</b>
        <a href="nhiemvu16.php" class="btn-adm btn-green">➕ Thêm Laptop với CKEditor (Nhiệm vụ 16) &raquo;</a>
    </div>
    <table class="admin-table">
        <tr><th>ID</th><th>Tên Laptop</th><th>Hãng</th><th>Đơn giá</th></tr>
        <?php
        $rs = mysqli_query($conn, "SELECT p.*, c.name AS cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id");
        while ($p = mysqli_fetch_assoc($rs)):
        ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><b><?php echo htmlspecialchars($p['name']); ?></b></td>
                <td><?php echo htmlspecialchars($p['cat_name']); ?></td>
                <td style="color:#d32f2f; font-weight:bold;"><?php echo number_format($p['price'], 0, ',', '.'); ?> đ</td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<?php
mysqli_close($conn);
include "includes/footer.php";
?>
