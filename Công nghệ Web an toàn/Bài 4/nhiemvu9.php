<?php
include "includes/header.php";

$file_path = "student_nv9.txt";
$upload_dir = "uploads/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Hàm đọc toàn bộ sinh viên từ file
function getAllStudents($path) {
    $students = [];
    if (!file_exists($path)) return $students;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode("|", trim($line));   //explode là hàm tách chuỗi
        if (count($parts) >= 6) {
            $students[] = [
                'id' => $parts[0],
                'name' => $parts[1],
                'birthday' => $parts[2],
                'address' => $parts[3],
                'image' => $parts[4],
                'class' => $parts[5]
            ];
        }
    }
    return $students;
}

// Hàm ghi danh sách sinh viên vào file
function saveAllStudents($path, $students) {
    $content = "";
    foreach ($students as $st) {
        $content .= implode("|", [
            $st['id'],
            $st['name'],
            $st['birthday'],
            $st['address'],
            $st['image'],
            $st['class']
        ]) . "\n";
    }
    file_put_contents($path, trim($content));
}

$subpage = $_GET['subpage'] ?? 'home';
$msg = "";

// ==========================================
// XỬ LÝ ACTION: XÓA SINH VIÊN
// ==========================================
if ($subpage === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $students = getAllStudents($file_path);
    $new_students = [];
    foreach ($students as $st) {
        if ($st['id'] != $id) {
            $new_students[] = $st;
        }
    }
    saveAllStudents($file_path, $new_students);
    header("Location: nhiemvu9.php?subpage=list");
    exit();
}

// ==========================================
// XỬ LÝ ACTION: THÊM SINH VIÊN (ADD)
// ==========================================
if (isset($_POST['btnLuuAdd'])) {
    $name = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $class = trim($_POST['class'] ?? '');

    $image_name = "avatar.png"; // Mặc định nếu không up ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . "_" . uniqid() . "." . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
    }

    $students = getAllStudents($file_path);
    $new_id = 1;
    if (!empty($students)) {
        $last_st = end($students);
        $new_id = (int)$last_st['id'] + 1;
    }

    $students[] = [
        'id' => $new_id,
        'name' => $name,
        'birthday' => $birthday,
        'address' => $address,
        'image' => $image_name,
        'class' => $class
    ];

    saveAllStudents($file_path, $students);
    $msg = "<p style='color: green; font-weight: bold;'>✔️ Thêm sinh viên thành công!</p>";
}

// ==========================================
// XỬ LÝ ACTION: SỬA SINH VIÊN (EDIT)
// ==========================================
if (isset($_POST['btnLuuEdit'])) {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['fullname'] ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $image_old = $_POST['image_old'] ?? 'avatar.png';

    $image_name = $image_old;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . "_" . uniqid() . "." . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
    }

    $students = getAllStudents($file_path);
    foreach ($students as &$st) {
        if ($st['id'] == $id) {
            $st['name'] = $name;
            $st['birthday'] = $birthday;
            $st['address'] = $address;
            $st['image'] = $image_name;
            $st['class'] = $class;
            break;
        }
    }
    saveAllStudents($file_path, $students);
    $msg = "<p style='color: green; font-weight: bold;'>✔️ Cập nhật thông tin sinh viên thành công!</p>";
}
?>

