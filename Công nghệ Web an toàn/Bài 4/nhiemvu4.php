<?php
include "includes/header.php";

$subpage = $_GET['subpage'] ?? 'home';
?>

<style>
/* CSS bổ trợ cho Nhiệm vụ 4 */
.nv4-menu {
    background-color: #333;
    padding: 8px 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv4-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
}
.nv4-menu a:hover, .nv4-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv4-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 4px;
}
.nv4-table {
    width: 90%;
    margin: 0 auto;
    border-collapse: collapse;
}
.nv4-table td {
    padding: 8px;
    vertical-align: top;
}
.nv4-table input[type="text"],
.nv4-table input[type="password"],
.nv4-table select,
.nv4-table textarea {
    width: 100%;
    max-width: 320px;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}
.nv4-table textarea {
    resize: vertical;
}
.nv4-table input[type="submit"], 
.nv4-table input[type="reset"],
.nv4-table button {
    padding: 6px 16px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.nv4-table input[type="submit"]:hover,
.nv4-table button:hover {
    background: #0b7dda;
}
.nv4-table input[type="reset"] {
    background: #777;
}
.nv4-table input[type="reset"]:hover {
    background: #555;
}
.nv4-result-table {
    width: 90%;
    margin: 15px auto;
    border-collapse: collapse;
    background: #fff;
}
.nv4-result-table th, .nv4-result-table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
.nv4-result-table th {
    background: #f0f0f0;
    width: 35%;
}
</style>

<!-- Thanh menu phụ điều hướng Nhiệm vụ 4 -->
<div class="nv4-menu">
    <a href="nhiemvu4.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>">Home</a>
    <a href="nhiemvu4.php?subpage=register" class="<?php echo ($subpage == 'register' || $subpage == 'registerProcess') ? 'active' : ''; ?>">Register</a>
    <a href="nhiemvu4.php?subpage=contact1Page" class="<?php echo ($subpage == 'contact1Page') ? 'active' : ''; ?>">Contact1Page</a>
</div>

<div class="nv4-box">
<?php
switch ($subpage) {
    // ----------------------------------------------------------------------
    // 1. REGISTER: FORM ĐĂNG KÝ
    // ----------------------------------------------------------------------
    case 'register':
        ?>
        <h3 style="text-align: center; margin-bottom: 20px;">Form Đăng ký</h3>
        <form method="POST" action="nhiemvu4.php?subpage=registerProcess">
            <table class="nv4-table">
                <tr>
                    <td style="width: 25%;">Username:</td>
                    <td><input type="text" name="txtUsername" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="txtPassword" required></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        <label><input type="radio" name="radGender" value="Male" checked> Male</label>&nbsp;&nbsp;
                        <label><input type="radio" name="radGender" value="Female"> Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>
                        <select name="lstAddress" size="4">
                            <option value="Ha Noi" selected>Ha Noi</option>
                            <option value="TP. HCM">TP. HCM</option>
                            <option value="Hue">Hue</option>
                            <option value="Da Nang">Da Nang</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Enable Programming Language:</td>
                    <td>
                        <label><input type="checkbox" name="chkLang[]" value="PHP" checked> PHP</label>, &nbsp;
                        <label><input type="checkbox" name="chkLang[]" value="C#"> C#</label>, &nbsp;
                        <label><input type="checkbox" name="chkLang[]" value="Java"> Java</label>, &nbsp;
                        <label><input type="checkbox" name="chkLang[]" value="C++"> C++</label>
                    </td>
                </tr>
                <tr>
                    <td>Skill:</td>
                    <td>
                        <label><input type="radio" name="radSkill" value="Normal"> Normal</label><br>
                        <label><input type="radio" name="radSkill" value="Good"> Good</label><br>
                        <label><input type="radio" name="radSkill" value="Very Good" checked> Very Good</label><br>
                        <label><input type="radio" name="radSkill" value="Excellent"> Excellent</label>
                    </td>
                </tr>
                <tr>
                    <td>Note:</td>
                    <td>
                        <textarea name="taNote" rows="3" cols="35"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Marriage Status:</td>
                    <td>
                        <label><input type="checkbox" name="chkMarriageStatus" value="Da ket hon"> Đã kết hôn</label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="reset" value="Reset">&nbsp;&nbsp;
                        <input type="submit" name="btnRegister" value="Register">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // ----------------------------------------------------------------------
    // 2. REGISTER PROCESS: XỬ LÝ VÀ HIỂN THỊ KẾT QUẢ REGISTER
    // ----------------------------------------------------------------------
    case 'registerProcess':
        if (isset($_POST['btnRegister'])) {
            $name = htmlspecialchars($_POST["txtUsername"] ?? '');
            $pass = htmlspecialchars($_POST["txtPassword"] ?? '');
            $gender = htmlspecialchars($_POST["radGender"] ?? '');
            $address = htmlspecialchars($_POST["lstAddress"] ?? '');
            $skill = htmlspecialchars($_POST["radSkill"] ?? '');
            $note = nl2br(htmlspecialchars($_POST["taNote"] ?? ''));
            
            // Xử lý Checkbox đơn
            $marriageStatus = isset($_POST["chkMarriageStatus"]) ? "Đã kết hôn" : "Chưa kết hôn";

            // Xử lý Checkbox List (mảng)
            $languages = "";
            if (!empty($_POST["chkLang"]) && is_array($_POST["chkLang"])) {
                $languages = implode(", ", array_map('htmlspecialchars', $_POST["chkLang"]));
            } else {
                $languages = "Không có";
            }
            ?>
            <h3 style="text-align: center; color: #2e7d32;">Kết Quả Đăng Ký Thành Công</h3>
            <table class="nv4-result-table">
                <tr>
                    <th>Username</th>
                    <td><?php echo $name; ?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo $pass; ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo $gender; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $address; ?></td>
                </tr>
                <tr>
                    <th>Enable Programming Language</th>
                    <td><?php echo $languages; ?></td>
                </tr>
                <tr>
                    <th>Skill</th>
                    <td><?php echo $skill; ?></td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td><?php echo $note; ?></td>
                </tr>
                <tr>
                    <th>Marriage Status</th>
                    <td><?php echo $marriageStatus; ?></td>
                </tr>
            </table>
            <div style="text-align: center; margin-top: 15px;">
                <a href="nhiemvu4.php?subpage=register" style="color: #2196F3; text-decoration: none; font-weight: bold;">&laquo; Quay lại đăng ký</a>
            </div>
            <?php
        } else {
            echo "<p style='color: red; text-align: center;'>Chưa có dữ liệu gửi lên. Vui lòng quay lại form đăng ký.</p>";
            echo "<div style='text-align: center;'><a href='nhiemvu4.php?subpage=register'>Đến trang đăng ký</a></div>";
        }
        break;

    // ----------------------------------------------------------------------
    // 3. CONTACT 1 PAGE: XỬ LÝ VÀ HIỂN THỊ NGAY TRÊN 1 TRANG DUY NHẤT
    // ----------------------------------------------------------------------
    case 'contact1Page':
        $submitted = isset($_POST['btnContact']);
        ?>
        <h3 style="text-align: center; margin-bottom: 20px;">Form Liên hệ (Contact1Page)</h3>

        <?php if (!$submitted): ?>
            <!-- Hiển thị Form nếu chưa submit -->
            <form method="POST" action="nhiemvu4.php?subpage=contact1Page">
                <table class="nv4-table">
                    <tr>
                        <td style="width: 25%;">Username:</td>
                        <td><input type="text" name="txtUsername" required></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <label><input type="radio" name="radGender" value="Nam" checked> Male</label>&nbsp;&nbsp;
                            <label><input type="radio" name="radGender" value="Nữ"> Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>
                            <select name="lstAddress" size="4">
                                <option value="Ha Noi" selected>Ha Noi</option>
                                <option value="TP. HCM">TP. HCM</option>
                                <option value="Hue">Hue</option>
                                <option value="Da Nang">Da Nang</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Note:</td>
                        <td>
                            <textarea name="taNote" rows="3" cols="35"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="reset" value="Reset">&nbsp;&nbsp;
                            <input type="submit" name="btnContact" value="Contact">
                        </td>
                    </tr>
                </table>
            </form>
        <?php else: ?>
            <!-- Khi nhấn nút Contact, ẩn form đi và hiển thị kết quả -->
            <?php
            $c_name = htmlspecialchars($_POST['txtUsername'] ?? '');
            $c_gender = htmlspecialchars($_POST['radGender'] ?? '');
            $c_address = htmlspecialchars($_POST['lstAddress'] ?? '');
            $c_note = nl2br(htmlspecialchars($_POST['taNote'] ?? ''));
            ?>
            <div style="background: #e8f5e9; border: 1px solid #c8e6c9; padding: 15px; border-radius: 4px;">
                <h4 style="color: #2e7d32; margin-bottom: 10px;">Thông tin liên hệ đã nhận:</h4>
                <p><strong>Username:</strong> <?php echo $c_name; ?></p>
                <p><strong>Gender:</strong> <?php echo $c_gender; ?></p>
                <p><strong>Address:</strong> <?php echo $c_address; ?></p>
                <p><strong>Note:</strong> <?php echo $c_note; ?></p>
            </div>
            <div style="text-align: center; margin-top: 15px;">
                <a href="nhiemvu4.php?subpage=contact1Page" style="color: #2196F3; text-decoration: none; font-weight: bold;">Gửi liên hệ khác</a>
            </div>
        <?php endif; ?>
        <?php
        break;

    // ----------------------------------------------------------------------
    // DEFAULT: TRANG HOME CỦA NHIỆM VỤ 4
    // ----------------------------------------------------------------------
    case 'home':
    default:
        ?>
        <h2>Trang Home - Nhiệm vụ 4 (GetForm)</h2>
        <p>Mục tiêu bài thực hành: Thu thập và xử lý toàn diện các kiểu điều khiển trong Form HTML với PHP:</p>
        <ul style="margin-left: 20px; line-height: 1.8;">
            <li><strong>Text, Password, Textarea:</strong> Nhập văn bản một dòng, mật khẩu và văn bản nhiều dòng.</li>
            <li><strong>Radio Button List:</strong> Chọn một trong nhiều giá trị (Gender, Skill).</li>
            <li><strong>Select box:</strong> Hộp danh sách địa chỉ (Address).</li>
            <li><strong>Checkbox List (Mảng <code>chkLang[]</code>):</strong> Chọn nhiều ngôn ngữ lập trình.</li>
            <li><strong>Single Checkbox:</strong> Tình trạng hôn nhân (Marriage Status).</li>
            <li><strong>Contact1Page:</strong> Kỹ thuật submit và xử lý ẩn/hiện kết quả ngay trên cùng một trang.</li>
        </ul>
        <?php
        break;
}
?>
</div>

<?php
include "includes/footer.php";
?>