function setText(id, text) {
  var el = document.getElementById(id);
  if (el) el.textContent = text;
}

function openTest(event, testName) {
  var i;
  var contents = document.getElementsByClassName('test-content');

  for (i = 0; i < contents.length; i++) {
    contents[i].style.display = 'none';
    contents[i].classList.remove('active');
  }

  var buttons = document.getElementsByClassName('tab-btn');
  for (i = 0; i < buttons.length; i++) {
    buttons[i].classList.remove('active');
  }

  var selected = document.getElementById(testName);
  if (selected) {
    selected.style.display = 'block';
    selected.classList.add('active');
  }

  if (event && event.currentTarget) {
    event.currentTarget.classList.add('active');
  }
}

function validateLopForm() {
  var maLop = document.getElementById('malop').value.trim();
  var tenLop = document.getElementById('tenlop').value.trim();
  var khoaHoc = document.getElementById('khoahoc').value.trim();
  var gvcn = document.getElementById('gvcn').value.trim();
  var errorMessage = '';

  if (maLop === '') {
    errorMessage = 'Vui lòng nhập Mã Lớp.';
  } else if (maLop.length > 6) {
    errorMessage = 'Mã Lớp không được quá 6 ký tự.';
  } else if (tenLop === '') {
    errorMessage = 'Vui lòng nhập Tên Lớp.';
  } else if (tenLop.length > 50) {
    errorMessage = 'Tên Lớp không được quá 50 ký tự.';
  } else if (khoaHoc === '') {
    errorMessage = 'Vui lòng nhập Khóa Học.';
  } else if (isNaN(khoaHoc) || parseInt(khoaHoc, 10) <= 0) {
    errorMessage = 'Khóa Học phải là một số nguyên dương.';
  } else if (gvcn === '') {
    errorMessage = 'Vui lòng nhập tên Giáo Viên Chủ Nhiệm.';
  } else if (gvcn.length > 50) {
    errorMessage = 'Tên GVCN không được quá 50 ký tự.';
  }

  return showFormResult('lop-error-msg',errorMessage );
}

function validateHosoForm() {
  var mahoso = document.getElementById('mahoso').value.trim();
  var hoten = document.getElementById('hoten').value.trim();
  var ngaysinh = document.getElementById('ngaysinh').value.trim();
  var diachi = document.getElementById('diachi').value.trim();
  var lop = document.getElementById('lop').value.trim();
  var diemtoan = document.getElementById('diemtoan').value.trim();
  var diemly = document.getElementById('diemly').value.trim();
  var diemhoa = document.getElementById('diemhoa').value.trim();
  var errorMessage = '';

  if (mahoso === '') {
    errorMessage = 'Vui lòng nhập Mã hồ sơ.';
  } else if (mahoso.length > 8) {
    errorMessage = 'Mã hồ sơ không được quá 8 ký tự.';
  } else if (hoten === '') {
    errorMessage = 'Vui lòng nhập Họ tên.';
  } else if (hoten.length > 50) {
    errorMessage = 'Họ tên không được quá 50 ký tự.';
  } else if (ngaysinh === '') {
    errorMessage = 'Vui lòng nhập Ngày sinh.';
  } else if (diachi === '') {
    errorMessage = 'Vui lòng nhập Địa chỉ.';
  } else if (diachi.length > 150) {
    errorMessage = 'Địa chỉ không được quá 150 ký tự.';
  } else if (lop === '') {
    errorMessage = 'Vui lòng nhập Lớp.';
  } else if (lop.length > 6) {
    errorMessage = 'Tên Lớp không được quá 6 ký tự.';
  } else if (diemtoan === '') {
    errorMessage = 'Vui lòng nhập Điểm Toán.';
  } else if (isNaN(diemtoan) || parseFloat(diemtoan) < 0 || parseFloat(diemtoan) > 10) {
    errorMessage = 'Điểm Toán phải là số từ 0 đến 10.';
  } else if (diemly === '') {
    errorMessage = 'Vui lòng nhập Điểm Lý.';
  } else if (isNaN(diemly) || parseFloat(diemly) < 0 || parseFloat(diemly) > 10) {
    errorMessage = 'Điểm Lý phải là số từ 0 đến 10.';
  } else if (diemhoa === '') {
    errorMessage = 'Vui lòng nhập Điểm Hóa.';
  } else if (isNaN(diemhoa) || parseFloat(diemhoa) < 0 || parseFloat(diemhoa) > 10) {
    errorMessage = 'Điểm Hóa phải là số từ 0 đến 10.';
  }

  if (errorMessage === '') {
    var total = parseFloat(diemtoan) + parseFloat(diemly) + parseFloat(diemhoa);
    alert('Dữ liệu hợp lệ! Tổng điểm = ' + total.toFixed(2));
    return true;
  }

  return showFormResult('hoso-error-msg', errorMessage);
}

