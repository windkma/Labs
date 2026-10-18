<?php require_once __DIR__ . '/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h4 class="text-center mb-3">Đăng Nhập Tài Khoản</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form action="index.php?url=login" method="POST">
                <!-- Cơ chế an toàn: Chèn Token chống tấn công CSRF -->
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập:</label>
                    <input type="text" name="username" id="txt_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu:</label>
                    <input type="password" name="password" id="txt_pass" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Đăng Nhập</button>
            </form>

            <!-- Nút tự điền tài khoản mẫu -->
            <div class="border p-2 bg-light small rounded text-center">
                <span>Điền nhanh tài khoản Admin: </span>
                <button type="button" class="btn btn-sm btn-outline-dark" onclick="$('#txt_user').val('admin'); $('#txt_pass').val('admin');">admin / admin</button>
            </div>
            
            <div class="text-center mt-3 small">
                Chưa có tài khoản? <a href="index.php?url=register">Đăng ký tại đây</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
