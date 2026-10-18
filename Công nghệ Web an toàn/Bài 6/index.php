<?php
require_once __DIR__ . '/includes/tasks.php';
include __DIR__ . '/includes/header.php';
?>

<h1>Bài tập 4 & Bài tập 6: Công nghệ Web an toàn</h1>
<p class="welcome-text">Sinh viên: <strong>Phan Thế Phong</strong> - MSSV: <strong>AT200345</strong> - Lớp: <strong>AT20</strong></p>

<!-- Banner nổi bật dẫn vào Bài tập 6 - Nhiệm vụ 1 -->
<div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white; padding: 22px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); border: 1px solid #334155;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div style="max-width: 650px;">
            <span style="background: #e11d48; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">BÀI TẬP 6 - NHIỆM VỤ 1</span>
            <h2 style="margin: 8px 0 6px; color: #38bdf8; font-size: 20px; font-weight: 700;">Hệ Thống Web Bán Laptop MVC & Cơ Chế An Toàn Toàn Diện</h2>
            <p style="margin: 0; font-size: 13px; color: #cbd5e1; line-height: 1.5;">
                Đã kiện toàn theo chuẩn MVC (Router, Controllers, Models, Views), phân quyền RBAC (Admin/Customer), AJAX jQuery giỏ hàng & live search, Bootstrap 5 hiện đại, CKEditor richtext, chống SQL Injection (PDO Prepared), XSS, CSRF, Session Fixation, Bcrypt Hashing và Upload an toàn.
            </p>
        </div>
        <div>
            <a href="bai6/index.php" style="background: #2563eb; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; box-shadow: 0 4px 12px rgba(37,99,235,0.4); display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <span>Truy cập Bài tập 6 (Nhiệm vụ 1)</span> &raquo;
            </a>
        </div>
    </div>
</div>

<h3>Danh sách các bài tập cơ bản (Bài tập 4):</h3>
<div class="task-grid">
<?php foreach ($tasks as $number => $title): ?>
    <a class="task-link" href="nhiemvu<?php echo $number; ?>.php"><span><?php echo str_pad($number, 2, '0', STR_PAD_LEFT); ?></span><strong><?php echo escapeHtml($title); ?></strong></a>
<?php endforeach; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

