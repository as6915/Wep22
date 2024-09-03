<?php
$conn = new mysqli('localhost', 'اسم_المستخدم', 'كلمة_المرور', 'اسم_قاعدة_البيانات');

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    header('Location: verification.php?status=success'); 
    exit();
} else {
    header('Location: verification.php?status=error'); 
    exit();
}

$conn->close();
?>