<?php
$pageTitle = 'Nhiệm vụ 16 - Richtext box';
$pageClass = 'task-16';
require_once __DIR__ . '/includes/database.php';
$conn = connect_database('laptop_shop', 'sql/laptop_shop.sql');

$msg = "";

// Lưu sản phẩm có kèm Richtext box
if (isset($_POST['btnSaveProduct'])) {
    $name = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $price = (float)$_POST['price'];
    $description = $_POST['description']; // Nhận mã HTML từ CKEditor

    $sql = "INSERT INTO products (name, category_id, price, image, description) 
            VALUES ('$name', $category_id, $price, 'avatar.png', '$description')";
    if (mysqli_query($conn, $sql)) {
        $msg = "<p style='color:green; font-weight:bold;'>✔️ Thêm laptop thành công với mô tả định dạng phong phú!</p>";
    } else {
        $msg = "<p style='color:red;'>Lỗi: " . mysqli_error($conn) . "</p>";
    }
}

include "includes/header.php";
?>

<!-- Tích hợp CKEditor trực tiếp qua CDN chính thức -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<style>
.form-row { margin-bottom: 12px; }
.form-row label { display: block; font-weight: bold; margin-bottom: 4px; font-size: 13px; }
.form-row input[type="text"], .form-row input[type="number"], .form-row select { width: 100%; max-width: 380px; padding: 6px 8px; border: 1px solid #ccc; border-radius: 3px; }
.btn-save { padding: 8px 18px; background: #27ae60; color: white; border: none; border-radius: 3px; cursor: pointer; font-weight: bold; }
</style>

<h3>Nhiệm vụ 16: Tích Hợp Richtext Box (CKEditor) Cho Web Bán Laptop</h3>
<p><i>Trang thêm sản phẩm hỗ trợ định dạng văn bản nâng cao (In đậm, In nghiêng, Bảng, Căn lề...) qua thư viện CKEditor.</i></p>

<?php echo $msg; ?>

<div style="background: #fafafa; border: 1px solid #ddd; padding: 20px; border-radius: 4px; margin-top: 15px;">
    <form method="POST" action="nhiemvu16.php">
        <div class="form-row">
            <label>Tên Laptop:</label>
            <input type="text" name="name" placeholder="Ví dụ: Asus Zenbook 14 OLED..." required>
        </div>

        <div class="form-row">
            <label>Danh mục / Hãng sản xuất:</label>
            <select name="category_id">
                <?php
                $rs = mysqli_query($conn, "SELECT * FROM categories");
                while ($c = mysqli_fetch_assoc($rs)) {
                    echo "<option value='{$c['id']}'>{$c['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row">
            <label>Đơn giá (VNĐ):</label>
            <input type="number" name="price" value="15000000" required>
        </div>

        <div class="form-row">
            <label>Mô tả chi tiết sản phẩm (CKEditor):</label>
            <textarea name="description" id="product_desc" rows="10" cols="80">
                <p><strong>Cấu hình chi tiết:</strong></p>
                <ul>
                    <li>CPU: Intel Core i7</li>
                    <li>RAM: 16GB DDR5</li>
                    <li>Ổ cứng: SSD 512GB NVMe</li>
                </ul>
            </textarea>
        </div>

        <button type="submit" name="btnSaveProduct" class="btn-save">Lưu Sản Phẩm</button>
        <a href="nhiemvu13.php" style="margin-left: 10px; font-size: 13px;">Xem tại trang Bán hàng &raquo;</a>
    </form>
</div>

<script>
    // Kích hoạt CKEditor cho ô textarea id="product_desc"
    CKEDITOR.replace('product_desc');
</script>

<?php
mysqli_close($conn);
include "includes/footer.php";
?>
