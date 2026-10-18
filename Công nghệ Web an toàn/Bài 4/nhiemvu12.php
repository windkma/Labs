<?php
// Nạp file kết nối Database
$pageTitle = 'Nhiệm vụ 12 - Truy vấn dữ liệu';
$pageClass = 'task-12';
require_once "libs/connectDB_nv12.php";

include "includes/header.php";

$subpage = $_GET['subpage'] ?? 'listClass';
$selected_class = $_GET['classID'] ?? '';
?>

<style>
.nv12-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv12-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv12-menu a:hover, .nv12-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv12-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
    min-height: 280px;
}
.nv12-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 15px;
}
.nv12-table th, .nv12-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
.nv12-table th {
    background: #f0f0f0;
}
.class-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 15px;
}
.class-col {
    flex: 1;
    min-width: 220px;
    background: #fff;
    border: 1px solid #e0e0e0;
    padding: 15px;
    border-radius: 4px;
}
.class-link {
    color: #0066cc;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
    margin: 4px 0;
}
.class-link:hover {
    text-decoration: underline;
}
.nv12-btn {
    padding: 6px 14px;
    background: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    font-size: 13px;
    display: inline-block;
}
.nv12-btn:hover {
    background: #1971ba;
}
</style>

<!-- Thanh điều hướng phụ của Nhiệm vụ 12 -->
<div class="nv12-menu">
    <a href="nhiemvu12.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu12.php?subpage=listClass" class="<?php echo ($subpage == 'listClass') ? 'active' : ''; ?>">Danh Sách Các Lớp</a>
    <?php if (!empty($selected_class)): ?>
        <a href="nhiemvu12.php?subpage=studentsInClass&classID=<?php echo urlencode($selected_class); ?>" class="<?php echo ($subpage == 'studentsInClass') ? 'active' : ''; ?>">Sinh Viên Lớp <?php echo htmlspecialchars($selected_class); ?></a>
    <?php endif; ?>
</div>