function showFormResult(id, errorMessage) {
  var errorDiv = document.getElementById(id);

  if (errorMessage !== '') {
    errorDiv.style.display = 'block';
    errorDiv.innerHTML = '⚠ ' + errorMessage;
    return false;
  }

  errorDiv.style.display = 'none';
  errorDiv.innerHTML = '';
  alert(document.getElementById('tenlop').value.trim());
  return true;
}

function chuanHoaHoTen(value) {
  var val = value.trim().replace(/\s+/g, ' ');
  if (val === '') return '';

  var arr = val.split(' ');
  for (var i = 0; i < arr.length; i++) {
    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1).toLowerCase();
  }

  return arr.join(' ');
}

function ganSuKienEnter() {
  var inputs = document.querySelectorAll('#frmDangKy input, #frmDangKy textarea');

  inputs.forEach(function (input, index) {
    input.onkeydown = function (event) {
      var evt = event || window.event;
      if (evt.keyCode === 13) {
        evt.preventDefault();
        if (inputs[index + 1]) inputs[index + 1].focus();
      }
    };
  });
}

function kiemTraVaGui() {
  var hopLe = true;
  var cacTruong = [
    { id: 'hoTen', msg: 'Chưa nhập họ tên' },
    { id: 'ngaySinh', msg: 'Chưa nhập ngày sinh' },
    { id: 'email', msg: 'Chưa nhập email' },
    { id: 'tenSuDung', msg: 'Chưa nhập tên sử dụng' },
    { id: 'matKhau', msg: 'Chưa nhập mật khẩu' },
    { id: 'nhapLaiMK', msg: 'Chưa nhập lại mật khẩu' }
  ];

  for (var i = 0; i < cacTruong.length; i++) {
    var el = document.getElementById(cacTruong[i].id);
    var span = document.getElementById('err-' + cacTruong[i].id);
    var val = el.value.trim();

    if (val === '' || (cacTruong[i].id === 'ngaySinh' && val === 'nn/tt/nnnn')) {
      span.innerHTML = cacTruong[i].msg;
      hopLe = false;
    } else if (span.innerHTML === cacTruong[i].msg) {
      span.innerHTML = '';
    }
  }

  var errEmail = document.getElementById('err-email').innerHTML;
  var errPass = document.getElementById('err-nhapLaiMK').innerHTML;

  if (hopLe && errEmail === '' && errPass === '') {
    alert('Đăng ký thành công!');
  } else {
    alert('Vui lòng kiểm tra lại thông tin trên Form!');
  }
}

function setupRegisterForm() {
  var txtHoTen = document.getElementById('hoTen');
  var txtNgaySinh = document.getElementById('ngaySinh');
  var txtEmail = document.getElementById('email');
  var txtNhapLai = document.getElementById('nhapLaiMK');

  if (!txtHoTen || !txtNgaySinh || !txtEmail || !txtNhapLai) return;

  txtHoTen.focus();
  ganSuKienEnter();

  txtHoTen.onblur = function () {
    this.value = chuanHoaHoTen(this.value);
  };

  txtNgaySinh.onfocus = function () {
    if (this.value === 'nn/tt/nnnn') {
      this.value = '';
      this.className = 'bat-buoc black-text';
    }
  };

  txtNgaySinh.onblur = function () {
    if (this.value.trim() === '') {
      this.value = 'nn/tt/nnnn';
      this.className = 'bat-buoc gray-text';
    }
  };

  txtNgaySinh.onkeyup = function (event) {
    var evt = event || window.event;
    if (evt.keyCode !== 8 && (this.value.length === 2 || this.value.length === 5)) {
      this.value = this.value + '/';
    }
  };

  txtEmail.onblur = function () {
    var regex = /^[\w.]+@[\w.]+\.\w+$/;
    document.getElementById('err-email').innerHTML = this.value !== '' && !regex.test(this.value)
      ? 'Email không đúng định dạng!'
      : '';
  };

  txtNhapLai.onblur = function () {
    var pass = document.getElementById('matKhau').value;
    document.getElementById('err-nhapLaiMK').innerHTML = this.value !== '' && pass !== this.value
      ? 'Mật khẩu gõ lại không đúng'
      : '';
  };
}

