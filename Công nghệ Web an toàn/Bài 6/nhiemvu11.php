<?php
$pageTitle = 'Nhiệm vụ 11 - CRUD cơ sở dữ liệu';
$pageClass = 'task-11';
require_once __DIR__ . '/includes/database.php';
$conn = connect_database('quanlyhocsinh', 'sql/nhiemvu11.sql');

$subpage = $_GET['subpage'] ?? 'home';
$msg = "";

// =========================================================================
// XỬ LÝ ACTIONS BẢNG LOP (THÊM / SỬA / XÓA)
// =========================================================================
if ($subpage === 'lop_delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);   //filter dữ liệu từ url
    $sql_del = "DELETE FROM LOP WHERE MALOP = '$id'";
    if (mysqli_query($conn, $sql_del)) {
        header("Location: nhiemvu11.php?subpage=lop_list");
        exit();
    } else {
        $msg = "<p style='color:red;'>Lỗi khi xóa lớp: " . mysqli_error($conn) . "</p>";
    }
}

if (isset($_POST['btnLuuLop'])) {
    $malop = trim($_POST['malop']);
    $tenlop = trim($_POST['tenlop']);
    $khoahoc = (int)$_POST['khoahoc'];
    $gvcn = trim($_POST['gvcn']);
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';

    if ($is_edit) {
        $sql = "UPDATE LOP SET TENLOP='$tenlop', KHOAHOC=$khoahoc, GVCN='$gvcn' WHERE MALOP='$malop'";
    } else {
        $sql = "INSERT INTO LOP (MALOP, TENLOP, KHOAHOC, GVCN) VALUES ('$malop', '$tenlop', $khoahoc, '$gvcn')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: nhiemvu11.php?subpage=lop_list");
        exit();
    } else {
        $msg = "<p style='color:red;'>Lỗi: " . mysqli_error($conn) . "</p>";
    }
}

// =========================================================================
// XỬ LÝ ACTIONS BẢNG HOSO (THÊM / SỬA / XÓA)
// =========================================================================
if ($subpage === 'hoso_delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_del = "DELETE FROM HOSO WHERE MAHS = '$id'";
    if (mysqli_query($conn, $sql_del)) {
        header("Location: nhiemvu11.php?subpage=hoso_list");
        exit();
    } else {
        $msg = "<p style='color:red;'>Lỗi khi xóa hồ sơ: " . mysqli_error($conn) . "</p>";
    }
}

if (isset($_POST['btnLuuHoSo'])) {
    $mahs = trim($_POST['mahs']);
    $hoten = trim($_POST['hoten']);
    $ngaysinh = $_POST['ngaysinh'];
    $diachi = trim($_POST['diachi']);
    $lop = trim($_POST['lop']);
    $dtoan = (float)$_POST['diemtoan'];
    $dly = (float)$_POST['diemly'];
    $dhoa = (float)$_POST['diemhoa'];
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] == '1';

    if ($is_edit) {
        $sql = "UPDATE HOSO SET HOTEN='$hoten', NGAYSINH='$ngaysinh', DIACHI='$diachi', LOP='$lop', 
                DIEMTOAN=$dtoan, DIEMLY=$dly, DIEMHOA=$dhoa WHERE MAHS='$mahs'";
    } else {
        $sql = "INSERT INTO HOSO (MAHS, HOTEN, NGAYSINH, DIACHI, LOP, DIEMTOAN, DIEMLY, DIEMHOA) 
                VALUES ('$mahs', '$hoten', '$ngaysinh', '$diachi', '$lop', $dtoan, $dly, $dhoa)";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: nhiemvu11.php?subpage=hoso_list");
        exit();
    } else {
        $msg = "<p style='color:red;'>Lỗi: " . mysqli_error($conn) . "</p>";
    }
}

include "includes/header.php";
?>

