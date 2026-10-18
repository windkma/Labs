<?php
include "includes/header.php";

$file_path = "student_nv8.txt";
$subpage = $_GET['subpage'] ?? 'home';
$msg = "";

// Xử lý thêm sinh viên mới vào file
if (isset($_POST["btnGhi"])) {
    $ten = trim($_POST["ten"] ?? "");
    $diachi = trim($_POST["diachi"] ?? "");
    $tuoi = trim($_POST["tuoi"] ?? "");

    if (!empty($ten) && !empty($diachi) && !empty($tuoi)) {
        // Mở file ở chế độ append ("a") để ghi nối tiếp xuống cuối file
        $fp = fopen($file_path, "a");
        if ($fp) {
            // Đảm bảo xuống dòng trước khi ghi nếu file đã có nội dung
            if (filesize($file_path) > 0) {
                fwrite($fp, "\n");
            }
            fwrite($fp, $ten . "\n");
            fwrite($fp, $diachi . "\n");
            fwrite($fp, $tuoi);
            fclose($fp);
            $msg = "<p style='color: green; font-weight: bold;'>✔️ Ghi dữ liệu sinh viên thành công!</p>";
        } else {
            $msg = "<p style='color: red;'>❌ Không thể mở file student.txt để ghi!</p>";
        }
    } else {
        $msg = "<p style='color: red;'>Vui lòng nhập đầy đủ thông tin!</p>";
    }
}
?>

<style>
.nv8-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv8-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv8-menu a:hover, .nv8-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv8-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}
.nv8-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 15px;
}
.nv8-table th, .nv8-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
.nv8-table th {
    background: #f0f0f0;
}
.nv8-form-table {
    margin: 10px auto;
    border-collapse: collapse;
}
.nv8-form-table td {
    padding: 8px;
}
.nv8-form-table input[type="text"],
.nv8-form-table input[type="number"] {
    width: 260px;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.nv8-btn {
    padding: 6px 16px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.nv8-btn:hover {
    background: #0b7dda;
}
.nv8-btn-gray {
    background: #777;
}
.nv8-btn-gray:hover {
    background: #555;
}
</style>

<!-- Sub-menu điều hướng Nhiệm vụ 8 -->
<div class="nv8-menu">
    <a href="nhiemvu8.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu8.php?subpage=list" class="<?php echo ($subpage == 'list') ? 'active' : ''; ?>">ListStudent</a>
    <a href="nhiemvu8.php?subpage=add" class="<?php echo ($subpage == 'add') ? 'active' : ''; ?>">Add Student</a>
</div>

<div class="nv8-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. LIST STUDENT: ĐỌC DỮ LIỆU TỪ FILE VÀ HIỂN THỊ
    // ----------------------------------------------------------------------
    case 'list':
        ?>
        <h3>Danh Sách Sinh Viên (Đọc từ student.txt)</h3>
        <?php
        if (file_exists($file_path)) {
            // Đọc toàn bộ file thành mảng các dòng (bỏ qua dòng trống)
            $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            echo "<table class='nv8-table'>";
            echo "<tr>
                    <th style='width: 10%; text-align: center;'>STT</th>
                    <th style='width: 40%;'>Tên</th>
                    <th style='width: 35%;'>Địa chỉ</th>
                    <th style='width: 15%; text-align: center;'>Tuổi</th>
                  </tr>";

            $stt = 1;
            $total_lines = count($lines);

            // Mỗi sinh viên gồm 3 dòng tuần tự: Tên, Địa chỉ, Tuổi
            for ($i = 0; $i < $total_lines; $i += 3) {
                $ten = $lines[$i] ?? "";
                $diachi = $lines[$i + 1] ?? "";
                $tuoi = $lines[$i + 2] ?? "";

                echo "<tr>";
                echo "<td style='text-align: center;'>" . $stt++ . "</td>";
                echo "<td>" . htmlspecialchars($ten) . "</td>";
                echo "<td>" . htmlspecialchars($diachi) . "</td>";
                echo "<td style='text-align: center;'>" . htmlspecialchars($tuoi) . "</td>";
                echo "</tr>";
            }

            if ($total_lines == 0) {
                echo "<tr><td colspan='4' style='text-align: center;'>File dữ liệu rỗng!</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>Không tìm thấy file student.txt!</p>";
        }
        break;

    // ----------------------------------------------------------------------
    // 2. ADD STUDENT: FORM THÊM MỚI VÀ GHI NỐI TIẾP VÀO FILE
    // ----------------------------------------------------------------------
    case 'add':
        ?>
        <h3 style="text-align: center;">Thêm Sinh Viên Mới</h3>
        <div style="text-align: center;"><?php echo $msg; ?></div>

        <form method="POST" action="nhiemvu8.php?subpage=add">
            <table class="nv8-form-table">
                <tr>
                    <td style="width: 30%;">Tên:</td>
                    <td><input type="text" name="ten" required></td>
                </tr>
                <tr>
                    <td>Địa chỉ:</td>
                    <td><input type="text" name="diachi" required></td>
                </tr>
                <tr>
                    <td>Tuổi:</td>
                    <td><input type="number" name="tuoi" min="1" max="150" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="reset" value="Nhập Lại" class="nv8-btn nv8-btn-gray">&nbsp;&nbsp;
                        <input type="submit" name="btnGhi" value="Ghi" class="nv8-btn">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG HOME
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 8: Đọc và Ghi File</h2>
        <div style="line-height: 1.8; margin-top: 15px;">
            <p><strong>Mục tiêu bài thực hành:</strong></p>
            <ul>
                <li>Hiểu cơ chế đọc/ghi tệp văn bản trong PHP bằng các hàm: <code>fopen()</code>, <code>fwrite()</code>, <code>fclose()</code>, <code>file()</code>.</li>
                <li>Tổ chức lưu trữ dữ liệu dạng cấu trúc theo dòng (Line-based format). Mỗi bản ghi sinh viên gồm 3 dòng: <i>Tên &rarr; Địa chỉ &rarr; Tuổi</i>.</li>
                <li>Hiển thị danh sách sinh viên qua dạng bảng từ file dữ liệu và hỗ trợ thêm bản ghi mới mà không bị ghi đè dữ liệu cũ.</li>
            </ul>
            <p style="margin-top: 15px;">
                👉 Chọn <b>ListStudent</b> để xem danh sách hoặc chọn <b>Add Student</b> để ghi thêm sinh viên mới vào file <code>student.txt</code>.
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