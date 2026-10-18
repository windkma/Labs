<?php require_once __DIR__ . '/header.php'; ?>

<h2 class="mb-4 text-primary">⚙️ Khu Vực Quản Trị Hệ Thống (Admin Panel)</h2>

<div class="row g-4 mb-5">
    <!-- 1. Form Thêm Laptop Mới -->
    <div class="col-lg-4">
        <div class="card p-3 shadow-sm">
            <h5 class="card-title text-success">➕ Thêm Laptop Mới</h5>
            <form action="index.php?url=admin/product/add" method="POST">
                <!-- CSRF Token -->
                <?php echo csrf_field(); ?>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Tên Laptop:</label>
                    <input type="text" name="name" class="form-control form-control-sm" required placeholder="Ví dụ: Asus Zenbook 14...">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Hãng sản xuất:</label>
                    <select name="category_id" class="form-select form-select-sm">
                        <?php foreach ($categories as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo e($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Đơn giá (VNĐ):</label>
                    <input type="number" name="price" class="form-control form-control-sm" required min="1000" step="1000" placeholder="15000000">
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Số lượng trong kho:</label>
                    <input type="number" name="sl" class="form-control form-control-sm" required value="10" min="0">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Mô tả cấu hình:</label>
                    <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="CPU, RAM, Ổ cứng, Màn hình..."></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-sm w-100">Lưu Sản Phẩm</button>
            </form>
        </div>
    </div>

    <!-- 2. Danh Sách Laptop Trong Kho -->
    <div class="col-lg-8">
        <div class="card p-3 shadow-sm">
            <h5 class="card-title">📦 Danh Sách Laptop Hiện Có (<?php echo count($products); ?> mẫu)</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên Laptop</th>
                            <th>Hãng</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?php echo $p['id']; ?></td>
                                <td><b><?php echo e($p['name']); ?></b></td>
                                <td><?php echo e($p['category_name'] ?? ''); ?></td>
                                <td class="text-danger fw-bold"><?php echo format_price($p['price']); ?></td>
                                <td><?php echo (int)$p['sl']; ?> máy</td>
                                <td class="text-center">
                                    <form action="index.php?url=admin/product/delete" method="POST" onsubmit="return confirm('Xóa sản phẩm này?');" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm py-0">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- 3. Quản Lý Người Dùng & Phân Quyền (RBAC) -->
<div class="card p-3 shadow-sm mb-4">
    <h5 class="card-title text-primary">👥 Quản Lý Người Dùng & Phân Quyền (RBAC: Admin / Customer)</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên Đăng Nhập</th>
                    <th>Họ và Tên</th>
                    <th>Vai Trò Hiện Tại</th>
                    <th class="text-center">Thao Tác Phân Quyền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><b><?php echo e($u['username']); ?></b></td>
                        <td><?php echo e($u['fullname']); ?></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span class="badge bg-danger">ADMIN</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">CUSTOMER</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($u['id'] !== $_SESSION['user']['id']): ?>
                                <form action="index.php?url=admin/user/toggle" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="btn btn-outline-dark btn-sm py-0">
                                        <?php echo ($u['role'] === 'admin') ? '⬇️ Đổi thành Customer' : '⬆️ Thăng cấp Admin'; ?>
                                    </button>
                                </form>
                            <?php else: ?>
                                <small class="text-muted"><i>(Tài khoản đang đăng nhập)</i></small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