<div class="nv12-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. DANH SÁCH CÁC LỚP BẰNG 3 CÁCH FETCH (ListClass.php)
    // ----------------------------------------------------------------------
    case 'listClass':
        $query = "SELECT ID, ClassName FROM classes";
        ?>
        <h3>Danh sách các lớp học (Querying Data from Database)</h3>
        <p><i>(Nhấp chọn vào tên lớp để tải danh sách sinh viên của lớp đó theo phương thức GET qua biến <code>?classID=...</code>)</i></p>

        <div class="class-container">
            <!-- Cách 1: mysqli_fetch_row (theo chỉ số cột 0, 1) -->
            <div class="class-col">
                <h4 style="color: #d32f2f; margin-bottom: 10px;">Danh sách các lớp (cách 1):</h4>
                <p style="font-size: 12px; color: #666; margin-bottom: 8px;"><i>mysqli_fetch_row: $row[0]</i></p>
                <?php
                $result1 = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_row($result1)) {
                    $maLop = $row[0];
                    $tenLop = $row[1];
                    echo "<a class='class-link' href='nhiemvu12.php?subpage=studentsInClass&classID=" . urlencode($maLop) . "'>📁 $tenLop</a><br>";
                }
                ?>
            </div>

            <!-- Cách 2: mysqli_fetch_array (theo chỉ mục hoặc tên trường) -->
            <div class="class-col">
                <h4 style="color: #1976d2; margin-bottom: 10px;">Danh sách các lớp (cách 2):</h4>
                <p style="font-size: 12px; color: #666; margin-bottom: 8px;"><i>mysqli_fetch_array: $row[0], $row[1]</i></p>
                <?php
                $result2 = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result2)) {
                    $maLop = $row[0];
                    $tenLop = $row[1];
                    echo "<a class='class-link' href='nhiemvu12.php?subpage=studentsInClass&classID=" . urlencode($maLop) . "'>📁 $tenLop</a><br>";
                }
                ?>
            </div>

            <!-- Cách 3: mysqli_fetch_assoc (theo mảng kết hợp tên trường) -->
            <div class="class-col">
                <h4 style="color: #388e3c; margin-bottom: 10px;">Danh sách các lớp (cách 3):</h4>
                <p style="font-size: 12px; color: #666; margin-bottom: 8px;"><i>mysqli_fetch_assoc: $row["ID"]</i></p>
                <?php
                $result3 = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result3)) {
                    $maLop = $row["ID"];
                    $tenLop = $row["ClassName"];
                    echo "<a class='class-link' href='nhiemvu12.php?subpage=studentsInClass&classID=" . urlencode($maLop) . "'>📁 $tenLop</a><br>";
                }
                ?>
            </div>
        </div>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 2. DANH SÁCH SINH VIÊN TRONG LỚP (ListStudentInClass.php)
    // ----------------------------------------------------------------------
    case 'studentsInClass':
        $classID = mysqli_real_escape_string($conn, $_GET['classID'] ?? '');

        // Lấy thông tin lớp
        $rs_c = mysqli_query($conn, "SELECT ClassName FROM classes WHERE ID = '$classID'");
        $class_info = mysqli_fetch_assoc($rs_c);
        $className = $class_info['ClassName'] ?? $classID;

        // Truy vấn danh sách sinh viên theo mã lớp
        $sql_st = "SELECT * FROM students WHERE ClassID = '$classID'";
        $rs_st = mysqli_query($conn, $sql_st);
        ?>
        <h3>DANH SÁCH SINH VIÊN TRONG LỚP: <span style="color: #0b7dda;"><?php echo htmlspecialchars($className); ?></span></h3>
        
        <table class="nv12-table">
            <tr>
                <th style="width: 35%;">Tên</th>
                <th style="width: 30%;">Địa chỉ</th>
                <th style="width: 15%;">Giới tính</th>
                <th style="width: 20%; text-align: center;">Thao tác</th>
            </tr>
            <?php
            if (mysqli_num_rows($rs_st) > 0) {
                while ($st = mysqli_fetch_assoc($rs_st)) {
                    echo "<tr>";
                    echo "<td><b>" . htmlspecialchars($st['StudentName']) . "</b></td>";
                    echo "<td>" . htmlspecialchars($st['StudentAddress']) . "</td>";
                    echo "<td>" . htmlspecialchars($st['StudentGender']) . "</td>";
                    echo "<td style='text-align: center;'>
                            <a class='nv12-btn' href='nhiemvu12.php?subpage=detail&id=" . $st['ID'] . "&classID=" . urlencode($classID) . "'>Chi tiết</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; color: #888;'>Lớp này hiện chưa có sinh viên nào.</td></tr>";
            }
            ?>
        </table>

        <div style="margin-top: 20px;">
            <a href="nhiemvu12.php?subpage=listClass" class="nv12-btn" style="background: #777;">&laquo; Quay lại danh sách lớp</a>
        </div>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 3. CHI TIẾT SINH VIÊN (StudentDetail.php)
    // ----------------------------------------------------------------------
    case 'detail':
        $st_id = (int)($_GET['id'] ?? 0);
        $sql_detail = "SELECT s.*, c.ClassName 
                       FROM students s 
                       LEFT JOIN classes c ON s.ClassID = c.ID 
                       WHERE s.ID = $st_id";
        $rs_detail = mysqli_query($conn, $sql_detail);
        $student = mysqli_fetch_assoc($rs_detail);

        if ($student):
            $img_path = "img/" . $student['StudentImage'];
            if (!file_exists($img_path)) {
                $img_path = "img/avatar.png";
            }
            ?>
            <h3>Chi Tiết Sinh Viên</h3>
            <div style="display: flex; gap: 30px; margin-top: 20px; align-items: flex-start;">
                <div>
                    <img src="<?php echo $img_path; ?>" alt="Avatar" style="width: 130px; height: 160px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="line-height: 2; font-size: 15px;">
                    <p><b>Mã sinh viên:</b> <?php echo $student['ID']; ?></p>
                    <p><b>Họ và tên:</b> <?php echo htmlspecialchars($student['StudentName']); ?></p>
                    <p><b>Giới tính:</b> <?php echo htmlspecialchars($student['StudentGender']); ?></p>
                    <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($student['StudentAddress']); ?></p>
                    <p><b>Lớp:</b> <?php echo htmlspecialchars($student['ClassName']); ?> (Mã: <?php echo htmlspecialchars($student['ClassID']); ?>)</p>
                    <br>
                    <a href="nhiemvu12.php?subpage=studentsInClass&classID=<?php echo urlencode($student['ClassID']); ?>" class="nv12-btn">&laquo; Quay lại danh sách lớp</a>
                </div>
            </div>
        <?php else: ?>
            <p style="color: red;">Không tìm thấy thông tin sinh viên!</p>
            <a href="nhiemvu12.php?subpage=listClass" class="nv12-btn">&laquo; Quay lại danh sách lớp</a>
        <?php endif;
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG CHỦ (HOME)
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 12: Truy Vấn Dữ Liệu</h2>
        <div style="line-height: 1.8; margin-top: 15px;">
            <p><strong>Nội dung bài thực hành:</strong></p>
            <ul>
                <li>Quy trình 4 bước: <code>1. Connect &rarr; 2. Query &rarr; 3. Tổ chức hiển thị kết quả &rarr; 4. Đóng kết nối</code>[cite: 2].</li>
                <li>Thực hành 3 phương thức duyệt kết quả bản ghi:
                    <ul>
                        <li><code>mysqli_fetch_row()</code>: Duyệt mảng tuần tự theo chỉ số số nguyên[cite: 2].</li>
                        <li><code>mysqli_fetch_array()</code>: Duyệt mảng kết hợp chỉ số số nguyên hoặc tên cột[cite: 2].</li>
                        <li><code>mysqli_fetch_assoc()</code>: Duyệt mảng liên kết theo tên trường[cite: 2].</li>
                    </ul>
                </li>
                <li>Truyền tham số <code>classID</code> qua URL bằng phương thức <code>GET</code> để lọc sinh viên theo từng lớp học tương ứng[cite: 2].</li>
            </ul>
            <p style="margin-top: 15px;">
                👉 Nhấp vào <a href="nhiemvu12.php?subpage=listClass" style="color: #2196F3; font-weight: bold;">Danh Sách Các Lớp</a> để bắt đầu truy vấn[cite: 2].
            </p>
        </div>
        <?php
        break;
}

// Đóng kết nối CSDL theo đúng tiến trình bài học
mysqli_close($conn);
?>
</div>

<?php
include "includes/footer.php";
?>
