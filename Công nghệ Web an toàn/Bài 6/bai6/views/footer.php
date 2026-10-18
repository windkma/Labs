    </div> <!-- Đóng container -->

    <footer class="text-center py-4 text-muted mt-5 border-top">
        <small>Học phần: Công nghệ Web an toàn - Bài tập 6 (Kiến trúc MVC đơn giản hóa)</small>
    </footer>

    <!-- Thư viện jQuery và Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Đoạn mã AJAX (jQuery) cực kỳ ngắn gọn và dễ hiểu -->
    <script>
        // 1. Thêm vào giỏ hàng bằng AJAX (Không cần tải lại trang)
        function addToCartAjax(productId) {
            $.post('index.php?url=cart/add', {
                product_id: productId,
                csrf_token: '<?php echo csrf_token(); ?>'
            }, function(res) {
                if (res.success) {
                    // Cập nhật số lượng trên icon giỏ hàng ở Menu
                    $('#cart-count').text(res.total);
                    alert('Đã thêm sản phẩm [' + res.name + '] vào giỏ hàng thành công!');
                }
            }, 'json');
        }

        // 2. Tìm kiếm nhanh (Live Search) bằng AJAX
        $('#search-box').on('input', function() {
            var keyword = $(this).val().trim();
            if (keyword.length > 1) {
                $.get('index.php?url=search', { q: keyword }, function(data) {
                    var html = '';
                    if (data.length > 0) {
                        data.forEach(function(p) {
                            html += '<a href="index.php?url=detail&id=' + p.id + '" class="list-group-item list-group-item-action">';
                            html += '<b>' + p.name + '</b> - <span class="text-danger">' + parseInt(p.price).toLocaleString() + ' đ</span>';
                            html += '</a>';
                        });
                    } else {
                        html = '<div class="list-group-item text-muted">Không tìm thấy sản phẩm nào!</div>';
                    }
                    $('#search-results').html(html).show();
                }, 'json');
            } else {
                $('#search-results').hide().empty();
            }
        });
    </script>
</body>
</html>
