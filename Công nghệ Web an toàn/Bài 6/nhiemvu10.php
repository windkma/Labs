<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xử lý chuyển đổi ngôn ngữ khi click nút
if (isset($_POST["btnLang"])) {
    $selected_lang = $_POST["btnLang"];
    if (in_array($selected_lang, ["english", "vietnamese"])) {
        $_SESSION["lang"] = $selected_lang;
    }
    $cur_page = $_GET['subpage'] ?? 'home';
    header("Location: nhiemvu10.php?subpage=" . urlencode($cur_page));
    exit();
}

// Ngôn ngữ mặc định
$lang = $_SESSION["lang"] ?? "vietnamese";

// DÙNG __DIR__ ĐỂ KHẮC PHỤC LỖI TÌM SAI ĐƯỜNG DẪN
$lang_file = __DIR__ . "/lang/" . $lang . ".php";

if (!file_exists($lang_file)) {
    die("<div style='padding:20px; color:red; font-family:sans-serif;'>
            <h3>Lỗi không tìm thấy file ngôn ngữ!</h3>
            <p>PHP đang tìm file tại đường dẫn tuyệt đối:</p>
            <code>" . htmlspecialchars($lang_file) . "</code>
            <p>Vui lòng tạo đúng thư mục <b>lang</b> và file <b>" . htmlspecialchars($lang) . ".php</b> tại đường dẫn trên.</p>
         </div>");
}

require_once $lang_file;
$pageTitle = 'Nhiệm vụ 10 - Website đa ngôn ngữ';
$pageClass = 'task-10';

include "includes/header.php";

$subpage = $_GET['subpage'] ?? 'home';
?>

<style>
.nv10-topbar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.nv10-lang-btn {
    padding: 5px 12px;
    border: 1px solid #007bff;
    background: #fff;
    color: #007bff;
    border-radius: 3px;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
}
.nv10-lang-btn.active {
    background: #007bff;
    color: #fff;
}
.nv10-lang-btn:hover {
    background: #0056b3;
    color: #fff;
}
.nv10-menu {
    background-color: #333;
    padding: 8px 12px;
    margin-bottom: 20px;
    border-radius: 4px;
}
.nv10-menu a {
    color: #fff;
    text-decoration: none;
    padding: 6px 14px;
    display: inline-block;
    font-weight: bold;
    font-size: 14px;
    text-transform: uppercase;
}
.nv10-menu a:hover, .nv10-menu a.active {
    background-color: #2196F3;
    border-radius: 3px;
}
.nv10-box {
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 25px;
    border-radius: 4px;
    min-height: 260px;
}
.nv10-form-table {
    width: 80%;
    margin: 10px auto;
    border-collapse: collapse;
}
.nv10-form-table td {
    padding: 8px;
    vertical-align: top;
}
.nv10-form-table input[type="text"],
.nv10-form-table input[type="email"],
.nv10-form-table input[type="date"],
.nv10-form-table input[type="password"],
.nv10-form-table textarea {
    width: 280px;
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}
.nv10-btn {
    padding: 6px 18px;
    background: #2196F3;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}
.nv10-btn:hover {
    background: #0b7dda;
}
.nv10-btn-gray {
    background: #777;
}
.nv10-btn-gray:hover {
    background: #555;
}
</style>

<!-- Thanh chọn ngôn ngữ: Tiếng Việt / English -->
<div class="nv10-topbar">
    <span><b>Language / Ngôn ngữ:</b></span>
    <form method="POST" action="nhiemvu10.php?subpage=<?php echo htmlspecialchars($subpage); ?>" style="display:inline;">
        <button type="submit" name="btnLang" value="vietnamese" class="nv10-lang-btn <?php echo ($lang === 'vietnamese') ? 'active' : ''; ?>">
            🇻🇳 <?php echo BTN_VIETNAMESE; ?>
        </button>
        <button type="submit" name="btnLang" value="english" class="nv10-lang-btn <?php echo ($lang === 'english') ? 'active' : ''; ?>">
            🇬🇧 <?php echo BTN_ENGLISH; ?>
        </button>
    </form>
</div>

<!-- Thanh Menu chính sử dụng hằng số -->
<div class="nv10-menu">
    <a href="nhiemvu10.php?subpage=home" class="<?php echo ($subpage == 'home') ? 'active' : ''; ?>"><?php echo HOME; ?></a>
    <a href="nhiemvu10.php?subpage=contact" class="<?php echo ($subpage == 'contact') ? 'active' : ''; ?>"><?php echo CONTACT; ?></a>
    <a href="nhiemvu10.php?subpage=introduction" class="<?php echo ($subpage == 'introduction') ? 'active' : ''; ?>"><?php echo INTRODUCTION; ?></a>
    <a href="nhiemvu10.php?subpage=login" class="<?php echo ($subpage == 'login') ? 'active' : ''; ?>"><?php echo LOGIN; ?></a>
</div>

<div class="nv10-box">
<?php
switch ($subpage) {
    // 1. FORM LIÊN HỆ
    case 'contact':
        $contact_success = false;
        if (isset($_POST["btnSubmitContact"])) {
            $contact_success = true;
        }
        ?>
        <h3 style="text-align: center; margin-bottom: 20px;"><?php echo CONTACT_TITLE; ?></h3>

        <?php if ($contact_success): ?>
            <div style="background: #e8f5e9; border: 1px solid #c8e6c9; padding: 15px; border-radius: 4px; max-width: 500px; margin: 0 auto;">
                <h4 style="color: #2e7d32; margin-bottom: 10px;">✔️ <?php echo ($lang === 'vietnamese' ? 'Gửi liên hệ thành công!' : 'Contact submitted successfully!'); ?></h4>
                <p><b><?php echo USERNAME; ?>:</b> <?php echo htmlspecialchars($_POST['txtUsername'] ?? ''); ?></p>
                <p><b><?php echo BIRTHDAY; ?>:</b> <?php echo htmlspecialchars($_POST['txtBirthday'] ?? ''); ?></p>
                <p><b><?php echo ADDRESS; ?>:</b> <?php echo htmlspecialchars($_POST['txtAddress'] ?? ''); ?></p>
                <p><b><?php echo EMAIL; ?>:</b> <?php echo htmlspecialchars($_POST['txtEmail'] ?? ''); ?></p>
                <p><b><?php echo PHONE; ?>:</b> <?php echo htmlspecialchars($_POST['txtPhone'] ?? ''); ?></p>
                <p><b><?php echo COMMENT; ?>:</b> <?php echo nl2br(htmlspecialchars($_POST['txtComment'] ?? '')); ?></p>
                <br>
                <a href="nhiemvu10.php?subpage=contact" class="nv10-btn">&laquo; <?php echo ($lang === 'vietnamese' ? 'Quay lại' : 'Back'); ?></a>
            </div>
        <?php else: ?>
            <form method="POST" action="nhiemvu10.php?subpage=contact">
                <table class="nv10-form-table">
                    <tr>
                        <td style="width: 25%;"><b><?php echo USERNAME; ?>:</b></td>
                        <td><input type="text" name="txtUsername" required></td>
                    </tr>
                    <tr>
                        <td><b><?php echo BIRTHDAY; ?>:</b></td>
                        <td><input type="date" name="txtBirthday"></td>
                    </tr>
                    <tr>
                        <td><b><?php echo ADDRESS; ?>:</b></td>
                        <td><input type="text" name="txtAddress"></td>
                    </tr>
                    <tr>
                        <td><b><?php echo EMAIL; ?>:</b></td>
                        <td><input type="email" name="txtEmail" required></td>
                    </tr>
                    <tr>
                        <td><b><?php echo PHONE; ?>:</b></td>
                        <td><input type="text" name="txtPhone"></td>
                    </tr>
                    <tr>
                        <td><b><?php echo COMMENT; ?>:</b></td>
                        <td><textarea name="txtComment" rows="3" cols="30"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="reset" value="<?php echo RESET; ?>" class="nv10-btn nv10-btn-gray">&nbsp;&nbsp;
                            <input type="submit" name="btnSubmitContact" value="<?php echo SUBMIT; ?>" class="nv10-btn">
                        </td>
                    </tr>
                </table>
            </form>
        <?php endif; ?>
        <?php
        break;

    // 2. GIỚI THIỆU
    case 'introduction':
        ?>
        <h3><?php echo INTRO_TITLE; ?></h3>
        <p style="margin-top: 15px; line-height: 1.8; font-size: 15px;">
            <?php echo INTRO_CONTENT; ?>
        </p>
        <?php
        break;

    // 3. ĐĂNG NHẬP
    case 'login':
        ?>
        <h3 style="text-align: center; margin-bottom: 20px;"><?php echo LOGIN_TITLE; ?></h3>
        <form method="POST" action="">
            <table class="nv10-form-table">
                <tr>
                    <td style="width: 25%;"><b><?php echo USERNAME; ?>:</b></td>
                    <td><input type="text" name="txtUser" required></td>
                </tr>
                <tr>
                    <td><b><?php echo PASSWORD; ?>:</b></td>
                    <td><input type="password" name="txtPass" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="reset" value="<?php echo RESET; ?>" class="nv10-btn nv10-btn-gray">&nbsp;&nbsp;
                        <input type="submit" value="<?php echo LOGIN; ?>" class="nv10-btn">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;

    // DEFAULT: TRANG CHỦ
    case 'home':
    default:
        ?>
        <h2><?php echo WELCOME; ?></h2>
        <p style="margin-top: 15px; line-height: 1.8; font-size: 15px;">
            <?php echo HOME_DESC; ?>
        </p>
        <div style="background: #e3f2fd; border-left: 4px solid #2196F3; padding: 12px 15px; margin-top: 20px;">
            <b>Cơ chế đa ngôn ngữ:</b>
            <p style="margin-top: 5px;">File cấu hình ngôn ngữ được nạp trực tiếp qua biến hằng tuyệt đối <code>__DIR__</code>. Khi click chuyển đổi, session lưu trạng thái và nạp file từ điển tương ứng trong thư mục <code>lang/</code>.</p>
        </div>
        <?php
        break;
}
?>
</div>

<?php
include "includes/footer.php";
?>
