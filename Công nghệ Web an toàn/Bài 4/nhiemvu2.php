<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = isset($_GET['page']) ? $_GET['page'] : "register";

if (isset($_POST['submit'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['address'] = $_POST['address'];

    header("Location: ?page=result");
    exit();
}

include "includes/header.php";
?>

<style>
.container1{
    display:flex;
    min-height:300px;
}

.content1{
    flex:1;
    padding:20px;
}

.sidebar1{
    width:220px;
    background:#f2f2f2;
    border-left:2px solid #999;
    padding:20px;
}

.sidebar1 h3{
    text-align:center;
    margin-bottom:20px;
}

.sidebar1 a{
    display:block;
    padding:12px;
    margin-bottom:10px;
    background:#2196F3;
    color:white;
    text-decoration:none;
    text-align:center;
    border-radius:5px;
}

.sidebar1 a:hover{
    background:#0b7dda;
}

input,textarea{
    width:100%;
    padding:8px;
    margin:8px 0;
}

input[type=radio]{
    width: auto;
}

input[type=submit]{
    width:auto;
    background:green;
    color:white;
    border:none;
    padding:10px 20px;
    cursor:pointer;
}

table{
    border-collapse:collapse;
    width:70%;
}

table,th,td{
    border:1px solid black;
}

th,td{
    padding:10px;
}

.hello{
    position:relative;
    color:red;
    font-size:35px;
    font-weight:bold;
    animation:move 5s linear infinite;
}

@keyframes move{
    from{
        left:0;
    }
    to{
        left:500px;
    }
}
</style>

<div class="container1">

    <div class="content1">

<?php

if($page=="register"){
?>

<h2>REGISTER</h2>

<form method="post">

    Họ tên:
    <input type="text" name="name" required>

    Email:
    <input type="email" name="email" required>

    Giới tính:
    <br><br>

    <input type="radio" name="gender" value="Nam" checked> Nam
    <input type="radio" name="gender" value="Nữ"> Nữ

    <br><br>

    Địa chỉ:
    <textarea name="address"></textarea>

    <input type="submit" name="submit" value="Đăng ký">

</form>

<?php
}
elseif($page=="result"){
?>

<h2>KẾT QUẢ ĐĂNG KÝ</h2>

<table>

<tr>
<th>Họ tên</th>
<td><?php echo $_SESSION['name'] ?? ""; ?></td>
</tr>

<tr>
<th>Email</th>
<td><?php echo $_SESSION['email'] ?? ""; ?></td>
</tr>

<tr>
<th>Giới tính</th>
<td><?php echo $_SESSION['gender'] ?? ""; ?></td>
</tr>

<tr>
<th>Địa chỉ</th>
<td><?php echo $_SESSION['address'] ?? ""; ?></td>
</tr>

</table>

<?php
}
elseif($page=="calculate"){

$n=10;
$gt=1;

for($i=1;$i<=$n;$i++)
{
    $gt*=$i;
}

$r=10;

$dientich=pi()*$r*$r;

$thetich=(4/3)*pi()*pow($r,3);

?>

<h2>CALCULATE</h2>

<p><b>1. Giai thừa của 10:</b></p>

<p>10! = <?php echo $gt; ?></p>

<hr><br>

<p><b>2. Hình tròn bán kính 10</b></p>

<p>Diện tích = <?php echo round($dientich,2); ?></p>

<p>Thể tích khối cầu = <?php echo round($thetich,2); ?></p>

<hr><br>

<p><b>3. Chữ Hello chuyển động</b></p>

<div class="hello">
    Hello
</div>

<?php
}
?>

    </div>

    <div class="sidebar1">

        <h3>MENU</h3>

        <a href="?page=register">Register</a>

        <a href="?page=result">ResultRegister</a>

        <a href="?page=calculate">Calculate</a>

    </div>

</div>

<?php include "includes/footer.php"; ?>
