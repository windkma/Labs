<?php
include "includes/header.php";

// Lấy trang hiện tại trong Nhiệm vụ 3 (mặc định là 'home')
$subpage = $_GET['subpage'] ?? 'home';
?>

<style>
/* CSS bổ trợ riêng cho Nhiệm vụ 3 */
.nv3-menu {
    background-color: #333;
    padding: 8px 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv3-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 12px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv3-menu a:hover, .nv3-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv3-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}
.nv3-box table {
    border-collapse: collapse;
    margin-top: 10px;
}
.nv3-box table td, .nv3-box table th {
    padding: 6px 10px;
}
.nv3-box input[type="text"], 
.nv3-box input[type="number"] {
    padding: 5px 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.nv3-box button, .nv3-box input[type="submit"], .nv3-box input[type="button"], .nv3-box input[type="reset"] {
    padding: 6px 15px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.nv3-box button:hover, .nv3-box input[type="submit"]:hover {
    background: #0b7dda;
}
.matrix-input {
    display: inline-block;
    vertical-align: top;
    margin-right: 30px;
}
.matrix-input input {
    width: 45px;
    text-align: center;
}
.result-table {
    border: 1px solid #333;
    border-collapse: collapse;
    margin-top: 15px;
}
.result-table td {
    border: 1px solid #333;
    width: 35px;
    height: 35px;
    text-align: center;
}
</style>

<!-- Sub-menu điều hướng các bài con của Nhiệm vụ 3 -->
<div class="nv3-menu">
    <a href="nhiemvu3.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu3.php?subpage=drawTable" class="<?php echo ($subpage == 'drawTable') ? 'active' : ''; ?>">DrawTable</a>
    <a href="nhiemvu3.php?subpage=calculate1" class="<?php echo ($subpage == 'calculate1') ? 'active' : ''; ?>">Calculate1</a>
    <a href="nhiemvu3.php?subpage=calculate2" class="<?php echo ($subpage == 'calculate2') ? 'active' : ''; ?>">Calculate2</a>
    <a href="nhiemvu3.php?subpage=array1" class="<?php echo ($subpage == 'array1') ? 'active' : ''; ?>">Array1</a>
    <a href="nhiemvu3.php?subpage=array2" class="<?php echo (in_array($subpage, ['array2', 'uploadprocess'])) ? 'active' : ''; ?>">Uploadform</a>
</div>

<div class="nv3-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. DRAW TABLE
    // ----------------------------------------------------------------------
    case 'drawTable':
        ?>
        <h3>Trang DrawTable</h3>
        <p><b>Form vẽ bảng:</b></p>
        <form method="POST" action="nhiemvu3.php?subpage=drawTable">
            <table>
                <tr>
                    <td>Số dòng:</td>
                    <td><input type="number" name="sodong" value="<?php echo $_POST['sodong'] ?? ''; ?>" required min="1"></td>
                </tr>
                <tr>
                    <td>Số cột:</td>
                    <td><input type="number" name="socot" value="<?php echo $_POST['socot'] ?? ''; ?>" required min="1"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="reset">Nhập Lại</button>
                        <button type="submit" name="btnVe">Vẽ</button>
                    </td>
                </tr>
            </table>
            <p><i>(Khi Click nút Vẽ thì mới vẽ bảng và hiển thị bên dưới)</i></p>
        </form>

        <?php
        if (isset($_POST['btnVe'])) {
            $rows = (int)($_POST['sodong'] ?? 0);
            $cols = (int)($_POST['socot'] ?? 0);

            if ($rows > 0 && $cols > 0) {
                echo "<h4>Kết quả:</h4>";
                echo "<table class='result-table'>";
                for ($i = 1; $i <= $rows; $i++) {
                    echo "<tr>";
                    for ($j = 1; $j <= $cols; $j++) {
                        // Hiển thị số cột theo quy tắc mẫu tam giác / số thứ tự
                        echo "<td>" . $j . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        break;

    // ----------------------------------------------------------------------
    // 2. CALCULATE 1: PHÉP TÍNH CƠ BẢN
    // ----------------------------------------------------------------------
    case 'calculate1':
        $result = '';
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $a = isset($_POST['a']) ? (float)$_POST['a'] : 0;
            $b = isset($_POST['b']) ? (float)$_POST['b'] : 0;
            $operator = $_POST['operator'] ?? '';

            switch ($operator) {
                case '+':
                    $result = "$a + $b = " . ($a + $b);
                    break;
                case '-':
                    $result = "$a - $b = " . ($a - $b);
                    break;
                case '*':
                    $result = "$a * $b = " . ($a * $b);
                    break;
                case '/':
                    if ($b == 0) {
                        $result = "<span style='color:red;'>Không thể chia cho 0</span>";
                    } else {
                        $result = "$a / $b = " . ($a / $b);
                    }
                    break;
                default:
                    $result = "Vui lòng chọn phép tính.";
            }
        }
        ?>
        <h3>Trang Calculate 1</h3>
        <form method="POST" action="nhiemvu3.php?subpage=calculate1">
            <table>
                <tr>
                    <td>Số thứ nhất (a):</td>
                    <td><input type="number" step="any" name="a" value="<?php echo $_POST['a'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Số thứ hai (b):</td>
                    <td><input type="number" step="any" name="b" value="<?php echo $_POST['b'] ?? ''; ?>" required></td>
                </tr>
                <tr>
                    <td>Phép tính:</td>
                    <td>
                        <label><input type="radio" name="operator" value="+" <?php echo (!isset($_POST['operator']) || $_POST['operator']=='+')?'checked':''; ?>> + </label>&nbsp;
                        <label><input type="radio" name="operator" value="-" <?php echo (isset($_POST['operator']) && $_POST['operator']=='-')?'checked':''; ?>> - </label>&nbsp;
                        <label><input type="radio" name="operator" value="*" <?php echo (isset($_POST['operator']) && $_POST['operator']=='*')?'checked':''; ?>> * </label>&nbsp;
                        <label><input type="radio" name="operator" value="/" <?php echo (isset($_POST['operator']) && $_POST['operator']=='/')?'checked':''; ?>> / </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Calculate</button>
                    </td>
                </tr>
            </table>
        </form>
        <br>
        <strong>Kết quả: </strong><?php echo $result; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 3. CALCULATE 2: TÍNH ĐIỂM HỌC SINH
    // ----------------------------------------------------------------------
    case 'calculate2':
        $hovaten = $_POST['hovaten'] ?? '';
        $lop = $_POST['lop'] ?? '';
        $m1 = $_POST['m1'] ?? '';
        $m2 = $_POST['m2'] ?? '';
        $m3 = $_POST['m3'] ?? '';
        $tongdiem = '';
        $msg = '';

        if (isset($_POST['ok'])) {
            if (empty($hovaten) || empty($lop) || $m1 === '' || $m2 === '' || $m3 === '') {
                $msg = "Vui lòng nhập đầy đủ thông tin!";
            } elseif (!is_numeric($m1) || !is_numeric($m2) || !is_numeric($m3)) {
                $msg = "Điểm M1, M2, M3 phải ở định dạng số!";
            } else {
                $tongdiem = floatval($m1) + floatval($m2) + floatval($m3);
            }
        }
        ?>
        <h3>Trang Calculate 2: Bảng Điểm</h3>
        <?php if ($msg): ?>
            <p style="color: red; font-weight: bold;"><?php echo $msg; ?></p>
        <?php endif; ?>
        <form action="nhiemvu3.php?subpage=calculate2" method="POST">
            <table>
                <tr>
                    <td>Họ và tên:</td>
                    <td><input type="text" name="hovaten" value="<?php echo htmlspecialchars($hovaten); ?>" required></td>
                </tr>
                <tr>
                    <td>Lớp:</td>
                    <td><input type="text" name="lop" value="<?php echo htmlspecialchars($lop); ?>" required></td>
                </tr>
                <tr>
                    <td>Điểm M1:</td>
                    <td><input type="text" name="m1" value="<?php echo htmlspecialchars($m1); ?>" required></td>
                </tr>
                <tr>
                    <td>Điểm M2:</td>
                    <td><input type="text" name="m2" value="<?php echo htmlspecialchars($m2); ?>" required></td>
                </tr>
                <tr>
                    <td>Điểm M3:</td>
                    <td><input type="text" name="m3" value="<?php echo htmlspecialchars($m3); ?>" required></td>
                </tr>
                <tr>
                    <td>Tổng điểm:</td>
                    <td><input type="text" name="tongdiem" value="<?php echo htmlspecialchars((string)$tongdiem); ?>" readonly style="background-color: #e9e9e9;"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="ok" value="OK">
                        <input type="button" value="CanCel" onclick="window.location.href='nhiemvu3.php?subpage=calculate2'">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 4. ARRAY 1: MA TRẬN 3x3
    // ----------------------------------------------------------------------
    case 'array1':
        $m1 = $_POST['m1'] ?? [];
        $m2 = $_POST['m2'] ?? [];
        $tong = [];
        $hieu = [];
        $tich = [];
        $msg = "";
        $hien_thi_ket_qua = false;

        if (isset($_POST['btnTinh'])) {
            $hien_thi_ket_qua = true;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    if (!isset($m1[$i][$j]) || !isset($m2[$i][$j]) || !is_numeric($m1[$i][$j]) || !is_numeric($m2[$i][$j])) {
                        $msg = "Vui lòng nhập đầy đủ các số cho cả 2 ma trận!";
                        $hien_thi_ket_qua = false;
                        break 2;
                    }
                    $tong[$i][$j] = $m1[$i][$j] + $m2[$i][$j];
                    $hieu[$i][$j] = $m1[$i][$j] - $m2[$i][$j];

                    $tich[$i][$j] = 0;
                    for ($k = 0; $k < 3; $k++) {
                        $tich[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
                    }
                }
            }
        }
        ?>
        <h3>Sử dụng mảng để tính: hiệu, tổng, tích 2 ma trận 3x3</h3>
        <?php if ($msg) echo "<p style='color:red;'>$msg</p>"; ?>
        <form method="POST" action="nhiemvu3.php?subpage=array1">
            <div style="margin-bottom: 15px;">
                <div class="matrix-input">
                    <b>Nhập Ma trận 1:</b>
                    <table>
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <tr>
                                <?php for ($j = 0; $j < 3; $j++): ?>
                                    <td><input type="text" name="m1[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo htmlspecialchars($m1[$i][$j] ?? '0'); ?>" required></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>

                <div class="matrix-input">
                    <b>Nhập Ma trận 2:</b>
                    <table>
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <tr>
                                <?php for ($j = 0; $j < 3; $j++): ?>
                                    <td><input type="text" name="m2[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo htmlspecialchars($m2[$i][$j] ?? '0'); ?>" required></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>
            </div>

            <div>
                <input type="button" value="Nhập Lại" onclick="window.location.href='nhiemvu3.php?subpage=array1'">
                <input type="submit" name="btnTinh" value="Tính">
            </div>
        </form>

        <?php if ($hien_thi_ket_qua): ?>
            <hr style="margin: 20px 0;">
            <h3>KẾT QUẢ:</h3>
            <?php
            function renderMatrix($title, $matrix) {
                echo "<b>$title:</b><br>";
                echo "<table style='border: 1px solid #999; margin-bottom: 10px;'>";
                for ($i = 0; $i < 3; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 3; $j++) {
                        echo "<td style='border: 1px solid #ccc; width: 40px; text-align: center;'>" . $matrix[$i][$j] . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            renderMatrix("Ma trận Tổng", $tong);
            renderMatrix("Ma trận Hiệu", $hieu);
            renderMatrix("Ma trận Tích", $tich);
            ?>
        <?php endif; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 5. ARRAY 2: UPLOAD NHIỀU FILE BẰNG MẢNG
    // ----------------------------------------------------------------------
    case 'array2':
    case 'uploadprocess':
        ?>
        <?php if ($subpage === 'array2'): ?>
        <h3>Upload nhiều file sử dụng mảng kết hợp</h3>
        <p>Upload tối đa 10 file, sau đó hiển thị tên và đường dẫn tải xuống.</p>
        <form method="POST" action="nhiemvu3.php?subpage=uploadprocess" enctype="multipart/form-data">
            <table>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td>File <?php echo $i; ?>:</td>
                        <td><input type="file" name="files[]"></td>
                    </tr>
                <?php endfor; ?>
                <tr>
                    <td colspan="2">
                        <input type="reset" value="Reset">
                        <input type="submit" name="btnUpload" value="Upload">
                    </td>
                </tr>
            </table>
        </form>
        <?php else: ?>
        <h3>Danh sách file đã upload</h3>

        <?php
        if (isset($_POST['btnUpload']) && isset($_FILES['files'])) {
            $upload_dir = "uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            echo "<hr>";
            echo "<h4>Danh sách file đã upload:</h4>";
            $has_file = false;

            foreach ($_FILES['files']['name'] as $i => $filename) {
                if (!empty($filename)) {
                    $tmp = $_FILES['files']['tmp_name'][$i];
                    $safe_name = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($filename));
                    $target_path = $upload_dir . time() . '_' . $safe_name;
                    if (move_uploaded_file($tmp, $target_path)) {
                        echo "<p>Tải lên thành công: <a href='" . htmlspecialchars($target_path, ENT_QUOTES, 'UTF-8') . "' download>Download File: " . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . "</a></p>";
                        $has_file = true;
                    }
                }
            }

            if (!$has_file) {
                echo "<p style='color:orange;'>Chưa có file nào được chọn để upload.</p>";
            }
        }
        ?>
        <p><a href="nhiemvu3.php?subpage=array2">Quay lại form upload</a></p>
        <?php endif;
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG HOME CỦA NHIỆM VỤ 3
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 3</h2>
        <p>Mỗi page được chạy trên nền trang cấu trúc switch-case qua tham số <code>?subpage=...</code>.</p>
        <p>Vui lòng chọn một chức năng ở thanh menu phía trên để thực hành:</p>
        <ul>
            <li><strong>DrawTable:</strong> Nhập số dòng, số cột để tự động vẽ bảng bằng 2 vòng lặp lồng nhau.</li>
            <li><strong>Calculate1:</strong> Nhập 2 số và chọn toán tử (+, -, *, /).</li>
            <li><strong>Calculate2:</strong> Form nhập điểm học sinh và kiểm tra hợp lệ, tính tổng điểm.</li>
            <li><strong>Array1:</strong> Thao tác cộng, trừ, nhân hai ma trận 3x3.</li>
            <li><strong>Array2:</strong> Upload nhiều file sử dụng cấu trúc mảng <code>files[]</code>.</li>
        </ul>
        <?php
        break;
}
?>
</div>

<?php
include "includes/footer.php";
?>