<style>
.nv11-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv11-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv11-menu a:hover, .nv11-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv11-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
    min-height: 280px;
}
.nv11-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 15px;
}
.nv11-table th, .nv11-table td {
    border: 1px solid #ccc;
    padding: 8px 10px;
    text-align: left;
}
.nv11-table th {
    background: #f0f0f0;
}
.nv11-btn {
    padding: 6px 14px;
    background: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    font-size: 13px;
    display: inline-block;
    border: none;
    cursor: pointer;
}
.nv11-btn:hover {
    background: #0b7dda;
}
.nv11-btn-gray {
    background: #777;
}
.nv11-btn-gray:hover {
    background: #555;
}
.nv11-pagination {
    margin-top: 18px;
    text-align: center;
}
.nv11-pagination a {
    padding: 5px 10px;
    border: 1px solid #ccc;
    color: #333;
    text-decoration: none;
    margin: 0 2px;
    border-radius: 3px;
}
.nv11-pagination a.active {
    background-color: #2196F3;
    color: white;
    border-color: #2196F3;
    font-weight: bold;
}
.nv11-form-table {
    margin: 10px auto;
    border-collapse: collapse;
}
.nv11-form-table td {
    padding: 7px;
}
.nv11-form-table input[type="text"],
.nv11-form-table input[type="number"],
.nv11-form-table input[type="date"],
.nv11-form-table select {
    width: 250px;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
</style>

<!-- Sub-menu điều hướng Nhiệm vụ 11 -->
<div class="nv11-menu">
    <a href="nhiemvu11.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu11.php?subpage=lop_list" class="<?php echo (strpos($subpage, 'lop') !== false) ? 'active' : ''; ?>">Quản Lý Lớp</a>
    <a href="nhiemvu11.php?subpage=hoso_list" class="<?php echo (strpos($subpage, 'hoso') !== false) ? 'active' : ''; ?>">Hồ Sơ Học Sinh (Phân Trang)</a>
</div>

<div class="nv11-box">
<?php
echo $msg;

switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. QUẢN LÝ LỚP: DANH SÁCH & XÓA
    // ----------------------------------------------------------------------
    case 'lop_list':
        $rs = mysqli_query($conn, "SELECT * FROM LOP");
        ?>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>DANH SÁCH LỚP HỌC</h3>
            <a href="nhiemvu11.php?subpage=lop_form" class="nv11-btn">➕ Thêm Lớp Mới</a>
        </div>
        <table class="nv11-table">
            <tr>
                <th style="width: 15%;">Mã Lớp</th>
                <th style="width: 35%;">Tên Lớp</th>
                <th style="width: 15%;">Khóa Học</th>
                <th style="width: 20%;">GVCN</th>
                <th style="width: 15%; text-align: center;">Thao tác</th>
            </tr>
            <?php if (mysqli_num_rows($rs) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($rs)): ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($row['MALOP']); ?></b></td>
                        <td><?php echo htmlspecialchars($row['TENLOP']); ?></td>
                        <td><?php echo htmlspecialchars($row['KHOAHOC']); ?></td>
                        <td><?php echo htmlspecialchars($row['GVCN']); ?></td>
                        <td style="text-align: center;">
                            <a href="nhiemvu11.php?subpage=lop_form&id=<?php echo urlencode($row['MALOP']); ?>" style="color: blue;">Sửa</a> |
                            <a href="nhiemvu11.php?subpage=lop_delete&id=<?php echo urlencode($row['MALOP']); ?>" onclick="return confirm('Xóa lớp này sẽ xóa toàn bộ học sinh trong lớp?')" style="color: red;">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" style="text-align: center;">Chưa có dữ liệu lớp.</td></tr>
            <?php endif; ?>
        </table>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 2. QUẢN LÝ LỚP: FORM THÊM & SỬA
    // ----------------------------------------------------------------------
    case 'lop_form':
        $is_edit = false;
        $malop = ""; $tenlop = ""; $khoahoc = ""; $gvcn = "";

        if (isset($_GET['id'])) {
            $is_edit = true;
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $rs = mysqli_query($conn, "SELECT * FROM LOP WHERE MALOP = '$id'");
            if ($row = mysqli_fetch_assoc($rs)) {
                $malop = $row['MALOP'];
                $tenlop = $row['TENLOP'];
                $khoahoc = $row['KHOAHOC'];
                $gvcn = $row['GVCN'];
            }
        }
        ?>
        <h3 style="text-align: center;"><?php echo $is_edit ? "Cập Nhật Thông Tin Lớp" : "Thêm Lớp Học Mới"; ?></h3>
        <form method="POST" action="nhiemvu11.php?subpage=lop_form">
            <input type="hidden" name="is_edit" value="<?php echo $is_edit ? '1' : '0'; ?>">
            <table class="nv11-form-table">
                <tr>
                    <td style="width: 30%;">Mã Lớp:</td>
                    <td>
                        <input type="text" name="malop" value="<?php echo htmlspecialchars($malop); ?>" <?php echo $is_edit ? 'readonly style="background:#e9e9e9;"' : ''; ?> required>
                    </td>
                </tr>
                <tr>
                    <td>Tên Lớp:</td>
                    <td><input type="text" name="tenlop" value="<?php echo htmlspecialchars($tenlop); ?>" required></td>
                </tr>
                <tr>
                    <td>Khóa Học:</td>
                    <td><input type="number" name="khoahoc" value="<?php echo htmlspecialchars($khoahoc); ?>" required></td>
                </tr>
                <tr>
                    <td>GVCN:</td>
                    <td><input type="text" name="gvcn" value="<?php echo htmlspecialchars($gvcn); ?>" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="nhiemvu11.php?subpage=lop_list" class="nv11-btn nv11-btn-gray">Quay lại</a>&nbsp;
                        <input type="submit" name="btnLuuLop" value="Lưu Dữ Liệu" class="nv11-btn">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 3. QUẢN LÝ HỒ SƠ: DANH SÁCH KÈM PHÂN TRANG (10 BẢN GHI/TRANG)
    // ----------------------------------------------------------------------
    case 'hoso_list':
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $start = ($page - 1) * $limit;

        // Lấy tổng số bản ghi
        $rs_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM HOSO");
        $row_total = mysqli_fetch_assoc($rs_total);
        $total_records = $row_total['total'];
        $total_pages = ceil($total_records / $limit);

        // Truy vấn 10 bản ghi cho trang hiện tại
        $sql = "SELECT h.*, l.TENLOP FROM HOSO h LEFT JOIN LOP l ON h.LOP = l.MALOP LIMIT $start, $limit";
        $rs = mysqli_query($conn, $sql);
        ?>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3>DANH SÁCH HỒ SƠ HỌC SINH (PHÂN TRANG)</h3>
            <a href="nhiemvu11.php?subpage=hoso_form" class="nv11-btn">➕ Thêm Học Sinh</a>
        </div>
        <table class="nv11-table">
            <tr>
                <th>Mã HS</th>
                <th>Họ Tên</th>
                <th>Ngày Sinh</th>
                <th>Địa Chỉ</th>
                <th>Lớp</th>
                <th>Điểm (T/L/H)</th>
                <th style="text-align: center;">Thao tác</th>
            </tr>
            <?php if (mysqli_num_rows($rs) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($rs)): ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($row['MAHS']); ?></b></td>
                        <td><?php echo htmlspecialchars($row['HOTEN']); ?></td>
                        <td><?php echo htmlspecialchars($row['NGAYSINH']); ?></td>
                        <td><?php echo htmlspecialchars($row['DIACHI']); ?></td>
                        <td><?php echo htmlspecialchars($row['LOP']); ?></td>
                        <td><?php echo "{$row['DIEMTOAN']} / {$row['DIEMLY']} / {$row['DIEMHOA']}"; ?></td>
                        <td style="text-align: center;">
                            <a href="nhiemvu11.php?subpage=hoso_form&id=<?php echo urlencode($row['MAHS']); ?>" style="color: blue;">Sửa</a> |
                            <a href="nhiemvu11.php?subpage=hoso_delete&id=<?php echo urlencode($row['MAHS']); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa học sinh này?')" style="color: red;">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">Chưa có dữ liệu học sinh.</td></tr>
            <?php endif; ?>
        </table>

        <!-- Thanh phân trang -->
        <?php if ($total_pages > 1): ?>
            <div class="nv11-pagination">
                <span>Trang: </span>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="nhiemvu11.php?subpage=hoso_list&page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 4. QUẢN LÝ HỒ SƠ: FORM THÊM & SỬA HỌC SINH
    // ----------------------------------------------------------------------
    case 'hoso_form':
        $is_edit = false;
        $mahs = ""; $hoten = ""; $ngaysinh = "2000-01-01"; $diachi = "";
        $lop = ""; $dtoan = 0; $dly = 0; $dhoa = 0;

        if (isset($_GET['id'])) {
            $is_edit = true;
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $rs = mysqli_query($conn, "SELECT * FROM HOSO WHERE MAHS = '$id'");
            if ($row = mysqli_fetch_assoc($rs)) {
                $mahs = $row['MAHS'];
                $hoten = $row['HOTEN'];
                $ngaysinh = $row['NGAYSINH'];
                $diachi = $row['DIACHI'];
                $lop = $row['LOP'];
                $dtoan = $row['DIEMTOAN'];
                $dly = $row['DIEMLY'];
                $dhoa = $row['DIEMHOA'];
            }
        }

        // Lấy danh sách lớp để đưa vào dropdown select (tránh lỗi khóa ngoại)
        $rs_lop = mysqli_query($conn, "SELECT MALOP, TENLOP FROM LOP");
        ?>
        <h3 style="text-align: center;"><?php echo $is_edit ? "Cập Nhật Hồ Sơ Học Sinh" : "Thêm Hồ Sơ Học Sinh Mới"; ?></h3>
        <form method="POST" action="nhiemvu11.php?subpage=hoso_form">
            <input type="hidden" name="is_edit" value="<?php echo $is_edit ? '1' : '0'; ?>">
            <table class="nv11-form-table">
                <tr>
                    <td style="width: 25%;">Mã HS:</td>
                    <td>
                        <input type="text" name="mahs" value="<?php echo htmlspecialchars($mahs); ?>" <?php echo $is_edit ? 'readonly style="background:#e9e9e9;"' : ''; ?> required>
                    </td>
                </tr>
                <tr>
                    <td>Họ Tên:</td>
                    <td><input type="text" name="hoten" value="<?php echo htmlspecialchars($hoten); ?>" required></td>
                </tr>
                <tr>
                    <td>Ngày Sinh:</td>
                    <td><input type="date" name="ngaysinh" value="<?php echo htmlspecialchars($ngaysinh); ?>" required></td>
                </tr>
                <tr>
                    <td>Địa Chỉ:</td>
                    <td><input type="text" name="diachi" value="<?php echo htmlspecialchars($diachi); ?>" required></td>
                </tr>
                <tr>
                    <td>Lớp:</td>
                    <td>
                        <select name="lop" required>
                            <option value="">-- Chọn lớp học --</option>
                            <?php while ($l = mysqli_fetch_assoc($rs_lop)): ?>
                                <option value="<?php echo htmlspecialchars($l['MALOP']); ?>" <?php echo ($lop == $l['MALOP']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($l['MALOP'] . " - " . $l['TENLOP']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Điểm Toán:</td>
                    <td><input type="number" step="0.1" min="0" max="10" name="diemtoan" value="<?php echo htmlspecialchars($dtoan); ?>" required></td>
                </tr>
                <tr>
                    <td>Điểm Lý:</td>
                    <td><input type="number" step="0.1" min="0" max="10" name="diemly" value="<?php echo htmlspecialchars($dly); ?>" required></td>
                </tr>
                <tr>
                    <td>Điểm Hóa:</td>
                    <td><input type="number" step="0.1" min="0" max="10" name="diemhoa" value="<?php echo htmlspecialchars($dhoa); ?>" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="nhiemvu11.php?subpage=hoso_list" class="nv11-btn nv11-btn-gray">Quay lại</a>&nbsp;
                        <input type="submit" name="btnLuuHoSo" value="Lưu Dữ Liệu" class="nv11-btn">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG CHỦ
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 11: Kết Nối và Thao Tác CSDL Cơ Bản</h2>
        <div style="line-height: 1.8; margin-top: 15px;">
            <p><strong>Nội dung trọng tâm bài thực hành:</strong></p>
            <ul>
                <li>Kết nối hệ quản trị CSDL MySQL với hàm <code>mysqli_connect()</code> và thiết lập font chữ UTF-8 qua <code>mysqli_set_charset()</code>.</li>
                <li>Thực hiện các thao tác CRUD cơ bản (Xem, Thêm, Sửa, Xóa) trên bảng <b>LOP</b>.</li>
                <li>Thao tác bảng <b>HOSO</b> kết hợp kỹ thuật <b>phân trang (Pagination)</b>: sử dụng mệnh đề <code>LIMIT $start, $limit</code> để hiển thị chính xác 10 bản ghi trên mỗi trang.</li>
                <li>Ràng buộc toàn vẹn dữ liệu khóa ngoại (Foreign Key) giữa bảng <code>HOSO</code> và <code>LOP</code> bằng điều khiển <code>&lt;select&gt;</code> lựa chọn lớp học.</li>
            </ul>
            <p style="margin-top: 15px;">
                👉 Sử dụng các tab ở thanh menu phía trên để quản lý danh sách <b>Lớp học</b> hoặc duyệt danh sách <b>Hồ sơ học sinh có phân trang</b>.
            </p>
        </div>
        <?php
        break;
}

mysqli_close($conn);
?>
</div>

<?php
include "includes/footer.php";
?>
