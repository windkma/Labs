<?php
require_once __DIR__ . '/includes/tasks.php';
include __DIR__ . '/includes/header.php';
?>

<h1>Bài tập 4: PHP và Cơ sở dữ liệu</h1>
<p class="welcome-text">Sinh viên: <strong>Phan Thế Phong</strong> - MSSV: <strong>AT200345</strong></p>
<div class="task-grid">
<?php foreach ($tasks as $number => $title): ?>
    <a class="task-link" href="nhiemvu<?php echo $number; ?>.php"><span><?php echo str_pad($number, 2, '0', STR_PAD_LEFT); ?></span><strong><?php echo escapeHtml($title); ?></strong></a>
<?php endforeach; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
