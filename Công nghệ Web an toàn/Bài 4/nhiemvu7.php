<?php
// Nạp thư viện hàm toán học
require_once "libs/math.php";

include "includes/header.php";

$subpage = $_GET['subpage'] ?? 'home';
?>

<style>
.nv7-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv7-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv7-menu a:hover, .nv7-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv7-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}
.matrix-block {
    display: inline-block;
    vertical-align: top;
    margin-right: 35px;
    margin-bottom: 15px;
}
.matrix-block table {
    border-collapse: collapse;
    margin-top: 8px;
}
.matrix-block input[type="text"] {
    width: 45px;
    text-align: center;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.result-table {
    border-collapse: collapse;
    margin: 8px 0 15px 0;
}
.result-table td {
    border: 1px solid #999;
    width: 40px;
    height: 35px;
    text-align: center;
    background: #fff;
}
.nv7-btn {
    padding: 6px 16px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.nv7-btn:hover {
    background: #0b7dda;
}
.nv7-btn-gray {
    background: #777;
}
.nv7-btn-gray:hover {
    background: #555;
}
</style>

<!-- Sub-menu điều hướng Nhiệm vụ 7 -->
<div class="nv7-menu">
    <a href="nhiemvu7.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu7.php?subpage=ar1Chieu" class="<?php echo ($subpage == 'ar1Chieu') ? 'active' : ''; ?>">Ar1Chieu</a>
    <a href="nhiemvu7.php?subpage=matrix" class="<?php echo ($subpage == 'matrix') ? 'active' : ''; ?>">Matrix</a>
</div>

<div class="nv7-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. THAO TÁC MẢNG 1 CHIỀU
    // ----------------------------------------------------------------------
    case 'ar1Chieu':
        $daySoStr = $_POST['txtDaySo'] ?? "1, 2, 3, 4, 5, 6, 7, 8, 9";
        $ketqua = false;

        if (isset($_POST['btnCalculate'])) {
            // Tách chuỗi theo dấu phẩy hoặc dấu cách
            $items = preg_split('/[\s,]+/', trim($daySoStr));
            $mangSo = [];
            foreach ($items as $item) {
                if (is_numeric($item)) {
                    $mangSo[] = floatval($item);
                }
            }

            if (!empty($mangSo)) {
                $ketqua = true;
                $tong = tongDay($mangSo);
                $tb = avgDay($mangSo);
                $min = minDay($mangSo);
                $max = maxDay($mangSo);
                $sapXep = sortDay($mangSo);
                $daoNguoc = daoNguocDay($mangSo);
            } else {
                echo "<p style='color:red;'>Vui lòng nhập các phần tử số hợp lệ!</p>";
            }
        }
        ?>
        <h3>Thao tác trên mảng 1 chiều (Function Library)</h3>
        <p><i>Bài toán: Nhập vào chuỗi số để tính tổng, giá trị trung bình, tìm min, max, sắp xếp và đảo ngược dãy.</i></p>

        <form method="POST" action="nhiemvu7.php?subpage=ar1Chieu">
            <p>
                <b>Nhập dãy số (cách nhau bằng dấu phẩy hoặc khoảng trắng):</b><br>
                <input type="text" name="txtDaySo" value="<?php echo htmlspecialchars($daySoStr); ?>" style="width: 100%; max-width: 450px; padding: 6px; margin: 8px 0;" required>
            </p>
            <p>
                <input type="button" value="Reset" class="nv7-btn nv7-btn-gray" onclick="window.location.href='nhiemvu7.php?subpage=ar1Chieu'">&nbsp;&nbsp;
                <input type="submit" name="btnCalculate" value="Calculate" class="nv7-btn">
            </p>
        </form>

        <?php if ($ketqua): ?>
            <hr style="margin: 20px 0;">
            <div style="background: #e8f5e9; border: 1px solid #c8e6c9; padding: 15px; border-radius: 4px;">
                <h4 style="color: #2e7d32; margin-bottom: 10px;">KẾT QUẢ TÍNH TOÁN:</h4>
                <p><b>Tổng các số:</b> <?php echo $tong; ?></p>
                <p><b>Trung bình cộng:</b> <?php echo $tb; ?></p>
                <p><b>Phần tử nhỏ nhất (Min):</b> <?php echo $min; ?></p>
                <p><b>Phần tử lớn nhất (Max):</b> <?php echo $max; ?></p>
                <p><b>Dãy sau khi sắp xếp tăng dần:</b> <?php echo implode(", ", $sapXep); ?></p>
                <p><b>Dãy đảo ngược:</b> <?php echo implode(", ", $daoNguoc); ?></p>
            </div>
        <?php endif; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 2. THAO TÁC MA TRẬN 3x3
    // ----------------------------------------------------------------------
    case 'matrix':
        $m1 = $_POST['m1'] ?? [];
        $m2 = $_POST['m2'] ?? [];
        $has_result = false;
        $error = "";

        if (isset($_POST['btnTinh'])) {
            $has_result = true;
            // Kiểm tra số
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    if (!isset($m1[$i][$j]) || !isset($m2[$i][$j]) || !is_numeric($m1[$i][$j]) || !is_numeric($m2[$i][$j])) {
                        $error = "Vui lòng nhập đầy đủ giá trị số cho cả 2 ma trận!";
                        $has_result = false;
                        break 2;
                    }
                    $m1[$i][$j] = floatval($m1[$i][$j]);
                    $m2[$i][$j] = floatval($m2[$i][$j]);
                }
            }

            if ($has_result) {
                // Gọi các hàm từ file libs/math.php
                $tong = tinhMatranTong($m1, $m2);
                $hieu = tinhMatranHieu($m1, $m2);
                $tich = tinhMatranTich($m1, $m2);

                $maxM1 = maxMatran($m1);
                $minM1 = minMatran($m1);
                $cheoChinhM1 = tongTrenCheoChinh($m1);
                $cheoPhuM1 = tongTrenCheoPhu($m1);
            }
        }

        function inMaTran($matrix) {
            echo "<table class='result-table'>";
            for ($i = 0; $i < 3; $i++) {
                echo "<tr>";
                for ($j = 0; $j < 3; $j++) {
                    echo "<td>" . $matrix[$i][$j] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        <h3>Sử dụng hàm tự định nghĩa để thao tác trên Ma trận 3x3</h3>
        <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="POST" action="nhiemvu7.php?subpage=matrix">
            <div>
                <div class="matrix-block">
                    <b>Nhập Ma trận 1:</b>
                    <table>
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <tr>
                                <?php for ($j = 0; $j < 3; $j++): ?>
                                    <td><input type="text" name="m1[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo htmlspecialchars($m1[$i][$j] ?? ($i == $j ? '1' : '0')); ?>" required></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>

                <div class="matrix-block">
                    <b>Nhập Ma trận 2:</b>
                    <table>
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <tr>
                                <?php for ($j = 0; $j < 3; $j++): ?>
                                    <td><input type="text" name="m2[<?php echo $i; ?>][<?php echo $j; ?>]" value="<?php echo htmlspecialchars($m2[$i][$j] ?? '1'); ?>" required></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <input type="button" value="Nhập Lại" class="nv7-btn nv7-btn-gray" onclick="window.location.href='nhiemvu7.php?subpage=matrix'">&nbsp;&nbsp;
                <input type="submit" name="btnTinh" value="Tính Toán" class="nv7-btn">
            </div>
        </form>

        <?php if ($has_result): ?>
            <hr style="margin: 20px 0;">
            <h3>KẾT QUẢ TÍNH TOÁN:</h3>
            <div style="display: flex; flex-wrap: wrap; gap: 30px;">
                <div>
                    <b>Ma trận Tổng:</b>
                    <?php inMaTran($tong); ?>
                </div>
                <div>
                    <b>Ma trận Hiệu:</b>
                    <?php inMaTran($hieu); ?>
                </div>
                <div>
                    <b>Ma trận Tích:</b>
                    <?php inMaTran($tich); ?>
                </div>
            </div>

            <div style="background: #f0f4f8; border: 1px solid #d0d7de; padding: 15px; border-radius: 4px; margin-top: 15px;">
                <h4 style="margin-bottom: 8px;">Thông tin mở rộng về Ma trận 1 (gọi từ libs/math.php):</h4>
                <p>- Phần tử lớn nhất (Max): <b><?php echo $maxM1; ?></b> | Phần tử nhỏ nhất (Min): <b><?php echo $minM1; ?></b></p>
                <p>- Tổng đường chéo chính: <b><?php echo $cheoChinhM1; ?></b></p>
                <p>- Tổng đường chéo phụ: <b><?php echo $cheoPhuM1; ?></b></p>
            </div>
        <?php endif; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG HOME
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 7: Thư Viện Hàm (Functions)</h2>
        <div style="line-height: 1.8; margin-top: 15px;">
            <p><strong>Mục tiêu:</strong></p>
            <ul>
                <li>Hiểu bản chất và cách tổ chức các hàm chức năng vào thư mục dùng chung (<code>libs/</code>).</li>
                <li>Tách rời logic tính toán toán học ra khỏi mã hiển thị HTML để mã nguồn sạch và dễ bảo trì hơn.</li>
                <li>Sử dụng lệnh <code>require_once "libs/math.php";</code> để tái sử dụng các hàm toán học xử lý mảng và ma trận.</li>
            </ul>
            <p style="margin-top: 15px;">
                👉 Sử dụng thanh menu bên trên để chọn chức năng kiểm thử: <b>Ar1Chieu</b> (xử lý mảng 1 chiều) hoặc <b>Matrix</b> (xử lý ma trận 2 chiều).
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