function setupEmployeeTable() {
  var selectAllCheckbox = document.getElementById('selectAll');
  var checkboxes = document.querySelectorAll('.rowcheckbox');
  var rows = document.querySelectorAll('.employeeTable tbody tr');

  if (!selectAllCheckbox || checkboxes.length === 0) return;

  selectAllCheckbox.addEventListener('change', function () {
    checkboxes.forEach(function (checkbox, index) {
      checkbox.checked = selectAllCheckbox.checked;
      updateRowHighlight(rows[index], checkbox.checked);
    });
  });

  checkboxes.forEach(function (checkbox, index) {
    checkbox.addEventListener('change', function () {
      updateRowHighlight(rows[index], checkbox.checked);
      updateSelectAll();
    });
  });

  rows.forEach(function (row, index) {
    row.addEventListener('click', function (event) {
      if (event.target.type === 'checkbox') return;
      checkboxes[index].checked = !checkboxes[index].checked;
      updateRowHighlight(row, checkboxes[index].checked);
      updateSelectAll();
    });
  });
}

function updateSelectAll() {
  var selectAllCheckbox = document.getElementById('selectAll');
  var checkboxes = document.querySelectorAll('.rowcheckbox');

  selectAllCheckbox.checked = Array.from(checkboxes).every(function (checkbox) {
    return checkbox.checked;
  });
}

function updateRowHighlight(row, isChecked) {
  if (!row) return;
  if (isChecked) row.classList.add('selected');
  else row.classList.remove('selected');
}

function setupTaskMenu() {
  var taskMenuItems = document.querySelectorAll('.task-menu li');
  var selectedTitleDisplay = document.getElementById('selectedtitle');

  if (!selectedTitleDisplay) return;

  taskMenuItems.forEach(function (item) {
    item.addEventListener('click', function () { 
      taskMenuItems.forEach(function (i) {
        i.classList.remove('selected');
      });

      this.classList.add('selected');
      selectedTitleDisplay.textContent = this.getAttribute('data-title');
    });
  });
}

function setupIframeTabs() {
  var tabs = document.querySelectorAll('.tab');
  var iframe = document.getElementById('tab-frame');

  if (!iframe || tabs.length === 0) return;

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) {
        t.classList.remove('active');
      });

      this.classList.add('active');
      iframe.src = this.getAttribute('data-url');
    });
  });

  tabs[1].click();
}

function toggleTree(toggleElement) {
  var parentLi = toggleElement.parentElement;
  var subList = parentLi.querySelector('.nested');

  if (subList) {
    subList.classList.toggle('active');
    toggleElement.textContent = subList.classList.contains('active') ? '-' : '+';
  }
}

function selectNode(nodeElement) {
  var allNodes = document.querySelectorAll('.tree-node');

  allNodes.forEach(function (node) {
    node.classList.remove('selected-node');
  });

  nodeElement.classList.add('selected-node');
}

var currentVal = '0';
var previousVal = null;
var currentOp = null;
var shouldResetScreen = false;

/*
  PHẦN TÙY CHỈNH KIỂU HIỂN THỊ MÁY TÍNH

  - true:  hiển thị toàn bộ phép tính, ví dụ 9+9=18.
  - false: chỉ hiển thị giá trị hiện tại như trạng thái ban đầu.

  Chỉ cần đổi true thành false hoặc ngược lại để chuyển giữa hai trạng thái.
*/
var showFullExpression = false;

