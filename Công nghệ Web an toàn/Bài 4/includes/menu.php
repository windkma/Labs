<?php
require_once __DIR__ . '/tasks.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="menu">

    <div class="menu-group">
        <a href="index.php" class="menu-page">Trang chủ</a>
    </div>

    <div class="menu-group">
        <div class="menu-title">Bài tập</div>
        <ul class="menu-list">
            <?php foreach ($tasks as $taskNumber => $taskTitle): ?>
                <?php
                $taskLink = 'nhiemvu' . $taskNumber . '.php';
                $taskCode = 'NV' . str_pad($taskNumber, 2, '0', STR_PAD_LEFT);
                $activeClass = '';

                if ($currentPage === $taskLink) {
                    $activeClass = 'active';
                }
                ?>
                <li>
                    <a href="<?php echo $taskLink; ?>" class="<?php echo $activeClass; ?>">
                        <span class="task-number"><?php echo $taskCode; ?></span>
                        <span><?php echo escapeHtml($taskTitle); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
