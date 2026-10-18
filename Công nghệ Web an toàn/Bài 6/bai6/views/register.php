<?php require_once __DIR__ . '/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h4 class="text-center mb-3">Đăng Ký Thành Viên</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo e($error); ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo e($success); ?> <a href="index.php?url=login">Đăng nhập</a></div>
            <?php endif; ?>

            <form action="index.php?url=register" method="POST">
                <!-- Cơ chế an toàn: CSRF Token -->
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập (Username):</label>
                    <input type="text" name="username" class="form-control" required minlength="3">
                </div>
                <div class="mb-3">
                    <label class="form-label">Họ và tên:</label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu (Tối thiểu 6 ký tự):</label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhập lại mật khẩu:</label>
                    <input type="password" name="repassword" class="form-control" required minlength="6">
                </div>

                <button type="submit" class="btn btn-success w-100 mb-3">Đăng Ký</button>
            </form>

            <div class="text-center small">
                Đã có tài khoản? <a href="index.php?url=login">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