<style>
.nv9-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv9-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv9-menu a:hover, .nv9-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv9-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}
.nv9-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 15px;
}
.nv9-table th, .nv9-table td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: center;
    vertical-align: middle;
}
.nv9-table th {
    background: #f0f0f0;
}
.nv9-avatar {
    width: 50px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 2px;
}
.nv9-btn {
    padding: 6px 16px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-decoration: none;
}
.nv9-btn:hover {
    background: #0b7dda;
}
.nv9-btn-gray {
    background: #777;
}
.nv9-btn-gray:hover {
    background: #555;
}
.nv9-form-table {
    margin: 10px auto;
    border-collapse: collapse;
}
.nv9-form-table td {
    padding: 8px;
}
.nv9-form-table input[type="text"],
.nv9-form-table input[type="date"] {
    width: 280px;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
</style>

<!-- Sub-menu điều hướng Nhiệm vụ 9 -->
<div class="nv9-menu">
    <a href="nhiemvu9.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu9.php?subpage=list" class="<?php echo ($subpage == 'list') ? 'active' : ''; ?>">List</a>
    <a href="nhiemvu9.php?subpage=add" class="<?php echo ($subpage == 'add') ? 'active' : ''; ?>">Add</a>
</div>

<div class="nv9-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. DANH SÁCH SINH VIÊN (LIST)
    // ----------------------------------------------------------------------
    case 'list':
        $students = getAllStudents($file_path);
        ?>
        <h3>Danh Sách Sinh Viên (Data Flow & Files)</h3>
        <table class="nv9-table">
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Địa chỉ</th>
                <th>Ảnh</th>
                <th>Lớp</th>
                <th>Thao tác</th>
            </tr>
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="7">Chưa có sinh viên nào trong danh sách.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $index => $st): ?>
                    <?php
                    // Ưu tiên hiển thị ảnh trong uploads/, nếu không có thì trỏ về img/avatar.png
                    $img_src = "uploads/" . $st['image'];
                    if (!file_exists($img_src)) {
                        $img_src = "img/" . $st['image'];
                        if (!file_exists($img_src)) {
                            $img_src = "img/avatar.png";
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><b><?php echo htmlspecialchars($st['name']); ?></b></td>
                        <td><?php echo htmlspecialchars($st['birthday']); ?></td>
                        <td><?php echo htmlspecialchars($st['address']); ?></td>
                        <td>
                            <img src="<?php echo $img_src; ?>" alt="Avatar" class="nv9-avatar">
                        </td>
                        <td><?php echo htmlspecialchars($st['class']); ?></td>
                        <td>
                            <a href="nhiemvu9.php?subpage=detail&id=<?php echo $st['id']; ?>" style="color: purple; text-decoration: none;">Detail</a> |
                            <a href="nhiemvu9.php?subpage=edit&id=<?php echo $st['id']; ?>" style="color: blue; text-decoration: none;">Edit</a> |
                            <a href="nhiemvu9.php?subpage=delete&id=<?php echo $st['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')" style="color: red; text-decoration: none;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 2. THÊM SINH VIÊN (ADD)
    // ----------------------------------------------------------------------
    case 'add':
        ?>
        <h3 style="text-align: center;">Thêm Sinh Viên Mới</h3>
        <div style="text-align: center;"><?php echo $msg; ?></div>
        <form method="POST" action="nhiemvu9.php?subpage=add" enctype="multipart/form-data">
            <table class="nv9-form-table">
                <tr>
                    <td style="width: 25%;">Full name:</td>
                    <td><input type="text" name="fullname" required></td>
                </tr>
                <tr>
                    <td>Birthday:</td>
                    <td><input type="date" name="birthday" value="2012-08-10" required></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input type="text" name="address" required></td>
                </tr>
                <tr>
                    <td>Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Class:</td>
                    <td><input type="text" name="class" value="class1" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="reset" value="Nhập lại" class="nv9-btn nv9-btn-gray">&nbsp;&nbsp;
                        <input type="submit" name="btnLuuAdd" value="Lưu" class="nv9-btn">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 3. CHI TIẾT SINH VIÊN (DETAIL)
    // ----------------------------------------------------------------------
    case 'detail':
        $id = $_GET['id'] ?? '';
        $students = getAllStudents($file_path);
        $found = null;
        foreach ($students as $st) {
            if ($st['id'] == $id) {
                $found = $st;
                break;
            }
        }

        if ($found):
            $img_src = "uploads/" . $found['image'];
            if (!file_exists($img_src)) {
                $img_src = "img/" . $found['image'];
                if (!file_exists($img_src)) {
                    $img_src = "img/avatar.png";
                }
            }
            ?>
            <h3>Chi Tiết Sinh Viên</h3>
            <div style="display: flex; gap: 30px; margin-top: 20px; align-items: flex-start;">
                <div>
                    <img src="<?php echo $img_src; ?>" alt="Avatar" style="width: 140px; height: 180px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="line-height: 2;">
                    <p><b>Họ và tên:</b> <?php echo htmlspecialchars($found['name']); ?></p>
                    <p><b>Ngày sinh:</b> <?php echo htmlspecialchars($found['birthday']); ?></p>
                    <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($found['address']); ?></p>
                    <p><b>Lớp:</b> <?php echo htmlspecialchars($found['class']); ?></p>
                    <br>
                    <a href="nhiemvu9.php?subpage=list" class="nv9-btn">&laquo; Quay lại danh sách</a>
                </div>
            </div>
        <?php else: ?>
            <p style="color: red;">Không tìm thấy sinh viên!</p>
            <a href="nhiemvu9.php?subpage=list" class="nv9-btn">&laquo; Quay lại danh sách</a>
        <?php endif;
        break;

    // ----------------------------------------------------------------------
    // 4. SỬA SINH VIÊN (EDIT)
    // ----------------------------------------------------------------------
    case 'edit':
        $id = $_GET['id'] ?? '';
        $students = getAllStudents($file_path);
        $found = null;
        foreach ($students as $st) {
            if ($st['id'] == $id) {
                $found = $st;
                break;
            }
        }

        if ($found):
            $img_src = "uploads/" . $found['image'];
            if (!file_exists($img_src)) {
                $img_src = "img/" . $found['image'];
                if (!file_exists($img_src)) {
                    $img_src = "img/avatar.png";
                }
            }
            ?>
            <h3 style="text-align: center;">Sửa Thông Tin Sinh Viên</h3>
            <div style="text-align: center;"><?php echo $msg; ?></div>
            <form method="POST" action="nhiemvu9.php?subpage=edit&id=<?php echo $found['id']; ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $found['id']; ?>">
                <input type="hidden" name="image_old" value="<?php echo $found['image']; ?>">

                <table class="nv9-form-table">
                    <tr>
                        <td style="width: 25%;">Full name:</td>
                        <td><input type="text" name="fullname" value="<?php echo htmlspecialchars($found['name']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Birthday:</td>
                        <td><input type="date" name="birthday" value="<?php echo htmlspecialchars($found['birthday']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><input type="text" name="address" value="<?php echo htmlspecialchars($found['address']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Image (ảnh cũ):</td>
                        <td>
                            <img src="<?php echo $img_src; ?>" alt="Avatar" style="width: 60px; height: 75px; object-fit: cover; border: 1px solid #ccc;"><br>
                            (upload ảnh mới): <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Class:</td>
                        <td><input type="text" name="class" value="<?php echo htmlspecialchars($found['class']); ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="button" value="Hủy" class="nv9-btn nv9-btn-gray" onclick="window.location.href='nhiemvu9.php?subpage=list'">&nbsp;&nbsp;
                            <input type="submit" name="btnLuuEdit" value="Lưu" class="nv9-btn">
                        </td>
                    </tr>
                </table>
            </form>
        <?php else: ?>
            <p style="color: red;">Không tìm thấy sinh viên để chỉnh sửa!</p>
            <a href="nhiemvu9.php?subpage=list" class="nv9-btn">&laquo; Quay lại danh sách</a>
        <?php endif;
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG HOME
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 9: Thao Tác File và Data Flow</h2>
        <div style="line-height: 1.8; margin-top: 15px;">
            <p><strong>Mục tiêu bài thực hành:</strong></p>
            <ul>
                <li>Nắm vững luồng dữ liệu (Data Flow) hoàn chỉnh trong ứng dụng web: <i>List &rarr; Detail &rarr; Add &rarr; Edit &rarr; Delete &rarr; Upload</i>[cite: 2].</li>
                <li>Lưu trữ bản ghi có cấu trúc nhiều trường thông tin trên một tệp văn bản bằng ký tự phân tách chuỗi (<code>|</code>) kết hợp các hàm <code>explode()</code> và <code>implode()</code>[cite: 2].</li>
                <li>Xử lý upload file ảnh đại diện vào thư mục <code>uploads/</code> và liên kết tên file vào trường dữ liệu tương ứng[cite: 2].</li>
            </ul>
            <p style="margin-top: 15px;">
                👉 Chọn tab <b>List</b> để theo dõi danh sách, chỉnh sửa hoặc xóa; chọn tab <b>Add</b> để tạo mới hồ sơ sinh viên[cite: 2].
            </p>
        </div>
        <?php
        break;
}
?>
</div>

<?php
include "includes/footer.php";
?>