/* Các biến bên dưới phục vụ trạng thái hiển thị toàn bộ phép tính. */
var displayExpression = '0';
var resultDisplayed = false;

function updateScreen() {
  var screen = document.getElementById('calc-screen');
  if (screen) {
    /* Chọn nội dung màn hình dựa trên trạng thái đã cấu hình ở trên. */
    screen.value = showFullExpression ? displayExpression : currentVal;
  }
}

function appendNumber(num) {
  /* Sau khi đã bấm "=", bấm một số sẽ tạo phép tính mới. */
  if (resultDisplayed) {
    currentVal = '0';
    previousVal = null;
    currentOp = null;
    shouldResetScreen = false;
    resultDisplayed = false;
  }

  if (currentVal === '0' || shouldResetScreen) {
    currentVal = num;
    shouldResetScreen = false;
  } else {
    currentVal += num;
  }

  /* Ghép số đang nhập vào phần phép tính đã có. */
  displayExpression = currentOp === null
    ? currentVal
    : previousVal + currentOp + currentVal;
  updateScreen();
}

function appendDot() {
  /* Dấu chấm sau kết quả cũng bắt đầu một phép tính mới. */
  if (resultDisplayed) {
    currentVal = '0';
    previousVal = null;
    currentOp = null;
    shouldResetScreen = false;
    resultDisplayed = false;
  }

  if (shouldResetScreen) {
    currentVal = '0.';
    shouldResetScreen = false;
  } else if (!currentVal.includes('.')) {
    currentVal += '.';
  }

  displayExpression = currentOp === null
    ? currentVal
    : previousVal + currentOp + currentVal;
  updateScreen();
}

function toggleSign() {
  if (currentVal !== '0') {
    currentVal = currentVal.startsWith('-') ? currentVal.substring(1) : '-' + currentVal;
    /* Cập nhật lại toàn bộ biểu thức sau khi đổi dấu số hiện tại. */
    displayExpression = currentOp === null
      ? currentVal
      : previousVal + currentOp + currentVal;
    resultDisplayed = false;
    updateScreen();
  }
}

function percent() {
  var val = parseFloat(currentVal);
  if (!isNaN(val)) {
    currentVal = String(val / 100);
    /* Thay giá trị hiện tại trong biểu thức bằng giá trị phần trăm. */
    displayExpression = currentOp === null
      ? currentVal
      : previousVal + currentOp + currentVal;
    resultDisplayed = false;
    updateScreen();
  }
}

function chooseOperator(op) {
  if (currentOp !== null && !shouldResetScreen) calculate();

  previousVal = currentVal;
  currentOp = op;
  shouldResetScreen = true;
  resultDisplayed = false;
  /* Hiện ngay toán tử vừa bấm, ví dụ: 9+. */
  displayExpression = previousVal + currentOp;
  updateScreen();
}

function calculate() {
  if (currentOp === null || previousVal === null) return;

  var num1 = parseFloat(previousVal);
  var num2 = parseFloat(currentVal);
  var result = 0;

  switch (currentOp) {
    case '+':
      result = num1 + num2;
      break;
    case '-':
      result = num1 - num2;
      break;
    case '*':
      result = num1 * num2;
      break;
    case '/':
      result = num2 === 0 ? 'Lỗi' : num1 / num2;
      break;
  }

  /* Giữ lại hai toán hạng và toán tử trước khi xóa trạng thái tính toán. */
  displayExpression = previousVal + currentOp + currentVal + '=' + String(result);
  currentVal = String(result);
  currentOp = null;
  previousVal = null;
  shouldResetScreen = true;
  resultDisplayed = true;
  updateScreen();
}

function clearAll() {
  currentVal = '0';
  previousVal = null;
  currentOp = null;
  shouldResetScreen = false;
  displayExpression = '0';
  resultDisplayed = false;
  updateScreen();
}

function clearEntry() {
  currentVal = '0';
  /* CE chỉ xóa số đang nhập, vẫn giữ lại phép tính và toán tử trước đó. */
  displayExpression = currentOp === null ? '0' : previousVal + currentOp + '0';
  resultDisplayed = false;
  updateScreen();
}

var sortDirection = {};

function sortByColumn(colIndex) {
  var productTable = document.getElementById('productTable');
  if (!productTable) return;

  var headers = productTable.querySelectorAll('th.sortable');
  var targetHeader = productTable.querySelector('th[data-col="' + colIndex + '"]');
  sortDirection[colIndex] = !sortDirection[colIndex];
  var isAsc = sortDirection[colIndex];
  var rows = Array.from(productTable.tBodies[0].rows);

  headers.forEach(function (h) {
    h.classList.remove('sorted-asc', 'sorted-desc');
  });

  if (targetHeader) {
    targetHeader.classList.add(isAsc ? 'sorted-asc' : 'sorted-desc');
  }

  rows.sort(function (rowA, rowB) {
    var valA = rowA.cells[colIndex].textContent.trim();
    var valB = rowB.cells[colIndex].textContent.trim();
    return isAsc ? valA.localeCompare(valB, 'vi') : valB.localeCompare(valA, 'vi');
  });

  rows.forEach(function (row, index) {
    row.cells[0].textContent = index + 1;
    productTable.tBodies[0].appendChild(row);
  });
}

function handleHeaderSort(colIndex) {
  sortByColumn(colIndex);
}

function setupProductSearch() {
  var productTable = document.getElementById('productTable');
  var searchInput = document.getElementById('searchInput');

  if (!productTable || !searchInput) return;

  searchInput.addEventListener('input', function () {
    var keyword = this.value.trim();
    var lowerKeyword = keyword.toLowerCase();
    var rows = productTable.tBodies[0].rows;

    for (var r = 0; r < rows.length; r++) {
      var row = rows[r];
      var isRowMatch = false;

      for (var i = 1; i < row.cells.length; i++) {
        var cell = row.cells[i];
        var originalText = cell.textContent;

        if (keyword !== '' && originalText.toLowerCase().includes(lowerKeyword)) {
          isRowMatch = true;
          var safeKeyword = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
          var regex = new RegExp('(' + safeKeyword + ')', 'gi');
          cell.innerHTML = originalText.replace(regex, '<span class="highlight">$1</span>');
        } else {
          cell.innerHTML = originalText;
        }
      }

      row.style.display = isRowMatch || keyword === '' ? '' : 'none';
    }
  });
}

var stickmanFrames = [
  'images/jump1.png',
  'images/jump2.png',
  'images/jump3.png',
  'images/jump4.png'
];
var currentStickmanIndex = 0;
var stickmanDirection = 1;
var stickmanTimer = null;

function showStickmanFrame(index) {
  var imgElement = document.getElementById('stickman-img');
  if (imgElement) imgElement.src = stickmanFrames[index];
}

function startJump() {
  if (stickmanTimer !== null) return;

  stickmanTimer = setInterval(function () {
    if (currentStickmanIndex === stickmanFrames.length - 1) {
      stickmanDirection = -1;
    } else if (currentStickmanIndex === 0) {
      stickmanDirection = 1;
    }

    currentStickmanIndex += stickmanDirection;
    showStickmanFrame(currentStickmanIndex);
  }, 10);
}

function stopJump() {
  if (stickmanTimer !== null) {
    clearInterval(stickmanTimer);
    stickmanTimer = null;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  setupRegisterForm();
  setupEmployeeTable();
  setupTaskMenu();
  setupIframeTabs();
  setupProductSearch();
  updateScreen();
  showStickmanFrame(0);
});

var button=document.getElementById('quizForm');
button.addEventListener('submit', function (e) {
  e.preventDefault();
  var dapAn = document.querySelector('input[name="lang"]:checked');
  var dapAn2 = document.querySelector('input[name="age"]:checked');
  if(dapAn && dapAn2) {
    alert('Bạn đã chọn đáp án: '+dapAn.value+' và '+dapAn2.value)
  }
  
  else {
    alert('Bạn chưa chọn đáp án nào');
  }
});

var button1=document.getElementById('quiz-sub2');
 button1.addEventListener('submit', function (e){
  e.preventDefault();
  var da = document.querySelector('input[name="math"]:checked');
  if(da){
    alert('Bạn đã chọn đáp án: '+da.value);
  }

  else {
    alert('Bạn chưa chọn đáp án nào');
  }
});